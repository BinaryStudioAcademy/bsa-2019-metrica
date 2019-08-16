import { SHOW, HIDE } from './types/mutations';

export default {
    [SHOW]: (state, { text, type }) => {
        state.active = true;
        state.text = text;
        state.type = type;
    },

    [HIDE]: (state) => {
        state.active = false;
    }
};
