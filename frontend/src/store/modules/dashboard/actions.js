import {
    FETCHING_ACTIVITY_DATA_ITEMS,
    FETCHING_ACTIVITY_CHART_DATA,
    RELOAD_ACTIVITY_DATA_ITEMS,
    CHANGE_SELECTED_PERIOD,
    FETCH_LINE_CHART_DATA,
    CHANGE_DATA_TYPE,
    REFRESH_ACTIVITY_DATA_ITEMS
} from "./types/actions";
import {
    RESET_LINE_CHART_FETCHING,
    SET_LINE_CHART_FETCHING,
    SET_LINE_CHART_DATA,
    SET_SELECTED_PERIOD,
    SET_DATA_TYPE,
    SET_ACTIVITY_DATA_ITEMS,
    SET_ACTIVITY_CHART_DATA,
    SET_BUTTON_FETCHING,
    RESET_BUTTON_FETCHING
} from "./types/mutations";

import Moment from 'moment';
import _ from "lodash";
import {getActivityDataItems} from '@/api/visitors/activeVisitorService';
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
        context.commit(SET_BUTTON_FETCHING);

        return getActivityDataItems().then(response => {
            response.sort( (a, b) => {
                return  a.date - b.date || a.visitor - b.visitor;
            });

            const result = [];
            response.forEach((element) => {
                if(!result.find( (item => item.url === element.url && item.visitor === element.visitor))) {
                    result.push(element);
                }
            });
            context.commit(SET_ACTIVITY_DATA_ITEMS, result);
            context.commit(RESET_BUTTON_FETCHING);
        }).catch(() => {
            context.commit(RESET_BUTTON_FETCHING);
        });
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

            let value = undefined;
            arrayOfDates.map((item) => {
                value = _.find(response,  (i) => {
                    return parseInt(i.date, 10) === item.unix();
                });
                if(value) {
                    result.push(parseInt(value.value, 10));
                }
                else {
                    result.push(0);
                }
            });
            const chunk = (arr, size) =>
                arr.reduce((acc, _, i) => (i % size)
                    ? acc : [...acc, (arr.slice(i, i + size)).reduce((a, b) => a + b, 0)], []);
            context.commit(SET_ACTIVITY_CHART_DATA, chunk(result, 6));
        });
    },

    [RELOAD_ACTIVITY_DATA_ITEMS]: (context) => {
        const data = context.state.activityData.items.filter(item =>
            moment().diff(moment(item.date), 'minutes') < 5
        );
        context.commit(SET_ACTIVITY_DATA_ITEMS, data);
    },

    [REFRESH_ACTIVITY_DATA_ITEMS]: (context, data) => {
        const items = [
            ...context.state
                .activityData
                .items
                .filter(item => {
                    return item.url !== data.url || item.visitor !== data.visitor;
                }),
            data,
        ];
        context.commit(SET_ACTIVITY_DATA_ITEMS, items);
    },
};
