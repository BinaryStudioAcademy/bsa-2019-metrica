import { period } from "@/services/periodService";

export default {
    selectedPeriod: period.PERIOD_LAST_WEEK,
    data: [
        {
            type: 'Systems',
            data: [
                {
                    title: 'Mac',
                    percent: 25,
                    color: '#3C57DE'
                },
                {
                    title: 'Windows',
                    percent: 65,
                    color: '#1BC3DA'
                },
                {
                    title: 'Other',
                    percent: 10,
                    color: '#67C208'
                }
            ],
        },
        {
            type: 'Devices',
            data: [
                {
                    title: 'Desktop',
                    percent: 25,
                    color: '#F03357'
                },
                {
                    title: 'Mobile',
                    percent: 65,
                    color: '#ff9900'
                },
                {
                    title: 'Tablet',
                    percent: 10,
                    color: '#FFD954'
                }
            ]
        }
    ],
    isFetching: false
};