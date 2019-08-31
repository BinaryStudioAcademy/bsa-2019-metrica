import {
    FETCHING_ACTIVITY_DATA_ITEMS,
    FETCHING_ACTIVITY_CHART_DATA,
    RELOAD_ACTIVITY_DATA_ITEMS,
    CHANGE_SELECTED_PERIOD,
    FETCH_LINE_CHART_DATA,
    CHANGE_DATA_TYPE,
} from "./types/actions";
import {
    RESET_LINE_CHART_FETCHING,
    SET_LINE_CHART_FETCHING,
    SET_LINE_CHART_DATA,
    SET_SELECTED_PERIOD,
    SET_DATA_TYPE,
    SET_ACTIVITY_DATA_ITEMS,
    SET_ACTIVITY_CHART_DATA
} from "./types/mutations";

import Moment from 'moment';
import {factoryVisitorsService} from '@/api/visitors/factoryVisitorsService';
import {pageViewsService} from '@/api/page_views/pageViewsService';
import {getTimeByPeriod} from '@/services/periodService';
import { extendMoment } from 'moment-range';

const moment = extendMoment(Moment);

export default {
    [CHANGE_DATA_TYPE]: (context, payload) => {
        context.commit(SET_DATA_TYPE, payload);
        context.dispatch(FETCH_LINE_CHART_DATA);
    },
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        if (context.state.selectedPeriod === payload.value) {
            return;
        }
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_LINE_CHART_DATA);
    },
    [FETCH_LINE_CHART_DATA]: (context) => {
        context.commit(SET_LINE_CHART_FETCHING);
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;
        const dataToFetch = context.state.dataToFetch;

        return factoryVisitorsService.create(dataToFetch)
            .fetchChartValues(startDate.unix(), endDate.unix(), period.interval)
            .then(response => {
                context.commit(SET_LINE_CHART_DATA, response);
            })
            .finally(() => {
                context.commit(RESET_LINE_CHART_FETCHING);
            });
    },
    [FETCHING_ACTIVITY_DATA_ITEMS]: (context) => {
       const items = [
           {
               url:'link_1/juhy/kkk',
               visitorId:2,
               timeNotification:'2019-08-26 22:15:11'
           },
           {
               url:'link_2/juhy/kkk',
               visitorId:2,
               timeNotification:'2019-08-26 23:25:11'
           },
           {
               url:'link_2/juhy/kkk',
               visitorId:3,
               timeNotification:'2019-08-12 12:12:11'
           },
           {
               url:'link_1/juhy/kkk',
               visitorId:2,
               timeNotification:'2019-08-12 12:19:11'
           },
           {
               url:'link_2/juhy/kkk',
               visitorId:2,
               timeNotification:'2019-08-12 12:15:11'
           },
           {
               url:'link_2/juhy/kkk',
               visitorId:3,
               timeNotification:'2019-08-12 12:11:11'
           },
           {
               url:'link_1/juhy/kkk',
               visitorId:3,
               timeNotification:'2019-08-12 12:11:11'
           },
           {
               url:'link_1/juhy/kkk',
               visitorId:4,
               timeNotification:'2019-08-12 12:11:11'
           },
           ].sort( (a, b) => {
            return  a.timeNotification - b.timeNotification || a.url - b.url || a.visitorId - b.visitorId;
       });

       const result = [];
        items.forEach((element) => {
            if(result.length > 0) {
                if(!result.find( (item => item.url === element.url && item.visitorId === element.visitorId))) {
                    result.push(element);
                }
            } else {
                result.push(element);
            }
        });

        context.commit(SET_ACTIVITY_DATA_ITEMS, result);
    },
    [FETCHING_ACTIVITY_CHART_DATA]: (context) => {

        const startDay = moment().subtract(1, 'minute');
        const endDay = moment();

        pageViewsService.fetchChartValues(
            startDay.unix(),
            endDay.unix(),
            60
        ).then(response => {
            const range = moment().range(startDay, endDay);
            const arrayOfDates = Array.from(range.by('seconds'));
            const result = [];
            if(response.length > 0) {
                arrayOfDates.map((item) => {
                    const value = response.find(x =>
                        moment(moment(x.date, "DD/MM/YYYY H:mm:ss")).unix() === item.unix()
                    );
                    if(value) {
                        result.push(value.value);
                    } else {
                        result.push(0);
                    }
                });
            }
            context.commit(SET_ACTIVITY_CHART_DATA, result);
        }).catch((response) => {
            return Promise.reject(response);
        });
    },

    [RELOAD_ACTIVITY_DATA_ITEMS]: (context) => {
        const data = context.state.activityData.items.filter(item =>
            moment().diff(moment(item.timeNotification), 'minutes') < 5
        );
        context.commit(SET_ACTIVITY_DATA_ITEMS, data);
    },

};
