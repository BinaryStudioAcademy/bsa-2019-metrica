<template>
    <VApp>
        <VContent>
            <VFlex
                lg6
                md6
                sm12
                xs12
            >
                <VContainer>
                    <VForm
                        ref="form"
                    >
                        <div class="inline-element">
                            <label>Website Name</label>
                            <VTextField
                                name="website"
                                v-model="localWebsite.isWebsiteName"
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
                        <div class="inline-element">
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
                        <VBtn
                            @click="update"
                            color="#3C57DE"
                            class="update-form-button"
                        >
                            Update
                        </VBtn>
                    </VForm>
                    <div>
                        <div>
                            <h2>WebSite Tracking</h2>
                            <p>
                                This is Global Site tag tracking code for you website.
                                Copy and Paste this code as the
                                first item into the &lt;HEAD> of every Webpage you want to track
                            </p>
                            <TrackWebsite :tracking-number="currentWebsite.tracking_number" />
                        </div>
                    </div>
                </VContainer>
            </VFlex>
        </VContent>
    </VApp>
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
                isWebsiteName: undefined
            }
        }),
        computed: {
            ...mapGetters('website', {
                currentWebsite: GET_CURRENT_WEBSITE
            }),
            isWebsiteName: {
                set(value) {
                    this.localWebsite.isWebsiteName = value;
                },
                get() {
                    if(this.localWebsite.isWebsiteName === undefined) {
                        return this.currentWebsite.name;
                    }
                    return this.localWebsite.isWebsiteName;
                },
            }
        },
        methods: {
            ...mapActions('website', {
                website: UPDATE_WEBSITE
            }),
            update() {
                this.website({
                    name:this.localWebsite.isWebsiteName
                }).then((e) => {
                    this.showSuccessMessage = 'Name Success Save';
                    this.localWebsite.isWebsiteName = e.name.name
                }).catch((err) => {
                    this.showErrorMessage = err.message
                })
            }
        },
    }
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
    .update-form-button {
        color: white;
        margin-bottom:20px;
        ::v-deep {
            span {
                font-size: 12px;
                line-height: 15px;
                padding: 7px 21px 7px 21px;
                font-weight: bold;
            }
        }
    }
</style>
