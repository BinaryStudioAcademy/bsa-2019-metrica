<template>
    <Spinner
        v-if="isLoading"
    />
    <LoginForm
        v-else
        @success="onSuccess"
    />
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import {FETCH_CURRENT_WEBSITE} from "@/store/modules/website/types/actions";
    import {IS_CURRENT_WEBSITE} from "@/store/modules/website/types/getters";
    import Spinner from "@/components/utilites/Spinner";
    import LoginForm from '@/components/auth/LoginForm.vue';

    export default {
        components: {
            LoginForm,
            Spinner
        },
        data() {
            return {
                isLoading: false
            };
        },
        computed: {
            ...mapGetters('website', {
                isCurrentWebsite: IS_CURRENT_WEBSITE
            }),
        },
        methods: {
            ...mapActions('website', {
                fetchCurrentWebsite: FETCH_CURRENT_WEBSITE
            }),
            onSuccess() {
                this.isLoading = true;
                this.fetchCurrentWebsite().then(() => {
                    this.isLoading = false;
                    if (!this.isCurrentWebsite) {
                        this.$router.replace({name: 'add_website'});
                    } else {
                        this.$router.replace({name: 'dashboard'});
                    }
                });
            },
        },
    };
</script>

<style lang="scss" scoped>

    main{
        background: #FFFFFF;
    }
</style>