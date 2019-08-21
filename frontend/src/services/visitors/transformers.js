const buttonTransformer = (item) => {
    return {value: item.value};
};

const chartTransformer = (item) => {
    return {
        date: item.date,
        value:item.value
    };
};

const tableTransformer = (groupByParam, item) => {
    return {
        [groupByParam]: item.parameter_value,
        'visitors': item.visitors,
        'percentage': item.percentage
    };
};
export {
    buttonTransformer,
    chartTransformer,
    tableTransformer
};