<template>
    <VBtn
        :ripple="false"
        text
        rounded
        :class="isActive ? 'cyan white--text active' : 'inactive'"
        @click="changeParameter"
    >
        {{ label }}
    </VBtn>
</template>

<script>
    import {mapGetters} from 'vuex';
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
            changeParameter() {
                if (!this.active) {
                    this.$emit("change", this.type);
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
</style>
