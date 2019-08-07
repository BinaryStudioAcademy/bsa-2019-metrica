export default {
    hasToken: () => () => !!state.token,
    isLoggedIn: (state) => !!state.isLoggedIn,
    getAuthenticatedUser: (state) => state.currentUser,
    getToken: () => () => state.token,
};