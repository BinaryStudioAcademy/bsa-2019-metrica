<template>
    <VBtn
        :ripple="false"
        text
        rounded
        :class="isActive ? 'cyan white--text active' : 'inactive'"
        @click="changeParameter()"
    >
        {{ label }}
    </VBtn>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import {CHANGE_SELECTED_PARAMETER} from "@/store/modules/geo_location/types/actions";
    import {GET_SELECTED_PARAMETER} from "@/store/modules/geo_location/types/getters";

    export default {
        name: 'ButtonComponent',
        props: {
            label: {
                type:String,
                required: true
            },
            type: {
                type:String,
                required: true
            },
        },
        computed: {
            ...mapGetters('geo_location', {
                getSelectedParameter: GET_SELECTED_PARAMETER,
            }),
            isActive () {
                return this.type === this.getSelectedParameter;
            }
        },
        methods: {
            ...mapActions('geo_location', {
                changeSelectedParameter: CHANGE_SELECTED_PARAMETER
            }),
            changeParameter () {
                if (!this.isActive) {
                    this.changeSelectedParameter(this.type);
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
</style>
