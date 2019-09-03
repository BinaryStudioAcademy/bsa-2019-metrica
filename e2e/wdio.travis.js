const wdioBasic = require('./wdio.conf.js').config;

const travisConfig = {};

travisConfig.hostname = 'seleniumapp';
travisConfig.path = '/wd/hub';
travisConfig.capabilities = [{
    maxInstances: 1,
    browserName: 'chrome',
    'goog:chromeOptions': {
        'args': [ '--disable-extensions', '--headless', '--disable-gpu', '--no-sandbox', '--disable-dev-shm-usage', '--remote-debugging-port=9222' ]
    },
    acceptInsecureCerts: true
}];
travisConfig.beforeTest = function (test) {
    browser.maximizeWindow();
    browser.url('https://web.local');
};
travisConfig.connectionRetryTimeout = 5000;

exports.config = Object.assign({}, wdioBasic, travisConfig);
