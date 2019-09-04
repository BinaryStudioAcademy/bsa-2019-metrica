import moment from "moment";

const chartTransformer = (item) => {
    return {
        date: moment.unix(item.date).format("DD/MM/YYYY H:mm:ss"),
        value: item.value
    };
};
export {
    chartTransformer,
};