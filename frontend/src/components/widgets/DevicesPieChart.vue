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
                <PieChartItem
                    v-for="(item, key) in chartData"
                    :data="item.data"
                    :slices="item.slices"
                    :legend="item.legend"
                    :key="key"
                />
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
    import Spinner from '@/components/utilites/Spinner';
    import PeriodDropdown from "@/components/dashboard/common/PeriodDropdown";
    import PieChartItem from "@/components/widgets/PieChartItem";

    export default {
        components: {
            Spinner,
            PeriodDropdown,
            PieChartItem
        },
        props: {
            data: {
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
                    systems: {
                        slices: {
                            0: {
                                color: '#3C57DE',
                            },
                            1: {
                                color: '#1BC3DA',
                            },
                            2: {
                                color: '#67C208',
                            },
                        },
                        data: this.data.system,
                        legend: {
                            title: 'System',
                            data: {
                                mac: {
                                    title: 'Mac',
                                    percentageDiff: 25,
                                    color: '#3C57DE',
                                },
                                windows: {
                                    title: 'Windows',
                                    percentageDiff: 65,
                                    color: '#1BC3DA',
                                },
                                others: {
                                    title: 'Others',
                                    percentageDiff: 10,
                                    color: '#67C208',
                                },
                            }
                        }
                    },
                    devices: {
                        slices: {
                            0: {
                                color: '#F03357',
                            },
                            1: {
                                color: '#ff9900',
                            },
                            2: {
                                color: '#FFD954',
                            },
                        },
                        data: this.data.device,
                        legend: {
                            title: 'Device',
                            data: {
                                desktop: {
                                    title: 'Desktop',
                                    percentageDiff: 25,
                                    color: '#F03357',
                                },
                                mobile: {
                                    title: 'Mobile',
                                    percentageDiff: 65,
                                    color: '#ff9900',
                                },
                                tablet: {
                                    title: 'Tablet',
                                    percentageDiff: 10,
                                    color: '#FFD954',
                                },
                            }
                        }
                    }
                },
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
</style>
