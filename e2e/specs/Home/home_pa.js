const HomePage = require('./home_po');

const home = new HomePage();


class HomeActions {

    clickLogin(){
        home.loginButton.waitForDisplayed(5000);
        browser.pause(50);
        home.loginButton.click();
    }

    clickRegistration(){
        home.registrationButton.waitForDisplayed(5000);
        browser.pause(50);
        home.registrationButton.click();
    }
}

module.exports = HomeActions;
