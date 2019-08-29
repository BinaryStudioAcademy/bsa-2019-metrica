const HomePage = require('./home_po');

const home = new HomePage();


class HomeActions {

 clickLogin(){
    home.loginButton.waitForDisplayed(2000);
    home.loginButton.click()
 }

 clickRegistration(){
    home.registrationButton.waitForDisplayed(2000);
    home.registrationButton.click()
 }
}

module.exports = HomeActions;
