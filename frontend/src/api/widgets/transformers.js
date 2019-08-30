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

export {
    devicesAndSystemsTransformer
};