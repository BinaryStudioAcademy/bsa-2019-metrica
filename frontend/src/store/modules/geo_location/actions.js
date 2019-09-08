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
        context.dispatch(FETCH_GEO_LOCATION_ITEMS);
    },
    [CHANGE_SELECTED_PARAMETER]: (context, parameter) => {
        context.commit(SET_SELECTED_PARAMETER, parameter);
    },
    [FETCH_GEO_LOCATION_ITEMS]: context => {
        context.commit(SET_IS_FETCHING);

        const period = getTimeByPeriod(context.state.selectedPeriod);
        const id = context.rootState.website.selectedWebsite.id;

        return getGeoLocationItems(period.startDate.unix(), period.endDate.unix(), id)
            .then(geoLocationItems => context.commit(SET_GEO_LOCATION_ITEMS, geoLocationItems))
            .finally(() => context.commit(RESET_IS_FETCHING));
    }
};
