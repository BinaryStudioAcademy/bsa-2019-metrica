import jwt_decode from "jwt-decode";

const parse = (token, options = {}) => jwt_decode(token, options);
const checkExpireToken = token => {
    let parsedToken = parse(token);
    return parsedToken.exp < Date.now().valueOf() / 1000;
};
const jwtService = {
    parse,
    checkExpireToken
};

export default jwtService;
