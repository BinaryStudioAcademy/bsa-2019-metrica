<template>
    <VContainer
        fluid
    >
        <VLayout
            wrap
        >
            <h4>{{ title }}</h4>
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
                    <VFlex>
                        <LineChart :data="data" />
                    </VFlex>
                </VLayout>
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
        </VLayout>
    </VContainer>
</template>

<script>
    import LineChart from "../components/common/LineChart";
    import UserTable from "../components/dashboard/visitors/UsersTable";

    export default {
        components: {
            LineChart,
            UserTable
        },
        data() {
            return {
                data: [],
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
        }
    };
</script>

<style scoped>
</style>