import { SHOW_SUCCESS, SHOW_ERROR } from './types/actions';
import { SHOW, HIDE } from './types/mutations';

export default {
    [SHOW_SUCCESS]: ({ commit }, text) => {
        commit(SHOW, { text, type: 'success' });
        setTimeout(() => commit(HIDE), 2000);
    },

    [SHOW_ERROR]: ({ commit }, text) => {
        commit(SHOW, { text, type: 'error' });
        setTimeout(() => commit(HIDE), 2000);
    },
}