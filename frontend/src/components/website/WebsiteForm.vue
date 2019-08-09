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
                    <form>
                        <div class="inline-element">
                            <label>Website Name</label>
                            <VTextField
                                name="website"
                                @change="changeName"
                                :error-messages="nameErrors"
                                single-line
                                solo
                                placeholder="website name"
                                required
                                :rules="nameRules"
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
                            />
                        </div>
                        <div class="inline-element">
                            <label>SPA</label>
                            <VSwitch v-model="chips" />
                        </div>
                    </form>
                    <div>
                        <p class="inline-element">
                            <span>Tracking ID: </span>
                            <span>{{ tracking_id }}</span>
                        </p>
                        <div>
                            <h1>WebSite Tracking</h1>
                            <p>
                                This is Global Site tag tracking code for you website.
                                Copy and Paste this code as the
                                first item into the &lt;HEAD> of every Webpage you want to track
                            </p>
                            <VTextarea
                                name="code"
                                filled
                                auto-grow
                                readonly
                                v-bind="code"
                                @focus="$event.target.select()"
                                value="<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src='https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID'></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag() {
  dataLayer.push(arguments);
 }
 gtag('js', new Date());
 gtag('config', 'GA_MEASUREMENT_ID');
</script>"
                            />
                        </div>
                    </div>
                </VContainer>
            </VFlex>
        </VContent>
    </VApp>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import {SET_NAME_WEBSITE} from "../../store/modules/website/types/actions";

    export default {
        data: () => ({
            drawer: null,
            nameErrors: '',
            chips: '',
            tracking_id: '',
            code: "",
            nameRules: [
                v => !!v || 'Name required',
            ],
        }),
        created() {
            this.websites({
                user_id: 1,
            }).then((a) => {
                alert(a)
            }, err => {
                alert(err.message);
            })
        },
        computed: {
            ...mapGetters('website', {
                websites: 'getWebsite'
            }),
        },
        methods: {
            ...mapActions('website', {
                website: SET_NAME_WEBSITE
            }),
            changeName(val) {
                this.website({
                    user_id:122,
                    name:val
                }).then((e) => {
                    console.log(e)
                    //this.$router.push({path: '/'});
                }, err => {
                    alert(err.message);
                })
            }
        },
    }
</script>

<style lang="scss" scoped>
    .inline-element {
        display: grid;
        grid-template-columns: 20% 80%;
        align-items: baseline;
        @media (max-width: 767px) {
            & {
                grid-template-columns: 100%;
            }
        }
    }
</style>
