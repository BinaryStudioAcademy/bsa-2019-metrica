const credentials = require('./../testCredential.json');
const data = require('./../testData.json');
const url = require('./../testUrl.json');

const temp = require('./../temp.json');

const HomeActions = require('../Home/home_pa');
const LoginActions = require('../UserLogin/login_pa');

const loginPage = new LoginActions();
const homePage = new HomeActions();

class HelpClass 
{

    loginWithDefaultUser() {

        homePage.clickLogin();

        loginPage.enterEmail(temp.email);
        loginPage.enterPassword(temp.password);
        loginPage.clickLoginButton();

        browser.pause(1000);
    }

    loginWithNewUser() {

        homePage.clickLogin();

        loginPage.enterEmail(temp.newEmail1);
        loginPage.enterPassword(temp.password);
        loginPage.clickLoginButton();

        browser.pause(1000);
    }

    loginWithCustomUser(email, password) {

        homePage.clickLogin();

        loginPage.enterEmail(email);
        loginPage.enterPassword(password);
        loginPage.clickLoginButton();

        browser.pause(1000);
    }

}

module.exports = HelpClass;