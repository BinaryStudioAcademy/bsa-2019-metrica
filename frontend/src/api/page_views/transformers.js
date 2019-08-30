
const buttonTransformer = (item) => {
    return {value: item.value};
};

const buttonTransformerToPercent = (item) => {
    return {value: Math.round(Number(item.value)*100)+'%'};
};

const chartTransformer = (item) => {
    return {
        date: item.date,
        value: item.value
    };
};

const chartTransformerToPercent = (item) => {
    return {
        date: item.date,
        value: Math.round(Number(item.value)*100)
    };
};

const tableTransformer = (item) => {
    return {
        'page_url': item.page_url,
        'page_title': item.page_title,
        'count_page_views': item.count_page_views,
        'bounce_rate': Math.round(item.bounce_rate*100)+'%',
        'exit_rate': item.exit_rate
    };
};
export {
    buttonTransformer,
    chartTransformer,
    tableTransformer,
    buttonTransformerToPercent,
    chartTransformerToPercent
};