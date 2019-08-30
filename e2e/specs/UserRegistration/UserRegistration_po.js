class RegistrationPage {

    get nameInput () {return $('input[name="name"]');};
    get emailInput () {return $('input[name="email"]');};
    get passwordInput () {return $('input[name="password"]');};
    get confirmPasswordInput () {return $('input[name="confirmPassword"]');};
    get signUpButton () {return $('button.primary');};

    get viaGoogle () {return $('button.google-social-btn');};
    get viaFacebook () {return $('button.facebook-social-btn');};

    get nameErrorLable () {return $('//*/form/div[1]/div/div[2]/div/div/div');};
    get emailErrorLable () {return $('//*/form/div[2]/div/div[2]/div/div/div');};
    get passwordErrorLable () {return $('//*/form/div[3]/div[1]/div/div[2]/div/div/div');};
    get confirmPasswordErrorLable () {return $('//*/form/div[3]/div[2]/div/div[2]/div/div/div');};

};

module.exports = RegistrationPage;

