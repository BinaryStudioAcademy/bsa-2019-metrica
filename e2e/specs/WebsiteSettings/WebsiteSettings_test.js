const credentials = require('./../testCredential.json');
const data = require('./../testData.json');
const url = require('./../testUrl.json');

const Assert = require('../helpers/validators');
const Wait = require('../helpers/waiters');
const Help = require('../helpers/helpers');

const MenuActions = require('../Menu/menu_pa');
const WebsiteSettingsActions = require('./WebsiteSettings_pa');
const WebsiteSettingsPage = require('./WebsiteSettings_po');

const menu = new MenuActions();
const help = new Help();
const websiteSettingsSteps = new WebsiteSettingsActions();
const websiteSettingsPage = new WebsiteSettingsPage();

describe('Website settings page tests', () => {

    it('should edit website name', () => {

        help.loginWithDefaultUser();

        menu.navigateToWebsiteSettings();
        websiteSettingsSteps.enterName(credentials.newWebsiteName);
        websiteSettingsSteps.saveChanges();
        

        Assert.expectedElementText(websiteSettingsPage.nameLabel, data.websiteNameSaved);
        Assert.expectedFieldText(websiteSettingsPage.nameInput, credentials.newWebsiteName);
       
    });

    it('should not edit website with empty name', () => {

        help.loginWithDefaultUser();

        menu.navigateToWebsiteSettings();
        websiteSettingsSteps.enterName();
        websiteSettingsSteps.saveChanges();


        Assert.expectedElementText(websiteSettingsPage.nameLabel, data.websiteNameIsRequiredLabel);
       
    });
});