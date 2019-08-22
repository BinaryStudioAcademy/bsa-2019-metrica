import moment from "moment";
const buttonTransformer = (item) => {
    return {value: item.value};
};

const chartTransformer = (item) => {
    return {
        date: moment.unix(item.date).format("DD/MM/YYYY H:mm:ss"),
        value: item.value
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