<template>
    <VContent>
        <VContainer
            p-o
            fluid
            fill-height
        >
            <VLayout
                content
                wrap
                align-start
                justify-center
            >
                <VFlex
                    form-wrapper
                    xs12
                    sm8
                    md6
                >
                    <VLayout
                        column
                        align-items-center
                    >
                        <ChangePasswordForm />
                    </VLayout>
                </VFlex>
            </VLayout>
        </VContainer>
    </VContent>
</template>

<script>
    import ChangePasswordForm from "../components/auth/ChangePasswordFrom";
    import {isCurrentUser} from '../mixins/isCurrentUser';

    export default {
        name: "ChangePassword",
        mixins: [isCurrentUser],
        components: {
            ChangePasswordForm
        }
    };
</script>

<style scoped>

</style>