<template>
    <DefaultDropdown
        :items="items"
        :value="value"
        @change="changeWebsite"
    />
</template>

<script>
    import {period} from "@/services/periodService";
    import DefaultDropdown from '@/components/common/DefaultDropdown';
    import {mapActions, mapGetters} from "vuex";
    import {GET_RELATE_WEBSITES} from "@/store/modules/website/types/getters";
    import {FETCH_RELATE_WEBSITES} from "@/store/modules/website/types/actions";

    export default {
        name: "WebsitesDropdown",
        components: {
            DefaultDropdown
        },
        props: {
            value: {
                type:String,
                required: true
            },
            items: {
                type: Array,
                default () {
                    this.getWebsites()
                }
            }
        },
        created() {
            this.fetchRelateWebsites();
        },
        computed: {
            ...mapGetters('website', {
                websites: GET_RELATE_WEBSITES
            })
        },
        methods: {
            ...mapActions('websites', {
                fetchRelateWebsites: FETCH_RELATE_WEBSITES,
            }),
            changeWebsite(selectedItem) {
                this.$emit("change", selectedItem);
            },
            getWebsites() {
                return this.websites;
            }
        }
    };
</script>
