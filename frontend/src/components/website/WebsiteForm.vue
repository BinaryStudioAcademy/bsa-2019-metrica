<template>
    <VFlex
        lg6
        md6
        sm12
        xs12
        class="ml-12 mt-8"
    >
        <VContainer>
            <VForm
                ref="form"
            >
                <div class="inline-element mb-4">
                    <label>Website Name</label>
                    <VTextField
                        name="website"
                        v-model="websiteName"
                        :success-messages="showSuccessMessage"
                        :error-messages="showErrorMessage"
                        single-line
                        solo
                        :rules="nameRules"
                        placeholder="website name"
                        required
                    />
                </div>
                <div class="inline-element">
                    <label>Website Address</label>
                    <VTextField
                        name="address"
                        placeholder="website address"
                        single-line
                        solo
                        disabled
                        readonly
                        :value="currentWebsite.domain"
                    />
                </div>
                <div class="inline-element mb-7">
                    <label>SPA</label>
                    <VSwitch
                        :value="currentWebsite.single_page"
                        readonly
                        color="#3C57DE"
                        inset
                    />
                </div>
                <p class="inline-element">
                    <span>Tracking ID: </span>
                    <span>{{ currentWebsite.tracking_number }}</span>
                </p>
                <VCardActions class="px-0 mt-8 mb-12">
                    <VBtn
                        @click="update"
                        color="primary"
                        width="125"
                    >
                        Update
                    </VBtn>
                </VCardActions>
            </VForm>
            <div>
                <div>
                    <h2>WebSite Tracking</h2>
                    <p class="mt-4">
                        This is Global Site tag tracking code for you website.
                        Copy and Paste this code as the
                        first item into the &lt;HEAD> of every Webpage you want to track
                    </p>
                    <TrackWebsite :tracking-number="currentWebsite.tracking_number" />
                </div>
            </div>
        </VContainer>
    </VFlex>
</template>

<script>
    import TrackWebsite from './TrackWebsite.vue';
    import { mapGetters, mapActions } from 'vuex';
    import {GET_CURRENT_WEBSITE} from "../../store/modules/website/types/getters";
    import {UPDATE_WEBSITE} from "../../store/modules/website/types/actions";

    export default {
        name: 'WebsiteForm',
        components: {
            TrackWebsite
        },
        data: () => ({
            showErrorMessage: '',
            showSuccessMessage: '',
            nameRules: [
                v => !!v || 'Website name is required',
                v => (v && v.length >= 8) || 'Website name must be correct. Name must be at least 8 characters.'
            ],
            localWebsite: {
                websiteName: undefined
            }
        }),
        computed: {
            ...mapGetters('website', {
                currentWebsite: GET_CURRENT_WEBSITE
            }),
            websiteName: {
                set(value) {
                    this.localWebsite.websiteName = value;
                },
                get() {
                    if(this.localWebsite.websiteName === undefined) {
                        return this.currentWebsite.name;
                    }
                    return this.localWebsite.websiteName;
                },
            }
        },
        methods: {
            ...mapActions('website', {
                website: UPDATE_WEBSITE
            }),
            update() {
                this.website({
                    name: this.websiteName,
                }).then(() => {
                    this.showSuccessMessage = 'Name is successfully saved';
                }).catch((err) => {
                    this.showErrorMessage = err;
                });
            }
        },
    };
</script>

<style lang="scss" scoped>
    .inline-element {
        display: grid;
        grid-template-columns: 30% 70%;
        align-items: baseline;
        @media (max-width: 767px) {
            & {
                grid-template-columns: 100%;
            }
        }
    }
</style>
