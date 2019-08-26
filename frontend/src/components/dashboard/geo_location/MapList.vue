<template>
    <VContainer class="list-container">
        <VSubheader
            class="header my-3 text-dark"
            fluid
        >
            Countries
        </VSubheader>
        <VListItem
            v-for="item in listData"
            :key="item.country"
        >
            <VListItemContent>
                <VListItemTitle class="item-title">
                    <div class="list-progress pl-5">
                        <VProgressLinear
                            :value="item.percentage"
                            height="4"
                            color="#7183DC"
                        />
                    </div>
                    <span class="percentage pr-6">{{ item.percentage }}%</span>
                    {{ item.country }}
                </VListItemTitle>
            </VListItemContent>
        </VListItem>
    </VContainer>
</template>
<script>
    export default {
        props: {
            dataItems: {
                type: Array,
                required: true,
            },
            parameter: {
                type: String,
                required: true,
            }
        },
        computed: {
            listData () {
                if (!this.dataItems.length) {
                    return [];
                }
                let totalSum = 0;

                this.dataItems.map((item) => {
                    totalSum += Number(item[this.parameter]) || 0;
                });

                return this.dataItems.map((item) => {
                    return {
                        country: item.country,
                        percentage: Math.round(Number(item[this.parameter])*100/totalSum)
                    };
                });
            }
        },
    };

</script>
<style scoped lang="scss">
    .list-container {
        .header {
            margin-left: 100px;
            font-size: 14px;
        }
        .item-title {
            color: rgba(0, 0, 0, 0.5);
            font-size: 14px;

            .list-progress {
                width: 100px;
                display: inline-block;
                transform: rotate(180deg);
            }
            .percentage {
                display: inline-block;
                width: 70px;
            }
        }
    }
</style>