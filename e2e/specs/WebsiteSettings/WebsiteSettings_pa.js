const SettingsPage = require('./WebsiteSettings_po');
const page = new SettingsPage();

class SettingsActions {


    enterName(value) {
        page.nameInput.waitForDisplayed(2000);
        page.nameInput.doubleClick();
        browser.keys("Delete");
        page.nameInput.setValue(value);
        
    }


    saveChanges() {
        page.updateButton.waitForDisplayed(2000);
        page.updateButton.click();
        browser.pause(500);
    }
}

module.exports = SettingsActions;
