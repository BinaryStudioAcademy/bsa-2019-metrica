const SettingsPage = require('./UserSettings_po');
const page = new SettingsPage();

class SettingsActions {

    enterNewName(value) {
        page.nameInput.waitForDisplayed(2000);
        page.nameInput.clearValue();
        page.nameInput.setValue(value);
    }

    enterNewEmail(value) {
        page.emailInput.waitForDisplayed(2000);
        page.emailInput.clearValue();
        page.emailInput.setValue(value);
    }

    enterNewPassword(value) {
        page.newPasswordInput.waitForDisplayed(2000);
        page.newPasswordInput.setValue(value);
        
    }

    enterConfirmNewPassword(value){
        page.confirmNewPasswordInput.waitForDisplayed(2000);
        page.confirmNewPasswordInput.setValue(value);
    }
    
    saveChanges() {
        page.saveButton.waitForDisplayed(2000);
        page.saveButton.click();
    }
}

module.exports = SettingsActions;
