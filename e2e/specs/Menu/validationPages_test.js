const credentials = require('../testCredential.json');
const data = require('../testData.json');
const url = require('../testUrl.json');

const temp = require('./../temp.json');

const Assert = require('../helpers/validators');
const Wait = require('../helpers/waiters');
const Help = require('../helpers/helpers');

const MenuActions = require('./menu_pa');

const menu = new MenuActions();
const help = new Help();

describe('Validation pages tests', () => {

    it('should navigate to Visitors page', () => {

        help.loginWithDefaultUser(); 
                
        menu.navigateToVisitors();
        
        Assert.compareUrl(temp.domain + url.visitors);
    });

    it('should navigate to Page views page', () => {
        help.loginWithDefaultUser(); 

        menu.navigateToPageViews();

        Assert.compareUrl(temp.domain + url.pageViews);
    });

    it('should navigate to Geo locations page', () => {
        help.loginWithDefaultUser(); 

        menu.navigateToGeoLocation();

        Assert.compareUrl(temp.domain + url.geoLocations);
    });

    it('should navigate to Behaviour page', () => {
        help.loginWithDefaultUser(); 
        
        menu.navigateToBehaviour();

        Assert.compareUrl(temp.domain + url.behaviour);
    });
    
    it('should navigate to Speed Overview page', () => {
        help.loginWithDefaultUser(); 
        
        menu.navigateToSpeedOverview();

        Assert.compareUrl(temp.domain + url.speedOverview);
    });
        
    it('should navigate to User Settings page', () => {
        help.loginWithDefaultUser(); 
        
        menu.navigateToUserSettings();
      
        Assert.compareUrl(temp.domain + url.userSettings);
    });

    it('should navigate to Website Settings page', () => {
        help.loginWithDefaultUser(); 
       
        menu.navigateToWebsiteSettings();

        Assert.compareUrl(temp.domain + url.websiteSettings);
    });
});
