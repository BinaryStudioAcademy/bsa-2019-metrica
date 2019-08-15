import { SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE, HIDE_MESSAGE } from './types/actions';
import { SHOW, HIDE } from './types/mutations';

export default {
    [SHOW_SUCCESS_MESSAGE]: ({ commit }, text) => {
        commit(SHOW, { text, type: 'success' });
    },

    [SHOW_ERROR_MESSAGE]: ({ commit }, text) => {
        commit(SHOW, { text, type: 'error' });
    },

    [HIDE_MESSAGE]: ({ commit }) => {
        commit(HIDE);
    }
};
