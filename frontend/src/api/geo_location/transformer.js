import moment from "moment";

const transformer = (item) => {
    return {
        'country': item.country,
        'all_visitors_count': item.all_visitors_count,
        'new_visitors_count': item.new_visitors_count,
        'sessions_count': item.sessions_count,
        'bounce_rate': `${item.bounce_rate}%`,
        'avg_session_time': moment.unix(item.avg_session_time).format("HH:mm:ss")
    };
};
export {
    transformer
};