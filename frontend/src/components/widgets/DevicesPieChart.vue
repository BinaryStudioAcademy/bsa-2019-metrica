<template>
    <VContainer>
        <VSubheader
            class="header my-3 text-dark"
            fluid
        >
            Devices
        </VSubheader>
        <VContainer class="white pie-container position-relative">
            <Spinner v-if="isFetching" />
            <VContainer>
                <VRow class="justify-center">
                    <VCol class="pa-0 d-flex col-5 justify-center align-items-center">
                        <GChart
                            type="PieChart"
                            :data="chartData.system"
                            :options="chartOptions.system"
                        />
                    </VCol>
                    <VCol>
                        <VSubheader
                            v-text="legend.system.title"
                            class="legend-title text-dark pl-0"
                        />
                        <VList>
                            <VListItem
                                v-for="systems in legend.system.data"
                                :key="systems.title"
                                class="justify-space-between align-center pa-0"
                            >
                                <VIcon
                                    :color="systems.color"
                                    small
                                >
                                    mdi-circle
                                </VIcon>
                                <VLabel>{{ systems.title }}</VLabel>
                                <VLabel>
                                    {{ systems.percentageDiff }}%
                                </VLabel>
                            </VListItem>
                        </VList>
                    </VCol>
                </VRow>
                <VRow class="justify-center">
                    <VCol class="pa-0 d-flex col-5 justify-center align-items-center">
                        <GChart
                            type="PieChart"
                            :data="chartData.device"
                            :options="chartOptions.device"
                        />
                    </VCol>
                    <VCol class="align-items-end">
                        <VSubheader
                            v-text="legend.device.title"
                            class="legend-title text-dark pl-0"
                        />
                        <VList>
                            <VListItem
                                class="justify-space-between align-center pa-0"
                                v-for="devices in legend.device.data"
                                :key="devices.title"
                            >
                                <VIcon
                                    :color="devices.color"
                                    small
                                >
                                    mdi-circle
                                </VIcon>
                                <VLabel>{{ devices.title }}</VLabel>
                                <VLabel>
                                    {{ devices.percentageDiff }}%
                                </VLabel>
                            </VListItem>
                        </VList>
                    </VCol>
                </VRow>
            </VContainer>
        </VContainer>
    </VContainer>
</template>

<script>
    import {GChart} from 'vue-google-charts';
    import Spinner from '@/components/utilites/Spinner';

    export default {
        components: {
            GChart,
            Spinner
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
                                color: '#FF9900',
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
                                color: '#67C208',
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
.pie-container {
    box-shadow: 0 0 28px rgba(0, 0, 0, 0.11) !important;
    border-radius: 10px;
    border-style: solid;
    border-color: #18A0FB !important;
    max-width: 400px;
}
.header {
    align-items: center;
    text-align: center;
    text-transform: capitalize;
    font-family: 'Gilroy';
    padding-bottom: 10px;
    font-size: 16px;
    line-height: 19px;
}
.legend-title {
    font-family: Gilroy;
    font-size: 14px;
    line-height: 16px;
}
.radio {
    border-radius: 50%;
}

.v-list-item {
    height: 40px;
    min-height: 20px;
    min-width: 120px;
}
.v-subheader {
    height: 20px;
}
.v-label {
    font-size: 12px;
}
</style>
