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
                                @change="changeName"
                                v-model="currentWebsite.name"
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
                            <label>Website Adress</label>
                            <VTextField
                                name="adress"
                                placeholder="website adress"
                                single-line
                                solo
                                disabled
                                v-model="currentWebsite.domain"
                            />
                        </div>
                        <div class="inline-element">
                            <label>SPA</label>
                            <VSwitch
                                v-model="currentWebsite.single_page"
                                color="#3C57DE"
                                inset
                            />
                        </div>
                    </VForm>
                    <div>
                        <p class="inline-element">
                            <span>Tracking ID: </span>
                            <span>{{ currentWebsite.tracking_number }}</span>
                        </p>
                        <div>
                            <h2>WebSite Tracking</h2>
                            <p>
                                This is Global Site tag tracking code for you website.
                                Copy and Paste this code as the
                                first item into the &lt;HEAD> of every Webpage you want to track
                            </p>
                            <TrackWebsite :tracking-number="currentWebsite.trackingNumber" />
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
    import { GET_AUTHENTICATED_USER } from "../../store/modules/auth/types/getters";
    import {GET_CURRENT_WEBSITE} from "../../store/modules/website/types/getters";
    import {SET_NAME_WEBSITE} from "../../store/modules/website/types/actions";

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
        }),
        computed: {
            ...mapGetters('auth', {
                user: GET_AUTHENTICATED_USER
            }),
            ...mapGetters('website', {
                currentWebsite: GET_CURRENT_WEBSITE
            }),
        },
        methods: {
            ...mapActions('website', {
                website: SET_NAME_WEBSITE
            }),
            changeName(val) {
                this.website({
                    user_id:this.user.id,
                    name:val
                }).then(() => {
                    this.showSuccessMessage = 'Name Success Save'
                }, err => {
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
</style>
