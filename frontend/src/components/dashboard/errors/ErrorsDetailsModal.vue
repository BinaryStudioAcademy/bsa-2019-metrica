<template>
    <VLayout justify-center>
        <VDialog
            persistent
            v-model="dialog"
            max-width="400"
        >
            <VCard>
                <VCardTitle>Error on page {{ errorItem.page }}</VCardTitle>
                <VCardText>
                    <div class="mb-2">
                        Message
                    </div>
                    <div class="text--primary message-block">
                        {{ errorItem.message }}
                    </div>
                    <div class="mt-5 mb-2">
                        Stack trace
                    </div>
                    <VClamp
                        autoresize
                        :max-lines="3"
                        class="text--primary message-block"
                    >
                        {{ errorItem.stack_trace }}
                        <template v-slot:after="{ toggle }">
                            <a
                                class="toggle-link px-3"
                                @click.stop="toggle"
                            >
                                More
                            </a>
                        </template>
                    </VClamp>
                </VCardText>
                <VCardActions class="justify-end">
                    <VBtn
                        color="primary"
                        text
                        @click="closeDetailsItem()"
                    >
                        Close
                    </VBtn>
                </VCardActions>
            </VCard>
        </VDialog>
    </VLayout>
</template>

<script>
    import VClamp from 'vue-clamp';

    export default {
        name: "ErrorsDetailsModal",
        components: {
            VClamp
        },
        props: {
            dialog: {
                type: Boolean,
                default: false
            },
            errorItem: {
                type: Object,
                required: true
            }
        },
        methods: {
            changeSelect () {
                this.$emit('change', this.selected);
            },
            closeDetailsItem () {
                this.$emit('close');
            }
        }
    };
</script>

<style scoped lang="scss">
    .message-block {
        border-radius: 6px;
        padding: 10px;
        border: 1px solid rgba(60, 87, 222, 0.52);

        .toggle-link {
            color: #3c57de;
        }
        .toggle-link:hover {
            color: #3c57de;
            text-decoration: underline;
        }
    }
</style>