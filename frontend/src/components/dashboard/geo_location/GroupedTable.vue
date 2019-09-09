<template>
    <VContainer
        p-0
        class="geo-location-table"
    >
        <VRow
            class="header my-3"
            fluid
        >
            <VCol>
                <slot name="country">
                    Country
                </slot>
            </VCol>
            <VCol>
                <slot name="visitors">
                    Visitors
                </slot>
            </VCol>
            <VCol>
                <slot name="new-visitors">
                    New visitors
                </slot>
            </VCol>
            <VCol>
                <slot name="sessions">
                    Sessions
                </slot>
            </VCol>
            <VCol>
                <slot name="bounce-rate">
                    Bounce rate, %
                </slot>
            </VCol>
            <VCol>
                <slot name="avg-session-time">
                    Avg. session time
                </slot>
            </VCol>
        </VRow>
        <VDataTable
            class="caption"
            hide-default-footer
            hide-default-header
            :headers="headers"
            :items="geoLocationItems"
        />
    </VContainer>
</template>

<script>
    import moment from 'moment';

    export default {
        name: 'GroupedTable',
        props: {
            items: {
                type: Array,
                required: true
            }
        },
        data () {
            return {
                headers: [
                    { text: '', align: 'center', value: 'country' },
                    { text: '', align: 'center', value: 'all_visitors_count' },
                    { text: '', align: 'center', value: 'new_visitors_count' },
                    { text: '', align: 'center', value: 'sessions_count' },
                    { text: '', align: 'center', value: 'bounce_rate' },
                    { text: '', align: 'center', value: 'avg_session_time' },
                ],
            };
        },
        computed: {
            geoLocationItems() {
                return this.items.map((item) => {
                    const duration = moment.duration(parseInt(this.buttonsData[type].value), 's');
                    const hours = Math.floor(duration.asHours());
                    const minutes = moment.utc(duration.asMilliseconds()).format("mm:ss");

                    let newItemData = {
                        avg_session_time: `${hours}:${minutes}`,
                        bounce_rate: Math.round(Number(item.bounce_rate) * 100)
                    };
                    return { ...item, ...newItemData};
                });
            }
        }
    };
</script>

<style scoped lang="scss">
    $dark: #122737;
    $blue: #3C57DE;
    $gray: rgba(18, 39, 55, 0.5);

    .geo-location-table {
        font-family: 'Gilroy';
    }

    .header {
        align-items: center;
        text-align: center;
        text-transform: capitalize;
    }

    .container {

        .v-data-table {
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 6px;
            color: $gray;
            line-height: 14px;
            box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);

            ::v-deep tr {
                min-height: 52px;
                display: flex;
                align-items: center;
                border-bottom: 1px solid rgba(0, 0, 0, 0.07) !important;

                &:last-child {
                    border-style: none !important;
                }

                td {
                    height: max-content;
                    flex: 1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    max-width: calc(100% / 3);
                    word-break: break-all;
                    padding: 8px;
                }
            }
        }
    }

    ::v-deep .v-list-item {
        font-family: 'Gilroy';
        text-transform: capitalize;
    }
</style>