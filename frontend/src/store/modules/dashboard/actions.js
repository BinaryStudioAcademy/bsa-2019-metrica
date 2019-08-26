import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_FETCHED_LINE_CHART_STATE,
    FETCH_LINE_CHART_DATA,
    CHANGE_DATA_TYPE,
    FETCHING_ACTIVITY_DATA_ITEMS,
    FETCHING_ACTIVITY_CHART_DATA
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

import {factoryVisitorsService} from '@/api/visitors/factoryVisitorsService';
import {getTimeByPeriod} from '@/services/periodService';

export default {
    [CHANGE_DATA_TYPE]: (context, payload) => {
        context.commit(SET_DATA_TYPE, payload);
    },
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
    },
    [CHANGE_FETCHED_LINE_CHART_STATE]: (context, value) => {

        if (value) {
            context.commit(SET_LINE_CHART_FETCHING);
        } else {
            context.commit(RESET_LINE_CHART_FETCHING);
        }
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
                context.commit(RESET_LINE_CHART_FETCHING);
            })
            .catch(err => {
                context.commit(RESET_LINE_CHART_FETCHING);
                throw err;
            });
    },
    [FETCHING_ACTIVITY_DATA_ITEMS]: (context) => {
       const items = [
           {
               url:'link_1/juhy/kkk',
               visitorId:2,
               timeNotification:'2019-08-12 12:15:11'
           },
           {
               url:'link_2/juhy/kkk',
               visitorId:2,
               timeNotification:'2019-08-12 12:12:11'
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
        const data = [0, 10, 12, 5, 4, 0, 12];
        context.commit(SET_ACTIVITY_CHART_DATA, data);
    },
};
