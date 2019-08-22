import {
    PAGE_VIEWS,
    UNIQUE_PAGE_VIEWS,
    ACTIVE_USERS,
    BOUNCE_RATE
} from '../../../configs/page_views/buttonTypes.js';

export default {
    selectedPeriod: 'last_week',
    buttonData: {
        [PAGE_VIEWS]: {
            value: 0,
            isFetching: false
        },
        [UNIQUE_PAGE_VIEWS]: {
            value: 0,
            isFetching: false
        },
        [ACTIVE_USERS]: {
            value: 0,
            isFetching: false
        },
        [BOUNCE_RATE]: {
            value: 0,
            isFetching: false
        },
    },
    activeButton: PAGE_VIEWS
};
