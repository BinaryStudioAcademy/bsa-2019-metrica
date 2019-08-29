const assert = require('chai').assert;
const expect = require('chai').expect;
const {URL} = require('url');

class AssertHelper {

    notificationTextIs(expectedText) {

        browser.pause(300);
        const notification = $('span.notification-text');
        const actualText = notification.getText()
        assert.equal(actualText, expectedText, `Expected ${actualText} to be equal to ${expectedText}`);
    }

    expectedElementText(element, expectedText) {
        
        element.waitForDisplayed(3000);
        assert.equal(element.getText(), expectedText);
    }

   
    expectedFieldText(element, expectedText) {
        
        element.waitForDisplayed(3000);
        assert.equal(element.getValue(), expectedText);
    }
    
    compareUrl(expectedUrl) {
        browser.pause(500);
        const url = new URL(browser.getUrl());
        const actualUrl = url.hostname.toString() + url.pathname.toString();
        assert.equal('https://'+actualUrl, expectedUrl);
    }
    compareDomain(expectedUrl) {
        browser.pause(500);
        const url = new URL(browser.getUrl());
        const actualUrl = url.hostname.toString();
        assert.equal('https://'+actualUrl, expectedUrl);
    }


    buttonIsDisabled(locator) {

        const attr = locator.getAttribute('class');
        expect(attr, `${attr} doesn't include error class`).to.include("v-btn--disabled");
    }
}

module.exports = new AssertHelper();