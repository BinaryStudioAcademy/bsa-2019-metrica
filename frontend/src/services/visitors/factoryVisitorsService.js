import {
    AVG_SESSION,
    BOUNCE_RATE,
    NEW_VISITORS,
    PAGE_VIEWS,
    SESSIONS,
    TOTAL_VISITORS
} from "../../configs/visitors/buttonTypes";
import totalVisitorsService from "./totalVisitorsService";
import newVisitorsService from "./newVisitorsService";
import bounceRateService from "./bounceRateService";
import averangeSessionService from "./averangeSessionsService";
import sessionsService from "./sessionsService";
import visitsService from "./visitsService";

const create = (type) => {
    switch (type) {
        case TOTAL_VISITORS:
            return totalVisitorsService;
        case NEW_VISITORS:
            return newVisitorsService;
        case BOUNCE_RATE:
            return bounceRateService;
        case AVG_SESSION:
            return averangeSessionService;
        case SESSIONS:
            return sessionsService;
        case PAGE_VIEWS:
            return visitsService;
    }
};

const factoryVisitorsService = {
    create
};

export default factoryVisitorsService;