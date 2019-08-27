import moment from 'moment';

export const period = {
    PERIOD_TODAY: 'today',
    PERIOD_YESTERDAY: 'yesterday',
    PERIOD_LAST_WEEK: 'last_week',
    PERIOD_LAST_MONTH: 'last_month',
    PERIOD_LAST_QUARTAL: 'last_quartal',
    PERIOD_ALL: 'all_period',
};

const currentDate = () => {
    return moment();
};

const getSubtractStartDate = (day) => {
    return moment().subtract('days', day).startOf('day');
};

const getSubtractEndDate = (day) => {
    return moment().subtract('days', day).endOf('day');
};

const getSubtractStartMonth = (month) => {
    return moment().subtract('months', month).startOf('day');
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

export const getTimeByPeriod = (value) => {
    let interval = null;
    let startDate = null;
    let endDate = null;
    switch (value) {
        case period.PERIOD_TODAY:
            interval = getHourInterval(1);
            startDate = getSubtractStartDate(0);
            endDate = getSubtractEndDate(0);
            break;
        case period.PERIOD_YESTERDAY:
            interval = getHourInterval(1);
            startDate = getSubtractStartDate(1);
            endDate = getSubtractEndDate(1);
            break;
        case period.PERIOD_LAST_WEEK:
            interval = getDayInterval(1);
            startDate = getSubtractStartDate(7);
            endDate = currentDate();
            break;
        case period.PERIOD_LAST_MONTH:
            interval = getWeekInterval(1);
            startDate = getSubtractStartMonth(1);
            endDate = currentDate();
            break;
        case period.PERIOD_LAST_QUARTAL:
            interval = getDayInterval(30);
            startDate = getSubtractStartMonth(3);
            endDate = currentDate();
            break;
        case period.PERIOD_ALL:
            interval = getDayInterval(30);
            startDate = moment(0);
            endDate = currentDate();
            break;
        default:
            throw 'This period is not defined';
    }

    return {
        interval,
        startDate,
        endDate
    };
};