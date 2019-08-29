
const buttonTransformer = (item) => {
    return {value: item.value};
};

const chartTransformer = (item) => {
    return {
        date: item.date,
        value: item.value
    };
};

const tableTransformer = (item) => {
    return {
        'page_url': item.page_url,
        'page_title': item.page_title,
        'count_page_views': item.count_page_views,
        'bounce_rate': item.bounce_rate,
        'exit_rate': item.exit_rate
    };
};
export {
    buttonTransformer,
    chartTransformer,
    tableTransformer
};