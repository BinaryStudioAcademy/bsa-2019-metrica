
const MenuPage = require('./menu_po');

const menu = new MenuPage();


class MenuActions {

    navigateToHome() {
        menu.home.click()
    }

    navigateToVisitors() {
        
        menu.audience.click();
        browser.pause(500)
        menu.visitors.click();
    }

    navigateToPageViews() {
      
        menu.audience.click();
        browser.pause(500)
        menu.pageViews.click()
    }
    
    navigateToGeoLocation() {
        
        menu.audience.click();
        browser.pause(500)
        menu.geoLocations.click()
    }

    navigateToBehaviour() {
        
        menu.behaviour.click()
    }

    navigateToSpeedOverview() {
        
        menu.speedOverview.click()
    }

    navigateToUserSettings() {
        menu.settings.click()
        browser.pause(500)
        menu.userSettings.click()
    }
    
    navigateToWebsiteSettings() {
        
        menu.settings.click()
        browser.pause(500)
        menu.websiteSettings.click()
    }
}

module.exports = MenuActions;
