<template>
    <VContainer>
        <VSubheader
            class="header my-3 text-dark"
            fluid
        >
            Devices
        </VSubheader>
        <VLayout class="pie-container position-relative">
            <Spinner v-if="isFetching" />
            <VContainer>
                <VFlex
                    lg4
                    md4
                    hidden-sm-and-down
                    height="100%"
                    class="img-card"
                >
                    <GChart
                        type="PieChart"
                        :data="chartData.system"
                        :options="chartOptions.system"
                    />
                </VFlex>
                <VFlex
                    lg5
                    md5
                    hidden-sm-and-down
                    height="100%"
                    class="img-card"
                >
                    <VSubheader
                        v-text="legend.system.title"
                        class="legend-title text-dark"
                    />
                    <VList>
                        <VListItem
                            v-for="systems in legend.system.data"
                            :key="systems.title"
                        >
                            <VRow class="align-center justify-content-between">
                                <VIcon
                                    :color="systems.color"
                                    small
                                >
                                    mdi-circle
                                </VIcon>
                                <VLabel>{{ systems.title }}</VLabel>
                                <VLabel>
                                    <VIcon
                                        :color="systems.color"
                                        small
                                    >
                                        mdi-arrow-up
                                    </VIcon>
                                    {{ systems.percentageDiff }}%
                                </VLabel>
                            </VRow>
                        </VListItem>
                    </VList>
                </VFlex>
            </VContainer>
            <VContainer>
                <VFlex
                    lg4
                    md4
                    hidden-sm-and-down
                    height="100%"
                    class="img-card"
                >
                    <GChart
                        type="PieChart"
                        :data="chartData.device"
                        :options="chartOptions.device"
                    />
                </VFlex>
                <VFlex
                    lg5
                    md5
                    hidden-sm-and-down
                    height="100%"
                    class="img-card"
                >
                    <VSubheader
                        v-text="legend.device.title"
                        class="legend-title text-dark"
                    />
                    <VList>
                        <VListItem
                            v-for="devices in legend.device.data"
                            :key="devices.title"
                        >
                            <VRow class="align-center justify-content-between">
                                <VIcon
                                    :color="devices.color"
                                    small
                                >
                                    mdi-circle
                                </VIcon>
                                <VLabel>{{ devices.title }}</VLabel>
                                <VLabel>
                                    <VIcon
                                        :color="devices.color"
                                        small
                                    >
                                        mdi-arrow-up
                                    </VIcon>
                                    {{ devices.percentageDiff }}%
                                </VLabel>
                            </VRow>
                        </VListItem>
                    </VList>
                </VFlex>
            </VContainer>
        </VLayout>
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
                default: 0.95
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
                        width: 200,
                        height: 200,
                        pieHole: this.pieHole,
                        legend: 'none',
                        pieSliceText: 'none',
                        tooltip: {
                            trigger: 'none',
                        },
                        slices: {
                            0: {
                                color: '#1BC3DA',
                            },
                            1: {
                                color: '#3C57DE',
                                offset: 0.04,
                            },
                        }
                    },
                    device: {
                        width: 200,
                        height: 200,
                        pieHole: this.pieHole,
                        legend: 'none',
                        pieSliceText: 'none',
                        tooltip: {
                            trigger: 'none',
                        },
                        slices: {
                            0: {
                                color: '#FFD954',
                            },
                            1: {
                                color: '#F03357',
                                offset: 0.04,
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
    background-color: white;
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
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
}
.dot {
    height: 8px;
    width: 8px;
    border-radius: 50%;
    display: inline-block;
}
</style>
