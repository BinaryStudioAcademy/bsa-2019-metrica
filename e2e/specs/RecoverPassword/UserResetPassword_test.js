const credentials = require('./../testCredential.json');
const data = require('./../testData.json');
const url = require('./../testUrl.json');

const HomeActions = require('../Home/home_pa');
const LoginActions = require('../UserLogin/login_pa');
const ResetPasswordActions = require('./resetPassword_pa');
const ResetPasswordPage = require('./resetPassword_po');

const Assert = require('../helpers/validators');
const Wait = require('../helpers/waiters');

const homeSteps = new HomeActions();
const loginSteps = new LoginActions();
const resetPasswordSteps = new ResetPasswordActions();
const resetPasswordPage = new ResetPasswordPage();

describe('Reset password page tests', () => {

    it('should reset password with valid email', () => {
        
        homeSteps.clickLogin();
        loginSteps.clickForgotPasswordButton()
        resetPasswordSteps.enterEmail(credentials.email)
        resetPasswordSteps.clickLoginButton()
        browser.pause(500)

        Assert.expectedElementText(resetPasswordPage.messageArea , "Your reset password link was created. Check your email " +credentials.email +", please.")
        Assert.compareUrl(url.domain+url.resetPassword)
        

    });

    it('should not reset password with empty email', () => {
        homeSteps.clickLogin();
        loginSteps.clickForgotPasswordButton()
        resetPasswordSteps.enterEmail()
        resetPasswordSteps.clickLoginButton()

        Assert.expectedElementText(resetPasswordPage.emailErrorLable, data.emailIsRequiredLabel)
        Assert.compareUrl(url.domain+url.resetPassword)
    });

    it('should not reset password with invalid email', () => {
        homeSteps.clickLogin();
        loginSteps.clickForgotPasswordButton()
        resetPasswordSteps.enterEmail(credentials.invalidEmail)
        resetPasswordSteps.clickLoginButton()

        Assert.expectedElementText(resetPasswordPage.emailErrorLable, data.emailNotValidLabel)
        Assert.compareUrl(url.domain+url.resetPassword)

    });

    it('should not reset password with wrong email', () => {
        homeSteps.clickLogin();
        loginSteps.clickForgotPasswordButton()
        resetPasswordSteps.enterEmail(credentials.wrongEmail)
        resetPasswordSteps.clickLoginButton()

        Assert.expectedElementText(resetPasswordPage.errorText, data.wrongEmailResetNotification)
        Assert.compareUrl(url.domain+url.resetPassword)

    });

    
});