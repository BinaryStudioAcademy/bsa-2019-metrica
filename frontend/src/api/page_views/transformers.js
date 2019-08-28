
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
        'parameter': item.parameter,
        'parameter_value': item.parameter_value,
        'total': item.total,
        'percentage': item.percentage
    };
};
export {
    buttonTransformer,
    chartTransformer,
    tableTransformer
};