class SettingsPage {

    get nameInput () {return $('input[name="name"]')};
    get emailInput () {return $('input[name="email"]')};
    get newPasswordInput () {return $('//*/form/div[3]/div/div[1]/div[1]/input')};
    get confirmNewPasswordInput () {return $('//*/form/div[4]/div/div[1]/div[1]/input')};
    get saveButton () {return $('button.primary')};

    get nameErrorLable () {return $('//*/form/div[1]/div/div[2]/div/div/div')};
    get emailErrorLable () {return $('//*/form/div[2]/div/div[2]/div/div/div')};
    get passwordErrorLable () {return $('//*/form/div[3]/div/div[2]/div[1]/div/div')};
    get confirmPasswordErrorLable () {return $('//*/form/div[4]/div/div[2]/div[1]/div/div')};

};

module.exports = SettingsPage;

