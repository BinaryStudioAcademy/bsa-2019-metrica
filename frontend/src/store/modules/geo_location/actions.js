import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_SELECTED_PARAMETER,
    FETCH_GEO_LOCATION_ITEMS
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_SELECTED_PARAMETER,
    SET_GEO_LOCATION_ITEMS,
    SET_IS_FETCHING,
    RESET_IS_FETCHING
} from "./types/mutations";
import {getGeoLocationItems} from '@/api/geo_location/geoLocationItemsService';
import {getTimeByPeriod} from '@/services/periodService';

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.commit(SET_IS_FETCHING);
        context.dispatch(FETCH_GEO_LOCATION_ITEMS);
    },
    [CHANGE_SELECTED_PARAMETER]: (context, parameter) => {
        context.commit(SET_SELECTED_PARAMETER, parameter);
    },
    [FETCH_GEO_LOCATION_ITEMS]: context => {
        const period = getTimeByPeriod(context.state.selectedPeriod);

        period.startDate = period.startDate.unix();
        period.endDate = period.endDate.unix();

        return getGeoLocationItems(period.startDate, period.endDate)
            .then(geoLocationItems => {
                context.commit(SET_GEO_LOCATION_ITEMS, geoLocationItems);
                context.commit(RESET_IS_FETCHING);
            });
    }
};
