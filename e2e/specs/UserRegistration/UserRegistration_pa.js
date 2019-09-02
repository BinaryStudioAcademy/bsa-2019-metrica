const RegistrationPage = require('./UserRegistration_po');
const page = new RegistrationPage();

class RegistrationActions {

    enterName(value) {
       
        page.nameInput.setValue(value);
    }

    enterEmail(value) {
        
        page.emailInput.setValue(value);
    }

    enterPassword(value) {
       
        page.passwordInput.setValue(value);
    }

    enterConfirmPassword(value) {
       
        page.confirmPasswordInput.setValue(value);
    }

    createUser(){
        
        page.signUpButton.click();
    }
}
module.exports = RegistrationActions;
