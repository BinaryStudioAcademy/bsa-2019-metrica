<template>
    <VContainer class="list-container">
        <VSubheader
            class="header my-3 text-dark"
            fluid
        >
            Countries
        </VSubheader>
        <div class="scrollable-wrapper">
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
        </div>
    </VContainer>
</template>

<script>
    export default {
        props: {
            dataItems: {
                type: Array,
                required: true,
            },
            displayedParameter: {
                type: String,
                required: true,
            }
        },
        computed: {
            listData () {
                if (!this.dataItems.length) {
                    return [];
                }

                if(this.displayedParameter === 'bounce_rate') {
                    return this.dataItems.map((item) => {
                        return {
                            country: item.country,
                            percentage: Math.round(item[this.displayedParameter]*100)
                        };
                    });
                }

                let totalSum = 0;

                this.dataItems.forEach(item => {
                    totalSum += Number(item[this.displayedParameter]) || 0;
                });

                totalSum = totalSum === 0 ? 1: totalSum;

                return this.dataItems.map((item) => {
                    return {
                        country: item.country,
                        percentage: Math.round(Number(item[this.displayedParameter])*100/totalSum)
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

        .scrollable-wrapper {
            max-height: 20rem;
            overflow-y: auto;

            &::-webkit-scrollbar {
                background-color: #f5f8fd;
                width: 16px
            }

            &::-webkit-scrollbar-track {
                background-color: #f5f8fd
            }

            &::-webkit-scrollbar-track:hover {
                background-color: #f5f8fd
            }

            &::-webkit-scrollbar-thumb {
                background-color: #babac0;
                border-radius: 16px;
                border: 5px solid #fff
            }

            &::-webkit-scrollbar-thumb:hover {
                background-color: #a0a0a5;
                border: 4px solid #f4f4f4
            }

            &::-webkit-scrollbar-button {
                display: none
            }
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