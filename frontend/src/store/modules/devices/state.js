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
                    percent: 25,
                    color: '#1BC3DA'
                },
                {
                    title: 'Other',
                    percent: 50,
                    color: '#67C208'
                }
            ],
        },
        {
            type: 'Devices',
            data: [
                {
                    title: 'Desktop',
                    percent: 20,
                    color: '#F03357'
                },
                {
                    title: 'Mobile',
                    percent: 70,
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