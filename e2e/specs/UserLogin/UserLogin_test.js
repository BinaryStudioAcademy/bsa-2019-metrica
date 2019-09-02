const credentials = require('./../testCredential.json');
const data = require('./../testData.json');
const url = require('./../testUrl.json');

const HomeActions = require('../Home/home_pa');
const LoginActions = require('./login_pa');
const LoginPage = require('./login_po');

const Assert = require('../helpers/validators');
const Wait = require('../helpers/waiters');

const homeSteps = new HomeActions();
const loginSteps = new LoginActions();
const loginPage = new LoginPage();


describe('Login page tests', () => {

    it('should login with valid data', () => {
        
        homeSteps.clickLogin();

        loginSteps.enterEmail(credentials.email);
        loginSteps.enterPassword(credentials.password);
        loginSteps.clickLoginButton();
        browser.pause(1000);

        Assert.notificationTextIs(data.succesLoginNotification);
        Assert.compareUrl(url.domain + url.dashboard);  
    });

    it('should login via Google', () => {

        homeSteps.clickLogin();

        loginSteps.clickViaGoogleButton();
        browser.pause(500);

        Assert.compareDomain("https://accounts.google.com");

    });

    it('should login via Facebook', () => {
        homeSteps.clickLogin();

        loginSteps.clickViaFacebookButton();

        Assert.compareUrl("https://www.facebook.com/login.php");
       
    });

    it('should not login with wrong email', () => {

        homeSteps.clickLogin();

        loginSteps.enterEmail(credentials.wrongEmail);
        loginSteps.enterPassword(credentials.password);
        loginSteps.clickLoginButton();

        Assert.notificationTextIs(data.errorEmailNotification);
        Assert.compareUrl(url.domain + url.login);  

    });

    it('should not login with wrong password', () => {

        homeSteps.clickLogin();

        loginSteps.enterEmail(credentials.email);
        loginSteps.enterPassword(credentials.changedPassword);
        loginSteps.clickLoginButton();

        Assert.notificationTextIs(data.errorLoginNotification);
        Assert.compareUrl(url.domain + url.login);  
    });

    it('should not login with empty data', () => {

        homeSteps.clickLogin();

        loginSteps.enterEmail();
        loginSteps.enterPassword();
        loginSteps.enterEmail();
        
        Assert.buttonIsDisabled(loginPage.loginButton);
        Assert.expectedElementText(loginPage.emailErrorLable, data.emailIsRequiredLabel);
        Assert.expectedElementText(loginPage.passwordErrorLable, data.passwordIsRequiredLabel);
    });

    it('should not login with invalid email', () => {

        homeSteps.clickLogin();

        loginSteps.enterEmail(credentials.invalidEmail);
        loginSteps.enterPassword(credentials.password);
        loginSteps.enterEmail();
        
        Assert.buttonIsDisabled(loginPage.loginButton);
        Assert.expectedElementText(loginPage.emailErrorLable, data.emailNotValidLabel);
    });

    it('should not login with invalid password', () => {

        homeSteps.clickLogin();

        loginSteps.enterEmail(credentials.email);
        loginSteps.enterPassword(credentials.invalidPassword);
        loginSteps.enterEmail();
        
        Assert.buttonIsDisabled(loginPage.loginButton);
        Assert.expectedElementText(loginPage.passwordErrorLable, data.passwordNotValidLabel);
    });

    


});