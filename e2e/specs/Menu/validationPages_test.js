const credentials = require('../testCredential.json');
const data = require('../testData.json');
const url = require('../testUrl.json');

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
        
        Assert.compareUrl(url.domain + url.visitors);
    });

    it('should navigate to Page views page', () => {
        help.loginWithDefaultUser(); 

        menu.navigateToPageViews();

        Assert.compareUrl(url.domain + url.pageViews);
    });

    it('should navigate to Geo locations page', () => {
        help.loginWithDefaultUser(); 

        menu.navigateToGeoLocation();

        Assert.compareUrl(url.domain + url.geoLocations);
    });

    it('should navigate to Behaviour page', () => {
        help.loginWithDefaultUser(); 
        
        menu.navigateToBehaviour();

        Assert.compareUrl(url.domain + url.behaviour);
    });
    
    it('should navigate to Speed Overview page', () => {
        help.loginWithDefaultUser(); 
        
        menu.navigateToSpeedOverview();

        Assert.compareUrl(url.domain + url.speedOverview);
    });
        
    it('should navigate to User Settings page', () => {
        help.loginWithDefaultUser(); 
        
        menu.navigateToUserSettings();
      
        Assert.compareUrl(url.domain + url.userSettings);
    });

    it('should navigate to Website Settings page', () => {
        help.loginWithDefaultUser(); 
       
        menu.navigateToWebsiteSettings();

        Assert.compareUrl(url.domain + url.websiteSettings);
    });
});
