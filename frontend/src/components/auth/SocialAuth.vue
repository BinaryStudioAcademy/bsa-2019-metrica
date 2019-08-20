<template>
    <div class="social-container">
        <div class="justify-content-center">
            <div class="middle-line">
                Or sign in with
            </div>
        </div>
        <div class="social-btn-group">
            <button
                class="social-btn google-social-btn"
                @click="redirect('google')"
            >
                <FontAwesomeIcon
                    class="social-icon"
                    :icon="['fab', 'google']"
                />
            </button>
            <button
                class="social-btn facebook-social-btn"
                @click="redirect('facebook')"
            >
                <FontAwesomeIcon
                    class="social-icon"
                    :icon="['fab', 'facebook-f']"
                />
            </button>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import { SOCIAL_REDIRECT } from "@/store/modules/auth/types/actions";
    import { SHOW_ERROR_MESSAGE } from "@/store/modules/notification/types/actions";

    export default {
        name: 'SocialAuth',
        methods: {
            ...mapActions('auth', {
                socialRedirect: SOCIAL_REDIRECT
            }),

            ...mapActions('notification', {
                showErrorMessage: SHOW_ERROR_MESSAGE
            }),

            redirect(provider){
                this.socialRedirect(provider)
                    .then(redirectUrl => window.location.replace(redirectUrl))
                    .catch(error => this.showErrorMessage(error));
            }
        }
    };
</script>

<style lang="scss" scoped>
    svg path {
        fill: white;
    }

    .social-container {
        max-width: 80%;
        padding-right: .5rem;
        background: inherit;
    }

    .middle-line {
        overflow: hidden;
        text-align: center;
        color: gray;
        &:before,
        &:after {
            background-color: gray;
            content: "";
            display: inline-block;
            height: 1px;
            position: relative;
            vertical-align: middle;
            width: 50%;
        }
        &:before {
            right: 0.5em;
            margin-left: -50%;
        }
        &:after {
            left: 0.5em;
            margin-right: -50%;
        }
    }

    .social-btn-group {
        font-size: 2rem;
        display: flex;
        margin-bottom: 1rem;
        justify-content: center;

        .social-btn {
            padding: 5px;
            border-radius: 3px;
            margin: 1rem .5rem;
            width: 40px;
            height: 40px;
            transition: background-color 0.2s ease-in-out;
            .social-icon {
                display:inline-block;
                width: 30px;
                height: 30px;
                vertical-align: top;
            }
            &:hover {
                cursor: pointer;
            }
        }

        .google-social-btn {
            outline: none;
            background: #DD4B39;
            &:hover {
                background: #E3695A;
            }
            &:active {
                background: #C03221;
            }
        }


        .facebook-social-btn {
            outline: none;
            background: #3B5999;
            &:hover {
                background: #4669B4;
            }
            &:active {
                background: #2C4272;
            }
        }
    }
</style>
