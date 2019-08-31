import moment from "moment";
import { period } from "../../services/periodService";
import { BOUNCE_RATE } from "../../configs/visitors/buttonTypes";

function transformSytems(systemsData) {
    const colors = ['#3C57DE', '#1BC3DA', '#67C208'];
    let percent = 0;
    let systems = systemsData.map((item, index) => {
        percent += Math.round(item.percent);
        return {
            title: item.name,
            percent: Math.round(item.percent),
            color: colors[index]
        };
    });
    if (systems.length === 2) {
        systems.push({
            title: 'Other',
            percent: 100 - percent,
            color: colors[2]
        });
    }
    return systems;
}

function transformDevices(devicesData) {
    const colors = ['#F03357', '#ff9900', '#FFD954'];
    let percent = 0;
    return devicesData.map((item, index) => {
        percent += Math.round(item.percent);
        return {
            title: item.name,
            percent: index === 2 ? 100 - percent : Math.round(item.percent),
            color: colors[index]
        };
    });
}

const devicesAndSystemsTransformer = (devicesData, systemsData) => {
    return [
        {
            type: 'Systems',
            data: transformSytems(systemsData)
        },
        {
            type: 'Devices',
            data: transformDevices(devicesData)
        }
    ];
};

function toDateStringFormat (interval) {
    switch (interval) {
        case period.PERIOD_TODAY:
        case period.PERIOD_YESTERDAY:
            return "HH:mm";
        case period.PERIOD_LAST_WEEK:
        case period.PERIOD_LAST_MONTH:
            return "MM/DD";
        default:
            return "MM/YYYY";
    }
}

const chartDataTransformer = (items, dataToFetch, selectedPeriod) => {
    const fromDateStringFormat = "DD/MM/YYYY H:mm:ss";
    return items.map(item => {
        return {
            'date': moment(item.date, fromDateStringFormat).format(toDateStringFormat(selectedPeriod)),
            'value': dataToFetch !== BOUNCE_RATE
                ? item.value
                : `${Math.round(item.value * 100)}%`
        };
    });
};

export {
    devicesAndSystemsTransformer,
    chartDataTransformer
};