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
    import {GET_CURRENT_USER} from "@/store/modules/auth/types/actions";
    import {SET_IS_LOGGED_OUT} from "../../store/modules/auth/types/actions";

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
                this.getCurrentUser();
                alert('succese!');
            } else {
                this.setUserLoggedOut();
            }
        },
        methods: {
            ...mapActions('auth', {
                getCurrentUser: GET_CURRENT_USER,
                setUserLoggedOut: SET_IS_LOGGED_OUT
            }),
        }
    }
</script>

<style scoped>

</style>