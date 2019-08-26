<template>
    <ul
        class="links-list m-0 p-0"
    >
        <li class="card-title">
            <p>Top active pages</p>
            <p>Users</p>
        </li>
        <li
            v-for="page in topPages"
            class="mb-2 mt-1 px-0 py-1"
            :key="page.url"
        >
            <a
                class="link-item"
                :href="page.url"
                target="_blank"
            >
                {{ page.url }}
            </a>
            <p>{{ page.count }}</p>
        </li>
    </ul>
</template>
<script>
    export default {
        name: 'TopActivePage',
        props: {
            topPages: {
                type: Array,
                required: true
            }
        },
    };
</script>
<style lang="scss" scoped>
    .links-list {
        list-style: none;
        li {
            display: flex;
            justify-content: space-between;
        }
        .link-item {
            text-decoration:none;
            color: rgba(18, 39, 55, 0.5);
        }
    }
</style>
