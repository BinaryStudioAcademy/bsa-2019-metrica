const credentials = require('./../testCredential.json');
const data = require('./../testData.json');
const url = require('./../testUrl.json');

const temp = require('./../temp.json');

const HomeActions = require('../Home/home_pa');
const RegistrationActions = require('./UserRegistration_pa');
const RegistrationPage = require('./UserRegistration_po');

const Assert = require('../helpers/validators');
const Wait = require('../helpers/waiters');
const Help = require('../helpers/helpers');

const homeSteps = new HomeActions();
const registrationSteps = new RegistrationActions();
const registrationPage = new RegistrationPage();
const help = new Help();

describe('Registrations page tests', () => {

    it('should register with valid data', () => {
      
        homeSteps.clickRegistration();

        registrationSteps.enterName(credentials.name);
        registrationSteps.enterEmail(credentials.newEmail1);
        registrationSteps.enterPassword(temp.password);
        registrationSteps.enterConfirmPassword(temp.password);
        registrationSteps.createUser();

        
        Assert.notificationTextIs("You have been successfully registered! We sent account confirmation on your email " + credentials.newEmail1 +". Please, check your email");
        Assert.compareUrl(temp.domain+url.login);
    });

    it('should not register with empty field', () => {
        
        homeSteps.clickRegistration();

        registrationSteps.enterName();
        registrationSteps.enterEmail();
        registrationSteps.enterPassword();
        registrationSteps.enterConfirmPassword();
        registrationSteps.enterName();

        Assert.expectedElementText(registrationPage.nameErrorLable, data.nameIsRequiredLabel);
        Assert.expectedElementText(registrationPage.emailErrorLable, data.emailIsRequiredLabel);
        Assert.expectedElementText(registrationPage.passwordErrorLable, data.passwordIsRequiredLabel);
        Assert.expectedElementText(registrationPage.confirmPasswordErrorLable, data.passwordIsRequiredLabel);

        Assert.compareUrl(temp.domain+url.signup);
        Assert.buttonIsDisabled(registrationPage.signUpButton);
    });

    it('should not register with invalid email', () => {
       
        homeSteps.clickRegistration();

        registrationSteps.enterName(credentials.name);
        registrationSteps.enterEmail(credentials.invalidEmail);
        registrationSteps.enterPassword(temp.password);
        registrationSteps.enterConfirmPassword(temp.password);
        
        Assert.expectedElementText(registrationPage.emailErrorLable, data.emailNotValidLabel);
        Assert.buttonIsDisabled(registrationPage.signUpButton);
    });

    it('should not register with existing email', () => {
        
        homeSteps.clickRegistration();

        registrationSteps.enterName(credentials.name);
        registrationSteps.enterEmail(temp.email);
        registrationSteps.enterPassword(temp.password);
        registrationSteps.enterConfirmPassword(temp.password);
        registrationSteps.createUser();
        
        Assert.compareUrl(temp.domain+url.signup);
        Assert.notificationTextIs(data.wrongEmailNotification);
    });
    
    it('should not register with invalid password', () => {
        
        homeSteps.clickRegistration();

        registrationSteps.enterName(credentials.name);
        registrationSteps.enterEmail(credentials.newEmail2);
        registrationSteps.enterPassword(credentials.invalidPassword);
        registrationSteps.enterConfirmPassword(credentials.invalidPassword);
        
        Assert.expectedElementText(registrationPage.passwordErrorLable, data.passwordNotValidLabel);
        Assert.buttonIsDisabled(registrationPage.signUpButton);
    });

    it('should not register with wrong confirm password', () => {
        
        homeSteps.clickRegistration();

        registrationSteps.enterName(credentials.name);
        registrationSteps.enterEmail(credentials.newEmail2);
        registrationSteps.enterPassword(temp.password);
        registrationSteps.enterConfirmPassword(credentials.changedPassword);
    
        Assert.expectedElementText(registrationPage.confirmPasswordErrorLable, data.passwordNotMatch);
        Assert.buttonIsDisabled(registrationPage.signUpButton);
    });
});