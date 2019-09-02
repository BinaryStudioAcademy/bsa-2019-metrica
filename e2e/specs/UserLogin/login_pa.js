const LoginPage = require('./login_po');


const login = new LoginPage();



class LoginActions {

    enterEmail(value) {
        login.emailField.waitForDisplayed(5000);
        login.emailField.setValue(value);
    }
    
    enterPassword(value) {
        login.passwordField.waitForDisplayed(2000);
        login.passwordField.setValue(value);
    }

    
    clickLoginButton() {
        login.loginButton.waitForDisplayed(2000);
        login.loginButton.click();
    }
    

    clickForgotPasswordButton(){
        login.forgotPasswordButton.waitForDisplayed(2000);
        login.forgotPasswordButton.click();
    }

    clickViaGoogleButton() {
        login.viaGoogle.waitForDisplayed(2000);
        login.viaGoogle.click();
    }

    clickViaFacebookButton() {
        login.viaFacebook.waitForDisplayed(2000);
        login.viaFacebook.click();
    }
}

module.exports = LoginActions;
