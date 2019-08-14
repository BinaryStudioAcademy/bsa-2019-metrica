import { GET_TEXT, GET_TYPE, IS_ACTIVE } from './types/getters';

export default {
    [GET_TEXT]: state => state.text,
    [GET_TYPE]: state => state.type,
    [IS_ACTIVE]: state => state.active
};
