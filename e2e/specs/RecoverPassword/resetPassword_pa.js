const ResetPasswordPage = require('./resetPassword_po');


const resetPassword = new ResetPasswordPage();



class ResetPasswordActions {

    enterEmail(value) {

        resetPassword.emailField.setValue(value)
    }

    clickLoginButton() {
        
        resetPassword.resetPasswordButton.click();
    }
}

module.exports = ResetPasswordActions;
