<template>
    <div class="container">
        <VRow
            justify="end"
            class="tab-button"
        >
            <VBtn
                color="primary"
                @click="toggleOutput"
            >
                {{ label }}
            </VBtn>
        </VRow>
        <VRow>
            <InviteMemberForm v-if="isMemberList" />
            <MenuAccessTable v-else />
        </VRow>
    </div>
</template>

<script>
    import InviteMemberForm from '@/components/team/InviteMemberForm.vue';
    import MenuAccessTable from '@/components/team/MenuAccessTable.vue';

    export default {
        components: {
            InviteMemberForm,
            MenuAccessTable
        },
        data() {
            return {
                isMemberList: true
            };
        },
        computed: {
            label() {
                return this.isMemberList ? 'Change menu access' : 'back';
            }
        },
        methods: {
            toggleOutput() {
                this.isMemberList = !this.isMemberList;
            }
        },
    };
</script>

<style lang="scss" scoped>
.tab-button{
    margin-right: 32px;
}
</style>