const PERIOD_TODAY = 'today';
const PERIOD_YESTERDAY = 'yesterday';
const PERIOD_LAST_WEEK = 'last_week';
const PERIOD_LAST_MONTH = 'last_month';
const PERIOD_LAST_QUARTAL = 'last_quartal';
const PERIOD_ALL = 'all_period';

export const DAYS_IN_WEEK = 7;
export const HOURS_IN_DAY = 24;
export const MINUTES_IN_HOUR = 60;
export const SECONDS_IN_MINUTE = 60;
export const MILLISECONDS = 1000;

const getTimeByPeriod = (period) => {

    let now = new Date();
    const hourInterval = SECONDS_IN_MINUTE * MINUTES_IN_HOUR;
    const year = now.getUTCFullYear();
    const month = now.getUTCMonth();
    const day = now.getUTCDate();
    const utcCurrentDate = timestampToDate(Date.now());
    const dayStartTimestamp = Date.UTC(year, month, day,0,0,0,0);


    if (period === PERIOD_TODAY){
        return createTime(hourInterval, timestampToDate(dayStartTimestamp), utcCurrentDate );
    }

    if (period === PERIOD_YESTERDAY){
        const startDateTimestamp = dayStartTimestamp - MILLISECONDS * hourInterval * HOURS_IN_DAY;
        const endDateTimestamp = dayStartTimestamp - 1;
        return createTime(hourInterval, timestampToDate(startDateTimestamp), timestampToDate(endDateTimestamp) );
    }

    if (period === PERIOD_LAST_WEEK){
        const startDateTimestamp = dayStartTimestamp - MILLISECONDS * hourInterval * HOURS_IN_DAY * DAYS_IN_WEEK;
        return createTime(hourInterval*HOURS_IN_DAY, timestampToDate(startDateTimestamp), utcCurrentDate );
    }

    if (period === PERIOD_LAST_MONTH){
        const startDateTimestamp = Date.UTC(year, month, 1,0,0,0,0);
        return createTime(hourInterval*HOURS_IN_DAY*DAYS_IN_WEEK, timestampToDate(startDateTimestamp), utcCurrentDate );
    }

    if (period === PERIOD_LAST_QUARTAL){
        const startDateTimestamp = Date.UTC(year, substructMonth(3), 1,0,0,0,0);
        return createTime(hourInterval*HOURS_IN_DAY*30, timestampToDate(startDateTimestamp), utcCurrentDate );
    }

    if (period === PERIOD_ALL){
        return createTime(hourInterval*HOURS_IN_DAY*30, NaN, utcCurrentDate );
    }
};

const createTime = (interval, startDate, endDate) => {
    return {
        interval,
        startDate,
        endDate
    };
};

const timestampToDate = timestamp => new Date(timestamp);

const periodService = {
    getTimeByPeriod
};

const substructMonth = monthCount => {
    let d = new Date();
    d.setUTCMonth(d.getUTCMonth() - monthCount);
    return d.getUTCMonth();
};

export default periodService;


