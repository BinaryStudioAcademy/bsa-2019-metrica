import {
    AVG_PAGE_LOAD_TIME,
    AVG_LOOKUP_TIME,
    AVG_SERVER_RESPONSE_TIME
} from "@/configs/page_timings/buttonTypes";
import {pageLoadService} from "./pageLoadService";
import {domainLookupService} from "./domainLookupService";
import {serverResponseService} from "./serverResponseService";

const create = (type) => {
    switch (type) {
        case AVG_PAGE_LOAD_TIME:
            return pageLoadService;
        case AVG_LOOKUP_TIME:
            return domainLookupService;
        case AVG_SERVER_RESPONSE_TIME:
            return serverResponseService;
    }
};

export const factoryPageTimingsService = {
    create
};