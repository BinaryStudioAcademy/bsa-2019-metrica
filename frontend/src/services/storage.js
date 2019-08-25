const tokenKeyName = 'auth.access_token';
const tokenTypeKeyName = 'auth.token_type';
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

    getTokenType() {
        return this.get(tokenTypeKeyName);
    }

    setTokenType(type) {
        return this.set(tokenTypeKeyName, type);
    }

    removeToken() {
        return this.removeItem(tokenKeyName);
    }
}

let storage = new Storage();
const isLocalStorageAccessible = () => {
    try {
        storage.set('test-local-storage', 1);
        storage.removeItem('test-local-storage');
        return true;
    } catch(e) {
        return false;
    }
};

if (!isLocalStorageAccessible()){
    storage = new Storage('sessionStorage');
}

export default storage;
