class SettingsPage {

    get nameInput () {return $('input[name=website]');}

    get updateButton () {return $('button.primary');}

    get nameLabel () {return $('//*/form/div[1]/div/div/div[2]/div/div/div');}
};

module.exports = SettingsPage;

