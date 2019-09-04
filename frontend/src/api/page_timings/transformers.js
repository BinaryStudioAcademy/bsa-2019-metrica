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

const tableTransformer = (item) => {
    return {
        'name': item.parameter_value,
        'value': item.average_time
    };
};

export {
    chartTransformer,
    buttonTransformer,
    tableTransformer
};