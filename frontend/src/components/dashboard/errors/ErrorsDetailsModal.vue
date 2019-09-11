<template>
    <VLayout justify-center>
        <VDialog
            persistent
            v-model="dialog"
            max-width="500"
        >
            <VCard>
                <VCardTitle>
                    Error on page
                    <span class="page-url">{{ errorItem.parameter_value }}</span>
                </VCardTitle>
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
                        <template
                            slot="after"
                            slot-scope="{ toggle, expanded }"
                        >
                            <a
                                class="toggle-link text-center px-4"
                                @click="toggle"
                            >
                                <span v-if="expanded">
                                    Collapse
                                </span>
                                <span v-else>
                                    More
                                </span>
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
            },
        }
    };
</script>

<style scoped lang="scss">
    .page-url {
        color: #3c57de;
        font-size: 18px;
        padding-left: 20px;
    }
    .message-block {
        border-radius: 6px;
        padding: 10px;
        border: 1px solid rgba(60, 87, 222, 0.52);

        .toggle-link {
            display: inline-block;
            line-height: 36px;
            height: 36px;
            color: #3c57de;
            border-radius: 3px;
        }
        .toggle-link:hover {
            color: #3c57de;
            opacity: 0.75;

        }
    }
</style>