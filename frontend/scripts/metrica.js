(() => {
    class requestService {
        post(url, data, headers = {}) {
            return fetch(url, {
                method: 'POST',
                mode: 'cors',
                headers: headers,
                body: JSON.stringify(data)
            });
        }
    }
    const state = {
        host_api: process.env.VUE_APP_API_URL,
        host: process.env.VUE_APP_URL,
        routes: {
            create_visitor: '/visitors',
            create_visit: '/visits',
            create_error: '/error-reports'
        }
    };
    window._metricaTracking = {
        endTime: undefined,
        configMetrica: undefined,
        initialize() {
            let token = this.getToken();
            if (token) {
                this.createVisit();
            } else {
                this.createVisitor(this.getTrackById())
                    .finally(() => this.createVisit());
            }

        },
        setObjectMetricaConf() {
            let metricaConfig = window._metricaTrackingConfig;
            if(!('_metricaTrackingConfig' in window)) {
                metricaConfig = [];
            }

            if(metricaConfig.length === 0) {
                metricaConfig.push(['dateStart', new Date()]);
                metricaConfig.push(['tracking_id', this.getTrackingIdFromUrl()]);
                metricaConfig.push(['spa', this.getSPAFromUrl()]);
            }

            if(metricaConfig[0].length < 2) {
                metricaConfig[0] = [];
                metricaConfig.push(['dateStart', new Date()]);
            }

            if(metricaConfig.length === 1 || metricaConfig[1].length < 2) {
                metricaConfig[1] = [];
                metricaConfig[1].push('tracking_id', this.getTrackingIdFromUrl());
            }

            if(metricaConfig.length === 2 || metricaConfig[2].length < 2) {
                metricaConfig[2] = [];
                metricaConfig[2].push('spa', this.getSPAFromUrl());
            }

            this.configMetrica = metricaConfig;
        },
        getScriptSRC() {
            return document.querySelector(`script[src^='${state.host}metrica.js?']`).src;
        },
        getTrackingIdFromUrl(){
            let result = (this.getScriptSRC() || '').match(/tracking_id=(\d+)/i);
            if (result === null)
                throw new Error('Tracking id not found');

            return result[1];
        },
        getSPAFromUrl(){
            return /spa=true/i.test(this.getScriptSRC() || '');
        },
        getObjectMetricaConf() {
            return this.configMetrica;
        },
        storage() {
            return window[this.isStorage()];
        },
        isStorage() {
            try {
                localStorage.setItem('test-local-storage', 1);
                localStorage.removeItem('test-local-storage');
                return 'localStorage';
            } catch (e) {
                return 'sessionStorage';
            }
        },
        getTrackById() {
            let trackingId = this.getObjectMetricaConf()[1][1];
            if(trackingId === undefined) {
                throw Error('Tracking id is not defined');
            }
            return trackingId;
        },
        getUserAgent() {
            return Helper.getPropByString(window, 'navigator.userAgent');
        },
        setToken(token) {
            try {
                this.storage().setItem('_metrica_visitor_token', token);
            } catch (err) {}
        },
        getToken() {
            if (this.storage().getItem('_metrica_visitor_token') !== null) {
                return this.storage().getItem("_metrica_visitor_token");
            }
            return null;
        },
        getPage() {
            return Helper.getPropByString(window, 'location.pathname');
        },
        getTitle() {
            return document.title || 'unknown';
        },
        getLanguage() {
            return Helper.getPropByString(window, 'navigator.language') ||
                Helper.getPropByString(window, 'navigator.userLanguage');
        },
        getDevice() {
            let device = 'unknown';
            let userDevice = Helper.getUserDevice();
            if (userDevice.desktop()) {
                device = 'desktop';
            } else if (userDevice.tablet()) {
                device = 'tablet';
            } else if (userDevice.mobile()) {
                device = 'mobile';
            }
            return device;
        },
        getResolutionWith() {
            return Helper.getPropByString(screen, 'width') ||
                Helper.getPropByString(window, 'innerWidth');
        },
        getResolutionHeight() {
            return Helper.getPropByString(screen, 'height') ||
                Helper.getPropByString(window, 'innerHeight');
        },
        getVisit() {
            const spa = this.getObjectMetricaConf()[2][1];
            let page_load_time = !spa ? this.elastedTime(this.getObjectMetricaConf()[0][1], this.endTime) : 0;
            return {
                visitor_token: this.getToken(),
                user_agent: this.getUserAgent(),
                page: this.getPage(),
                page_title: this.getTitle(),
                language: this.getLanguage(),
                device: this.getDevice(),
                resolution_width: this.getResolutionWith(),
                resolution_height: this.getResolutionHeight(),
                page_load_time: page_load_time,
            };
        },
        fetchWrapper(){
            return new requestService();
        },
        createVisitor(tracking_number) {
            let url = state.host_api + state.routes.create_visitor;
            let headers = {
                'Content-Type': 'application/json',
                'x-website': tracking_number
            };

            return this.fetchWrapper().post(url, {}, headers)
                .then((response) => {
                    return response.json();
                })
                .then((result) => {
                    this.setToken(result.data.token);
                });
        },
        createVisit() {
            let url = state.host_api + state.routes.create_visit;
            let headers = {
                'Content-Type': 'application/json',
                'x-visitor': 'Bearer ' + this.getToken()
            };
            let data = this.getVisit();
            return this.fetchWrapper().post(url, data, headers);
        },
        elastedTime(startTime, endTime) {
            if(!Helper.isValidDate(startTime) || !Helper.isValidDate(endTime)) {
                throw Error('Invalid date');
            }
            return endTime.getTime() - startTime.getTime();
        },
    };

    const Helper = {
        isString(value) {
            return typeof value === 'string' || value instanceof String;
        },
        isValidDate (date) {
            return date && Object.prototype.toString.call(date) === "[object Date]" && !isNaN(date);
        },
        getPropByString(obj, propString) {
            if (!propString)
                return obj;

            let prop,
                props = propString.split('.'),
                i = 0,
                iLen = props.length - 1;

            for (i; i < iLen; i++) {
                prop = props[i];
                let candidate = obj[prop];
                if (candidate !== undefined) {
                    obj = candidate;
                } else {
                    break;
                }
            }
            return obj[props[i]];
        },
        getUserDevice() {
            let device,
                find,
                userAgent;
            device = {};
            userAgent = this.getPropByString(window, 'navigator.userAgent');
            if (userAgent === undefined) {
                throw Error('Object\'s property is not defined');
            }
            if (!this.isString(userAgent)) {
                throw Error('Window navigation userAgent must be string');
            }
            userAgent = userAgent.toLowerCase();

            device.ios = () => {
                return device.iphone() || device.ipod() || device.ipad();
            };

            device.iphone = () => {
                return !device.windows() && find('iphone');
            };

            device.ipod = () => {
                return find('ipod');
            };

            device.ipad = () => {
                return find('ipad');
            };

            device.android = () => {
                return !device.windows() && find('android');
            };

            device.androidPhone = () => {
                return device.android() && find('mobile');
            };

            device.androidTablet = () => {
                return device.android() && !find('mobile');
            };

            device.blackberry = () => {
                return find('blackberry') || find('bb10') || find('rim');
            };

            device.blackberryPhone = () => {
                return device.blackberry() && !find('tablet');
            };

            device.blackberryTablet = () => {
                return device.blackberry() && find('tablet');
            };

            device.windows = () => {
                return find('windows');
            };

            device.windowsPhone = () => {
                return device.windows() && find('phone');
            };

            device.windowsTablet = () => {
                return device.windows() && (find('touch') && !device.windowsPhone());
            };

            device.fxos = () => {
                return (find('(mobile;') || find('(tablet;')) && find('; rv:');
            };

            device.fxosPhone = () => {
                return device.fxos() && find('mobile');
            };

            device.fxosTablet = () => {
                return device.fxos() && find('tablet');
            };

            device.meego = () => {
                return find('meego');
            };

            device.mobile = () => {
                return device.androidPhone() ||
                    device.iphone() ||
                    device.ipod() ||
                    device.windowsPhone() ||
                    device.blackberryPhone() ||
                    device.fxosPhone() ||
                    device.meego();
            };

            device.tablet = () => {
                return device.ipad() ||
                    device.androidTablet() ||
                    device.blackberryTablet() ||
                    device.windowsTablet() ||
                    device.fxosTablet();
            };

            device.desktop = () => {
                return !device.tablet() && !device.mobile();
            };

            find = (needle) => {
                return userAgent.indexOf(needle) !== -1;
            };

            return device;
        }
    };

    window.onerror = (errorMsg, errorUrl) => {
        console.log(errorMsg);
        const url = state.host_api + state.routes.create_error;
        const tracking_number = window._metricaTracking.getTrackById();
        const token = window._metricaTracking.getToken();
        let headers = {
            'Content-Type': 'application/json',
            'x-website': tracking_number,
        };
        let data = {
            message: errorUrl,
            stack_trace: url,
            page: window._metricaTracking.getPage(),
            page_title: window._metricaTracking.getTitle(),

        };

        if (token) {
            headers = {
                ...headers,
                ...{'x-visitor': 'Bearer ' + token}
            };
        }

        return this.fetchWrapper().post(url, data, headers);
    };

    const onDomReady = () => {
        window._metricaTracking.endTime = new Date();
        window._metricaTracking.initialize();
    };

    const onDomReadySPA = () => {
        window.onpopstate = () => window._metricaTracking.initialize();
    };

    window._metricaTracking.setObjectMetricaConf();

    const isSPA = window._metricaTracking.getObjectMetricaConf()[2][1];


    if (document.readyState !== 'complete') {
        window.onload = isSPA ? onDomReadySPA() : onDomReady();
    } else {
        isSPA ? onDomReadySPA() : onDomReady();
    }
})();
