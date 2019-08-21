import moment from 'moment';

const getTimeByPeriod = (period) => {
    let interval = null;
    let startDate = null;
    let endDate = null;
    switch (period) {
        case 'today':
            interval = getHourInterval(1);
            startDate = currentDate();
            endDate = getSubtractEndDate(0);
            break;
        case 'yesterday':
            interval = getHourInterval(1);
            startDate = getSubtractStartDate(1);
            endDate = getSubtractEndDate(1);
            break;
        case 'last_week':
            interval = getDayInterval(1);
            startDate = getSubtractStartDate(7);
            endDate = currentDate();
            break;
        case 'last_month':
            interval = getWeekInterval(1);
            startDate = getSubtractStartMonth(1);
            endDate = currentDate();
            break;
        case 'last_quartal':
            interval = getDayInterval(30);
            startDate = getSubtractStartMonth(3);
            endDate = currentDate();
            break;
        case 'all_period':
            interval = getDayInterval(30);
            startDate = NaN;
            endDate = currentDate();
            break;
        default:
            throw 'This period is not defined';
    }

    return {
        interval: interval,
        startDate: startDate,
        endDate: endDate
    };
};

const currentDate = () => {
    return moment().format("DD-MM-YYYY HH:mm");
};

const getSubtractStartDate = (day) => {
    return moment().subtract('days', day).startOf('day').format("DD-MM-YYYY HH:mm");
};

const getSubtractEndDate = (day) => {
    return moment().subtract('days', day).endOf('day').format("DD-MM-YYYY HH:mm");
};

const getSubtractStartMonth = (month) => {
    return moment().subtract('months', month).startOf('day').format("DD-MM-YYYY HH:mm");
};

const getHourInterval = (hour) => {
    return moment.duration({h: hour}).asSeconds();
};

const getDayInterval = (day) => {
    return moment.duration({d: day}).asSeconds();
};

const getWeekInterval = (week) => {
    return moment.duration({w: week}).asSeconds();
};

const periodService = {
    getTimeByPeriod
};

export default periodService;
