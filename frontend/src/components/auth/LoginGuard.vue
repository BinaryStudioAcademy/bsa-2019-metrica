<template>
    <RouterView />
</template>

<script>
    import store from '../../store';

    export default {
        beforeRouteEnter(to,from,next) {
            if(!store.state.auth.isLoggedIn) {
                next({
                    name: "login",
                    params: {
                        redirectTo: to}
                });
            } else {
                next();
            }
        }
    };
</script>