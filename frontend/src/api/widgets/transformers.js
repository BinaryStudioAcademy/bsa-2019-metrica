import moment from "moment";
import { period } from "../../services/periodService";
import { BOUNCE_RATE } from "../../configs/visitors/buttonTypes";

const devicesAndSystemsTransformer = (data) => {
    return [
        {
            type: 'Systems',
            data: [
                {
                    title: 'Mac',
                    percent: data.system.mac,
                    color: '#3C57DE'
                },
                {
                    title: 'Windows',
                    percent: data.system.windows,
                    color: '#1BC3DA'
                },
                {
                    title: 'Other',
                    percent: data.system.others,
                    color: '#67C208'
                }
            ],
        },
        {
            type: 'Devices',
            data: [
                {
                    title: 'Desktop',
                    percent: data.device.desktop,
                    color: '#F03357'
                },
                {
                    title: 'Mobile',
                    percent: data.device.mobile,
                    color: '#ff9900'
                },
                {
                    title: 'Tablet',
                    percent: data.device.tablet,
                    color: '#FFD954'
                }
            ]
        }
    ];
};

function toFormat (interval) {
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
    const fromFormat = "DD/MM/YYYY H:mm:ss";
    return items.map(item => {
        console.log(dataToFetch, selectedPeriod);
        return {
            'date': moment(item.date, fromFormat).format(toFormat(selectedPeriod)),
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