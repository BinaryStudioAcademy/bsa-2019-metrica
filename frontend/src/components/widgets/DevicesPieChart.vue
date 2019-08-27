<template>
    <VContainer class="wrapper pa-0">
        <VSubheader
            class="header mb-4 pl-0 text-dark"
        >
            Devices
        </VSubheader>
        <VContainer class="white pie-container position-relative">
            <Spinner v-if="isFetching" />
            <VContainer class="pt-1">
                <VRow class="justify-center">
                    <VCol class="d-flex col-5 justify-center align-items-center">
                        <GChart
                            class="pb-2 align-self-end"
                            type="PieChart"
                            :data="chartData.system"
                            :options="chartOptions.system"
                        />
                    </VCol>
                    <VCol>
                        <VSubheader
                            v-text="legend.system.title"
                            class="legend-title grey--text text--darken-1 pl-0"
                        />
                        <VList>
                            <VListItem
                                v-for="systems in legend.system.data"
                                :key="systems.title"
                                class="justify-space-between align-center pa-0"
                            >
                                <VIcon
                                    :color="systems.color"
                                    size="8"
                                >
                                    mdi-circle
                                </VIcon>
                                <VListItemTitle
                                    class="pl-2 grey--text"
                                >
                                    {{ systems.title }}
                                </VListItemTitle>
                                <VListItemSubTitle
                                    class="grey--text"
                                >
                                    {{ systems.percentageDiff }}%
                                </VListItemSubTitle>
                            </VListItem>
                        </VList>
                    </VCol>
                </VRow>
                <VRow class="justify-center mb-2">
                    <VCol class="d-flex col-5 justify-center align-items-center">
                        <GChart
                            class="align-self-end pb-2"
                            type="PieChart"
                            :data="chartData.device"
                            :options="chartOptions.device"
                        />
                    </VCol>
                    <VCol class="align-items-end">
                        <VSubheader
                            v-text="legend.device.title"
                            class="legend-title grey--text text--darken-1 pl-0"
                        />
                        <VList>
                            <VListItem
                                class="justify-space-between align-center pa-0"
                                v-for="devices in legend.device.data"
                                :key="devices.title"
                            >
                                <VIcon
                                    :color="devices.color"
                                    size="8"
                                >
                                    mdi-circle
                                </VIcon>
                                <VListItemTitle
                                    class="pl-2 grey--text"
                                >
                                    {{ devices.title }}
                                </VListItemTitle>
                                <VListItemSubTitle
                                    class="grey--text"
                                >
                                    {{ devices.percentageDiff }}%
                                </VListItemSubTitle>
                            </VListItem>
                        </VList>
                    </VCol>
                </VRow>
                <VRow class="pl-3">
                    <PeriodDropdown
                        :value="selectedPeriod"
                    />
                </VRow>
            </VContainer>
        </VContainer>
    </VContainer>
</template>

<script>
    import {GChart} from 'vue-google-charts';
    import Spinner from '@/components/utilites/Spinner';
    import PeriodDropdown from "../dashboard/common/PeriodDropdown";

    export default {
        components: {
            GChart,
            Spinner,
            PeriodDropdown
        },
        props: {
            data: {
                type: Object,
                required: true,
            },
            pieHole: {
                type: Number,
                default: 0.87
            },
            legend: {
                type: Object,
                required: true,
            },
            isFetching: {
                type: Boolean,
                required: true,
            }
        },
        data() {
            return {
                selectedPeriod: 'last_week',
                chartData: {
                    system: this.data.system,
                    device: this.data.device,
                },
                chartOptions: {
                    system: {
                        chartArea: {
                            backgroundColor: 'transparent',
                            width: '85%',
                            height: '85%'
                        },
                        width: 110,
                        height: 110,
                        pieHole: this.pieHole,
                        pieSliceBorderColor: 'none',
                        legend: 'none',
                        pieSliceText: 'none',
                        tooltip: {
                            trigger: 'hover'
                        },
                        slices: {
                            0: {
                                color: '#3C57DE',
                            },
                            1: {
                                color: '#1BC3DA',
                                offset: 0,
                            },
                            2: {
                                color: '#67C208',
                                offset: 0,
                            },
                        }
                    },
                    device: {
                        chartArea: {
                            backgroundColor: 'transparent',
                            width: '85%',
                            height: '85%'
                        },
                        width: 110,
                        height: 110,
                        pieHole: this.pieHole,
                        pieSliceBorderColor: 'none',
                        legend: 'none',
                        pieSliceText: 'none',
                        tooltip: {
                            trigger: 'hover',
                        },
                        slices: {
                            0: {
                                color: '#F03357',
                            },
                            1: {
                                color: '#ff9900',
                                offset: 0,
                            },
                            2: {
                                color: '#FFD954',
                                offset: 0,
                            },
                        }
                    },
                }
            };
        }
    };
</script>

<style scoped lang="scss">
.wrapper {
    width: max-content !important;
    margin: 0;
}
.pie-container {
    box-shadow: 0 0 28px rgba(0, 0, 0, 0.11) !important;
    border-radius: 6px;
    width: 307px;
    height: 394px;
}
.header {
    font-size: 16px;
    line-height: 19px;
    width: max-content;
}
.legend-title {
    font-size: 14px;
    line-height: 16px;
}

.v-list-item {
    height: 32px;
    min-height: 20px;
    min-width: 120px;
    .v-list-item__title,
    vlistitemsubtitle {
        font-size: 12px;
        font-family: 'GilroySemiBold';
    }
}
.v-subheader {
    height: 20px;
}
.v-list-item__title {
    text-align: start;
}
</style>
