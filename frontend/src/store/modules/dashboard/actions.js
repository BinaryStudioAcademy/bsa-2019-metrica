import {FETCHING_ACTIVITY_DATA_ITEMS, FETCHING_ACTIVITY_CHART_DATA} from "./types/actions";
import {SET_ACTIVITY_DATA_ITEMS, SET_ACTIVITY_CHART_DATA} from "./types/mutations";

export default {
    [FETCHING_ACTIVITY_DATA_ITEMS]: (context) => {
       const items = [
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
           ].sort( (a, b) => {
            return  a.timeNotification - b.timeNotification || a.url - b.url || a.visitorId - b.visitorId;
       });

       const result = [];
        items.forEach((element) => {
            if(result.length > 0) {
                if(!result.find( (item => item.url === element.url && item.visitorId === element.visitorId))) {
                    result.push(element);
                }
            } else {
                result.push(element);
            }
        });

        context.commit(SET_ACTIVITY_DATA_ITEMS, result);
    },
    [FETCHING_ACTIVITY_CHART_DATA]: (context) => {
        const data = [0, 10, 12, 5, 4, 0, 12];
        context.commit(SET_ACTIVITY_CHART_DATA, data);
    },

};
