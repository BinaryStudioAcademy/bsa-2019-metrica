import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_GROUPED_PARAMETER,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_BUTTON_DATA,
    GET_EACH_BUTTON_DATA,
    CHANGE_FETCHED_TABLE_STATE,
    FETCH_TABLE_DATA,
    FETCH_CHART_PIE_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    SET_GROUPED_PARAMETER,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_BUTTON_DATA,
    GET_BUTTON_DATA,
    RESET_TABLE_FETCHING,
    SET_TABLE_FETCHING,
    SET_TABLE_DATA,
    SET_CHART_PIE_DATA,
    SET_CHART_DATA_FETCHING,
    RESET_CHART_DATA_FETCHING
} from "./types/mutations";

import {buttonTypes} from '@/configs/visitors/buttonTypes';
import {newVisitorsService} from "@/api/visitors/newVisitorsService";
import {totalVisitorsService} from "@/api/visitors/totalVisitorsService";
import {factoryVisitorsService} from '@/api/visitors/factoryVisitorsService';
import {getTimeByPeriod} from '@/services/periodService';

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
    },
    [CHANGE_ACTIVE_BUTTON]: (context, button) => {
        context.commit(SET_ACTIVE_BUTTON, button);
    },
    [CHANGE_FETCHED_BUTTON_STATE]: (context, data) => {
        if (data.value) {
            context.commit(SET_BUTTON_FETCHING, data.button);
        } else {
            context.commit(RESET_BUTTON_FETCHING, data.button);
        }
    },
    [FETCH_BUTTON_DATA]: (context, data) => {
        if (!data.value) {
            return;
        }
        context.commit(SET_BUTTON_FETCHING, data.button);

        const period = getTimeByPeriod(context.state.selectedPeriod);

        return factoryVisitorsService.create(data.button)
            .fetchButtonValue(period.startDate, period.endDate)
            .then(response => {
                context.commit(SET_BUTTON_DATA, data.button, response.data);
                context.commit(RESET_BUTTON_FETCHING, data.button);
            })
            .catch(err => {
                context.commit(RESET_BUTTON_FETCHING, data.button);
                throw err;
            });

    },
    [GET_EACH_BUTTON_DATA]: (context) => {
        let allData = [];
        buttonTypes.forEach(function (type) {
            allData.push(context.commit(GET_BUTTON_DATA, type), type);
        });
        return allData;
    },
    [CHANGE_GROUPED_PARAMETER]: (context, parameter) => {
        context.commit(SET_GROUPED_PARAMETER, parameter);
        context.commit(FETCH_TABLE_DATA, parameter);
    },
    [CHANGE_FETCHED_TABLE_STATE]: (context, value) => {

        if (value) {
            context.commit(SET_TABLE_FETCHING);
        } else {
            context.commit(RESET_TABLE_FETCHING);
        }
    },
    [FETCH_TABLE_DATA]: (context, data) => {
        if (!data.value) {
            return;
        }
        context.commit(SET_TABLE_FETCHING);

        getTimeByPeriod(context.state.selectedPeriod)
            .then(response => {
                return factoryVisitorsService.create(context.state.activeButton)
                    .fetchTableValues(response.startDate, response.endDate, data.groupedParameter);
            })
            .then(response => {
                context.commit(SET_TABLE_DATA, response.data);
                context.commit(RESET_TABLE_FETCHING);
            })
            .catch(err => {
                context.commit(RESET_TABLE_FETCHING);
                throw err;
            });
    },
    [FETCH_CHART_PIE_DATA]: (context) => {
        context.commit(SET_CHART_DATA_FETCHING);
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;
        let newVisitors = 0;
        let returnVisitors = 0;

        return newVisitorsService.fetchButtonValue(startDate.unix(), endDate.unix())
            .then(response => {
                newVisitors = response.value;
               return totalVisitorsService.fetchButtonValue(startDate.unix(), endDate.unix())
                    .then(response => {
                        returnVisitors = response.value;
                        newVisitors = (newVisitors/returnVisitors*100);
                        returnVisitors = 100 - newVisitors;
                        context.commit(SET_CHART_PIE_DATA, {newVisitors, returnVisitors});
                        context.commit(RESET_CHART_DATA_FETCHING);
                    });
            })
            .catch((response) => {
                context.commit(RESET_CHART_DATA_FETCHING);
                return Promise.reject(response);
            });
    },
};
