<template>
    <VListItem class="pl-9">
        <VListItemIcon>
            <svg>
                <use :href="icon" />
            </svg>
        </VListItemIcon>
        <VListItemTitle>
            {{ label }}
        </VListItemTitle>
    </VListItem>
</template>

<script>
    export default {
        props: {
            icon: { type: String, required: true },
            label: { type: String, required: true }
        }
    };
</script>

<style scoped lang="scss">
$blue: #3C57DE;
$grey: rgba(18, 39, 55, 0.5);

::v-deep svg {
    width: 25px;
    height: 25px;
}

.v-list-item {
    min-height: 34px;
    height: 34px;
    border-left: 3px solid transparent;
    fill-opacity: 0.5;
    .v-list-item__title {
        color: $grey;
        font-size: 14px;
    }
    a {
        width: 100%;
    }
    .v-list-item__icon {
        fill: $grey;
        align-self: center;
    }
}

.v-list-item--active
{
    .v-list-item {
        border-left: 3px solid $blue;
        .v-list-item__title {
            color: $blue;
        }
        .v-list-item__icon {
            fill: $blue;
            fill-opacity: 1;
        }
    }
}
</style>