const credentials = require('./../testCredential.json');
const data = require('./../testData.json');
const url = require('./../testUrl.json');

const Assert = require('../helpers/validators');
const Wait = require('../helpers/waiters');
const Help = require('../helpers/helpers');

const MenuActions = require('../Menu/menu_pa');
const UserSettingsActions = require('./UserSettings_pa');
const UserSettingsPage = require('./UserSettings_po');

const menu = new MenuActions();
const help = new Help();
const userSettingsSteps = new UserSettingsActions();
const userSettingsPage = new UserSettingsPage();

describe('Settings page tests', () => {


    it('should edit user password', () => {
        help.loginWithDefaultUser();

        menu.navigateToUserSettings();
        userSettingsSteps.enterNewPassword(credentials.changedPassword);
        userSettingsSteps.enterConfirmNewPassword(credentials.changedPassword);
        userSettingsSteps.saveChanges();
        browser.pause(500);

        Assert.notificationTextIs(data.profileUpdated);
        browser.reloadSession();
        browser.url(url.domain);
        help.loginWithCustomUser(credentials.email , credentials.changedPassword);
        
        menu.navigateToUserSettings();
        userSettingsSteps.enterNewPassword(credentials.password);
        userSettingsSteps.enterConfirmNewPassword(credentials.password);
        userSettingsSteps.saveChanges();
    });


});