<template>
    <RouterView />
</template>

<script>
    import {isWebsite} from '../mixins/isWebsite';

    export default {
        mixins: [isWebsite],
        name: 'Audience',
    };
</script>