import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_SELECTED_PARAMETER,
    FETCH_GEO_LOCATION_ITEMS
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_SELECTED_PARAMETER,
    SET_GEO_LOCATION_ITEMS
} from "./types/mutations";
import {getGeoLocationItems} from '@/api/geoLocation';
import {getTimeByPeriod} from '@/services/periodService';

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
    },
    [CHANGE_SELECTED_PARAMETER]: (context, parameter) => {
        context.commit(SET_SELECTED_PARAMETER, parameter);
    },
    [FETCH_GEO_LOCATION_ITEMS]: context => {
        const period = getTimeByPeriod(context.state.selectedPeriod);

        return getGeoLocationItems(period.startDate, period.endDate)
            .then(response => {
                context.commit(SET_GEO_LOCATION_ITEMS, response.data);
            })
            .catch(err => {
                throw err;
            });
    }
};
