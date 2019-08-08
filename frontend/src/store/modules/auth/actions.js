import {LOGIN, LOGOUT} from './types/actions';
import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT} from "./types/mutations";
import { authorize, me } from '../../../api/auth';

export default {
    [LOGIN]: (context, user) => {
        return authorize(user)
          .then(response => {
            me()
              .then(response => {
                const user = response[0];
                context.commit(SET_AUTHENTICATED_USER, user);
              })
              .catch(error => {
                throw error
              });

            context.commit(USER_LOGIN, response);
          })
          .catch(error => {
              throw error;
          });
    },

    [LOGOUT]: (context) => {
        return new Promise((resolve, reject) => {
            context.commit(USER_LOGOUT);
            resolve();
        });
    },
}