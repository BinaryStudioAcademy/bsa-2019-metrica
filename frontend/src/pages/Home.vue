<template>
    <VContent>
        <VLayout wrap>
            <VFlex
                left-col-wrapper
                sm12
                md6
                :class="{'mt-12': $vuetify.breakpoint.smAndDown}"
            >
                <VLayout
                    column
                    align-items-start
                    justify-center
                    left-col
                >
                    <h1>Get to know  your customers.</h1>
                    <div class="btn-group">
                        <VBtn
                            class="start"
                            color="primary"
                            :to="{name: 'signup'}"
                            x-large
                        >
                            Start for free
                        </VBtn>
                        <VBtn
                            class="login"
                            :to="{name: 'login'}"
                            outlined
                            min-width="150px"
                            x-large
                        >
                            Sign In
                        </VBtn>
                    </div>
                </VLayout>
            </VFlex>
            <VFlex
                image
                sm12
                md6
                :class="{'mt-12': $vuetify.breakpoint.smAndDown}"
                class="d-flex align-center"
            >
                <VImg
                    src="/assets/images/home.png"
                    alt="Man"
                />
            </VFlex>
        </VLayout>
    </VContent>
</template>

<script>
    import {isCurrentUser} from '../mixins/isCurrentUser';

    export default {
        mixins: [isCurrentUser]
    };
</script>

<style lang="scss" scoped>

main {
    background: #FFFFFF;
}

.v-btn {
    margin-right: 20px;
    font-family: Gilroy;
    font-size: 18px;
    line-height: 22px;
    letter-spacing: 0.4px;
    text-transform: none;
    border-radius: 3px;

    +.start {
        background: #3C57DE;
    }
    +.login {
        background: #FFFFFF;
        border: 2px solid #3C57DE;
        box-sizing: border-box;
        border-radius: 3px;
        color: #3C57DE;
    }
}


h1{
    font-family: Gilroy;
    font-size: 55px;
    line-height: 65px;
    margin-bottom: 60px;
}

.left-col {
    height: 100%;
    width: 80%;
    margin: 0 auto;
    background: #FFFFFF;
}

</style>