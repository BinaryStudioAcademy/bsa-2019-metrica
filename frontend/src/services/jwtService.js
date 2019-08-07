import jwt_decode from "jwt-decode"

const parse = (token, options = {}) => jwt_decode(token, options);

const jwtService = {
    parse
};

export default jwtService;
