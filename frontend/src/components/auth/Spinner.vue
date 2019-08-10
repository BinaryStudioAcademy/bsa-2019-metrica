<template>
    <div class="text-center">
        <VOverlay :value="overlay">
            <VProgressCircular
                indeterminate
                size="64"
            />
        </VOverlay>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    import {HAS_TOKEN} from "@/store/modules/auth/types/getters";
    import {SET_IS_LOGGED_IN} from "@/store/modules/auth/types/actions";
    import {GET_USER_DATA} from "@/store/modules/auth/types/actions";

    export default {
        name: "Spinner",
        data: function () {
            return {
                overlay: false
            }
        },
        computed: {
            ...mapGetters('auth', {
                hasToken: HAS_TOKEN
            })
        },
        mounted() {
            if (this.hasToken) {
                // this.setUserLoggedIn(true);
                this.getUserData();
                alert('succese!');
            } else {
                this.setUserLoggedIn(false);
                alert('error!');
            }
        },
        methods: {
            ...mapActions('auth', {
                getUserData: GET_USER_DATA,
                setUserLoggedIn: SET_IS_LOGGED_IN
            }),
        }
    }
</script>

<style scoped>

</style>