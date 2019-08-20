<template>
    <VContainer
        fluid
        class="content-container"
    >
        <VLayout
            wrap
        >
            <h5>{{ title }}</h5>
        </VLayout>
        <VLayout>
            <VFlex
                lg12
                md12
                sm12
                xs12
                class="content-card"
            >
                <VLayout
                    wrap
                    align-center
                    justify-center
                >
                    <VFlex
                        class="chart-container"
                    >
                        <LineChart :data="data" />
                    </VFlex>
                </VLayout>
            </VFlex>
        </VLayout>
        <VLayout class="buttons-row">
            <VFlex
                v-for="button in buttons"
                :key="button.title"
            >
                <ButtonComponent
                    :title="button.title"
                    :character="button.character"
                    :icon-name="button.icon"
                />
            </VFlex>
        </VLayout>
        <VLayout>
            <VFlex
                lg6
                md6
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <UserTable />
            </VFlex>
            <VFlex
                lg5
                md5
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <PieChart
                    :data="pieData"
                    :legend="legend"
                />
            </VFlex>
        </VLayout>
    </VContainer>
</template>

<script>
    import LineChart from "../components/common/LineChart";
    import UserTable from "../components/dashboard/visitors/UsersTable";
    import ButtonComponent from "../components/dashboard/visitors/ButtonComponent";
    import PieChart from "../components/common/PieChart";

    export default {
        components: {
            PieChart,
            LineChart,
            UserTable,
            ButtonComponent
        },
        data() {
            return {
                data: [],
                buttons: [
                    {
                        icon: 'person',
                        title: 'Total visitors',
                        character: '120'
                    },
                    {
                        icon: 'eye',
                        title: 'New visitors',
                        character: '100'
                    },
                    {
                        icon: 'clock',
                        title: 'Avg. session',
                        character: '00:00:33'
                    },
                    {
                        icon: 'yellow_arrow',
                        title: 'Page views',
                        character: '321'
                    },
                    {
                        icon: 'peach_arrow',
                        title: 'Sessions',
                        character: '145'
                    },
                    {
                        icon: 'violet_arrow',
                        title: 'Bounce rate',
                        character: '41%'
                    },
                ],
                pieData: [
                    ['Type', 'Value']
                ],
                legend: {
                    title: 'Outcome',
                    data: {
                        newVisitors: {
                            title: 'New Visitors',
                            percentageDiff: 41,
                            color: '#3C57DE',
                        },
                        returnVisitors: {
                            title: 'Return Visitors',
                            percentageDiff: 49,
                            color: '#1BC3DA',
                        },
                    }
                }
            };
        },
        computed: {
            title () {
                return this.$route.meta.title;
            }
        },
        mounted() {
            for (let i = 1; i < 20; i++) {
                const x = new Date(2019, 9, 5, i).toLocaleTimeString();
                const item = {
                    xLabel: x,
                    value: Math.floor(Math.random() * 2000) + 1,
                    indication: Math.floor(Math.random() * 200) + 1,
                };
                this.data.push(item);
            }
            this.pieData.push(
                ['New Visitors', 41],
                ['Return Visitors', 59],
            );
        }
    };
</script>

<style scoped>
    .buttons-row {
        margin-top: 50px;
    }
    .chart-container {
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
    }
    .content-container {
        padding: 70px 66px 0 80px;
    }
</style>
