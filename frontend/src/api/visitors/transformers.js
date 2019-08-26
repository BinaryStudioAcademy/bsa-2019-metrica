import moment from "moment";

const buttonTransformer = (item) => {
    return {value: item.value};
};

const chartTransformer = (item) => {
    return {
        date: moment.unix(item.date).format("DD/MM/YYYY H:mm:ss"),
        value: item.value,
        day: moment.unix(item.date).format("DD/MM/YY"),
        time: moment.unix(item.date).format("HH:mm"),
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