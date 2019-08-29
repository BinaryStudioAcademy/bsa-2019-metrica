class ResetPasswordPage {
    
    get emailField () {return $('input[name="email"]')};
    
    get resetPasswordButton () {return $('button.primary')};

    get titleText () {return $('div.v-subheader')};   
    get errorText() {return $('div[role="alert"]')};

    get emailErrorLable (){return $('div.v-messages__message')};
    
    get messageArea (){return $('div.v-alert__content')};
};

module.exports = ResetPasswordPage;
