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
                                v-model="name"
                                :error-messages="nameErrors"
                                single-line
                                solo
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
                                v-model="address"
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
                            <span>{{ trackingId }}</span>
                        </p>
                        <div>
                            <h2>WebSite Tracking</h2>
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
                                v-model="code"
                                @focus="$event.target.select()"
                                :value="code"
                            />
                        </div>
                    </div>
                </VContainer>
            </VFlex>
        </VContent>
    </VApp>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import { GET_WEBSITE, SET_NAME_WEBSITE } from "../../store/modules/website/types/actions";
    import { GET_AUTHENTICATED_USER } from "../../store/modules/auth/types/getters";

    export default {
        data: () => ({
            nameErrors: '',
            chips: '',
            trackingId: '',
            name:'',
            address:'',
            code: '',
        }),
        created() {
            this.website({
                userId: this.user.id
            }).then((data) => {
                this.name = data.name;
                this.address = data.address;
                this.trackingId = data.trackingId;
                this.code = this.decode(this.trackingId);
            }, err => {
                alert(err.message);
            })
        },
        computed: {
            ...mapGetters('auth', {
                user: GET_AUTHENTICATED_USER
            })
        },
        methods: {
            ...mapActions('website', {
                setWebsiteName: SET_NAME_WEBSITE,
                website: GET_WEBSITE
            }),
            changeName(value) {
                if(!value.trim()) {
                    this.nameErrors = "The name is required";
                    return;
                }
                this.nameErrors = "";
                this.setWebsiteName({
                    userId:this.user.id,
                    name:value
                }).then((data) => {
                    this.name = data.name;
                }, err => {
                    alert(err);
                })
            },
            decode (trackengId) {
                let decoder = document.createElement('div');
                decoder.innerHTML = "&lt;!-- Global site tag (gtag.js) - Google Analytics --&gt;\n" +
                    "&lt;script async src='https://www.googletagmanager.com/gtag/js?id="+ trackengId +"'&gt;&lt;/script&gt;\n" +
                    "&lt;script&gt;\n" +
                    " window.dataLayer = window.dataLayer || [];\n" +
                    " function gtag() {\n" +
                    "  dataLayer.push(arguments);\n" +
                    " }\n" +
                    " gtag('js', new Date());\n\n" +
                    " gtag('config', '"+ trackengId +"');\n" +
                    "&lt;/script&gt;";
                return decoder.textContent
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
