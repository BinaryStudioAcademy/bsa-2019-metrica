<template>
    <div
        class="button-card bg-white d-inline-flex justify-content-start align-items-center"
    >
        <div
            class="card-image"
        >
            <img
                class="button-icon"
                :src="sourcePath"
            >
        </div>
        <div
            class="card-text"
        >
            <div
                class="character-text text-no-wrap headline"
            >
                {{ character }}
            </div>
            <div
                class="title-text text-no-wrap caption"
            >
                {{ title }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ButtonComponent',
        props: {
            title: {
                type:String,
                required: true
            },
            character: {
                type:String,
                required: true
            },
            iconName: {
                type:String,
                required: true
            }
        },
        computed: {
            sourcePath() {
                return `/assets/button_icons/${this.iconName}.png`;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .button-card {
        font-family: Gilroy;
        height: 100px;
        min-width: 190px;
        border-radius: 6px;
        padding-right: 40px;
        padding-left: 20px;
        transition: all .2s ease-in;

        .card-image {
            margin-right: 30px;

            .button-icon {
                height: 27px;
                width: 27px;
            }
        }

        .character-text {
            line-height: 29px;
            font-weight: 800;
        }

        .title-text {
            line-height: 14px;
            color: rgba(18, 39, 55, 0.5);
        }
    }

    .button-card:hover {
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
        border: 1px solid rgba(60, 87, 222, 0.52);
        transform: scale(1.19);
    }
</style>