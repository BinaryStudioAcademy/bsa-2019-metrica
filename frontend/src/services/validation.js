const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
const fullNameRegex = /^[a-z]([-']?[a-z]+)*( [a-z]([-']?[a-z]+)*)+$/i;

export const validateEmail = (email) => {
    return emailRegex.test(email);
};

export const validatePassword = (password) => {
    return password.length >= 8;
};

export const validateFullName = (name) => {
    return fullNameRegex.test(name);
};
