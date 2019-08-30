import {AVERAGE_TIME, BOUNCE_RATE, PAGE_VIEWS, UNIQUE_PAGE_VIEWS} from "../../configs/page_views/buttonTypes";
import {pageViewsService} from "./pageViewsService";
import {uniquePageViewsService} from "./uniquePageViewsService";
import {bounceRateService} from "./bounceRateService";
import {averageTimeService} from "./averageTimeService";

const create = type => {
    switch (type) {
        case PAGE_VIEWS:
            return pageViewsService;
        case UNIQUE_PAGE_VIEWS:
            return uniquePageViewsService;
        case BOUNCE_RATE:
            return bounceRateService;
        case AVERAGE_TIME:
            return averageTimeService;
    }
};

export const factoryPageViewsService = {
    create
};