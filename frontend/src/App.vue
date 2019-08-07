<template>
    <v-app id="app">
        <top-navbar></top-navbar>
        <router-view></router-view>
    </v-app>
</template>

<script>
    import HelloWorld from './components/HelloWorld.vue';
    import TopNavbar from './components/navbar/TopNavbar.vue';

    export default {
        name: 'app',
        components: {
            HelloWorld,
            TopNavbar
        }
    }
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }
</style>
