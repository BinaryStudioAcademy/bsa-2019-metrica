class MenuPage {
    get home () {return $('//div[contains(., "Home")]')};

    get audience () {return $('//div[contains(text(), "Audience")]')};
    get visitors () {return $('//div[contains(text(), "Visitors")]')};
    get pageViews () {return $('//div[contains(text(), "Page Views")]')};
    get geoLocations () {return $('//div[contains(text(), "Geo Location")]')};

    get behaviour () {return $('//div[contains(text(), "Behaviour")]')};
    get speedOverview () {return $('//div[contains(text(), "Speed Overview")]')};

    get settings () {return $('//div[contains(text(), "Settings")]')};
    get userSettings () {return $('//div[contains(text(), "User")]')};
    get websiteSettings () {return $('//div[contains(text(), "Website")]')};

};

module.exports = MenuPage;

