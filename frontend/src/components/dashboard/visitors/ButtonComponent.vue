<template>
    <div
        class="button-card bg-white d-inline-flex justify-content-start align-items-center"
    >
        <div
            class="card-image"
        >
            <img
                class="button-icon"
                :src="iconSrs"
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
    import getIcon from "./iconsConfig"

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
            iconKey: {
                type:String,
                required: true
            }
        },
        computed: {
            iconSrs ()  {
                return "data:image/png;base64," + getIcon(this.iconKey);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .button-card {
        font-family: Gilroy;
        height: 100px;
        min-width: 190px;
        border-radius: 6px;
        padding-right: 40px;
        padding-left: 20px;

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
</style>