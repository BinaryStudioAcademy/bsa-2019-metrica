const tokenKeyName = 'auth.access_token';
class Storage {
    constructor(type = 'localStorage') {
        this.store = window[type];
    }

    get(key) {
        return this.store.getItem(key);
    }

    set(key, value) {
        return this.store.setItem(key, value);
    }

    removeItem(key) {
        this.store.removeItem(key);
    }

    getToken() {
        return this.get(tokenKeyName);
    }

    setToken(token) {
        return this.set(tokenKeyName, token);
    }

    hasToken() {
        return !!this.get(tokenKeyName);
    }

    removeToken() {
        return this.removeItem(tokenKeyName);
    }
}
export const sessionStorage = new Storage('sessionStorage');
export const localStorage = new Storage();

export default new Storage();
