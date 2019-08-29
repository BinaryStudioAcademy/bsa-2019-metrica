import {
    CHANGE_SELECTED_PERIOD,
    FETCH_WIDGET_INFO
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_WIDGET_DATA,
    SET_DATA_FETCHING,
    RESET_DATA_FETCHING
} from "./types/mutations";

import { getTimeByPeriod } from "@/services/periodService";
import { fetchDevicesAndSystemsData } from "@/api/widgets/devicesAndSystemsService";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, period) => {
        context.commit(SET_SELECTED_PERIOD, period);
    },

    [FETCH_WIDGET_INFO]: (context) => {
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;

        context.commit(SET_DATA_FETCHING);
        return fetchDevicesAndSystemsData(startDate.unix(), endDate.unix())
            .then(response => {
                context.commit(SET_WIDGET_DATA, response);
            })
            .finally(() => {
                context.commit(RESET_DATA_FETCHING);
            });
    }
};