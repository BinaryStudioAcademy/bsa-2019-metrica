class Storage
{
    constructor(type = 'localStorage')
    {
        this.store = window[type];
    }

    get(key)
    {
        return this.store.getItem(key);
    }

    set(key, value)
    {
        return this.store.setItem(key, value);
    }

    static getLocalStorage() {
        return new Storage();
    }

    static getSessionStorage() {
        return new Storage('sessionStorage');
    }

}
export const SessionStorage = Storage.getSessionStorage();
export const LocalStorage = Storage.getLocalStorage();

export default new Storage();
