import {CHANGE_ACTIVITY_DATA_ITEMS, CHANGE_ACTIVITY_CHART_DATA} from "./types/actions";
import {SET_ACTIVITY_DATA_ITEMS, SET_ACTIVITY_CHART_DATA} from "./types/mutations";

export default {
    [CHANGE_ACTIVITY_DATA_ITEMS]: (context) => {
       let items = [
               {
                   url:'link_1/juhy/kkk',
                   visitorId:2,
                   timeNotification:'2019-08-12 12:15:11'
               },
               {
                   url:'link_2/juhy/kkk',
                   visitorId:2,
                   timeNotification:'2019-08-12 12:12:11'
               },
               {
                   url:'link_2/juhy/kkk',
                   visitorId:3,
                   timeNotification:'2019-08-12 12:12:11'
               },
               {
                   url:'link_1/juhy/kkk',
                   visitorId:2,
                   timeNotification:'2019-08-12 12:19:11'
               },
               {
                   url:'link_2/juhy/kkk',
                   visitorId:2,
                   timeNotification:'2019-08-12 12:15:11'
               },
               {
                   url:'link_2/juhy/kkk',
                   visitorId:3,
                   timeNotification:'2019-08-12 12:11:11'
               },
               {
                   url:'link_1/juhy/kkk',
                   visitorId:3,
                   timeNotification:'2019-08-12 12:11:11'
               },
               {
                   url:'link_1/juhy/kkk',
                   visitorId:4,
                   timeNotification:'2019-08-12 12:11:11'
               },
           ];
       let sortItems = items.sort(function (a, b) {
            return  a.timeNotification - b.timeNotification || a.url - b.url || a.visitorId - b.visitorId;
       });

       let result = [];
       sortItems.forEach((e1) => {
            if(result.length > 0) {
                if(!result.find( (p => p.url === e1.url && p.visitorId === e1.visitorId))) {
                    result.push(e1);
                }
            } else {
                result.push(e1);
            }
        });

        context.commit(SET_ACTIVITY_DATA_ITEMS, result);
    },
    [CHANGE_ACTIVITY_CHART_DATA]: (context) => {
        const data = [0, 10, 12, 5, 4, 0, 12];
        context.commit(SET_ACTIVITY_CHART_DATA, data);
    },

};
