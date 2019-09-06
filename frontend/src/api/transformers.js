import moment from "moment";

const buttonTransformer = (item) => {
    return {value: item.value};
};

const buttonTransformerToSeconds = (item) => {
    return {value: parseInt(item.value)/1000};
};

const buttonTransformerToPercent = (item) => {
    return {value: Math.round(Number(item.value)*100)+'%'};
};

const buttonTransformerToTime = (item) => {
    return {value: moment.utc(item.value*1000).format('HH:mm:ss')};
};

const chartTransformer = (item) => {
    return {
        date: item.date,
        value: item.value*1
    };
};

const chartTransformerToInt = (item) => {
    return {
        date: item.date,
        value: parseInt(item.value)
    };
};

const chartTransformerToPercent = (item) => {
    return {
        date: item.date,
        value: Math.round(Number(item.value)*100),
        units: '%'
    };
};

const chartTransformerToSeconds = (item) => {
    return {
        date: item.date,
        value: item.value/1000
    };
};

const tableTransformer = (item) => {
    return {
        'parameter': item.parameter,
        'parameter_value': item.parameter_value,
        'total': item.total,
        'percentage': item.percentage
    };
};

const tableTransformerPageViews = (item) => {
    return {
        'page_url': item.page_url,
        'page_title': item.page_title,
        'count_page_views': item.count_page_views,
        'bounce_rate': Math.round(item.bounce_rate*100)+'%',
        'exit_rate': item.exit_rate
    };
};

const tableTransformerPageTiming = (item) => {
    return {
        'name': item.parameter_value,
        'value': item.average_time / 1000
    };
};
export {
    buttonTransformer,
    buttonTransformerToPercent,
    buttonTransformerToTime,
    buttonTransformerToSeconds,
    chartTransformer,
    chartTransformerToInt,
    chartTransformerToPercent,
    chartTransformerToSeconds,
    tableTransformer,
    tableTransformerPageTiming,
    tableTransformerPageViews,
};