class LoginPage {
    
    get emailField () {return $('input[name="email"]');}
    get passwordField () {return $('input[name="password"]');}
    get loginButton () {return $('button.primary');}

    get forgotPasswordButton () {return $('a[href="/reset-password"]');}
    
    get titleText () {return $('div.v-subheader');}   
    
    get viaGoogle () {return $('button.google-social-btn');}
    get viaFacebook () {return $('button.facebook-social-btn');}

    get emailErrorLable () {return $('//*/form/div[1]/div/div[2]/div/div/div');}
    get passwordErrorLable () {return $('//*/form/div[2]/div/div[2]/div/div/div');}
}

module.exports = LoginPage;
