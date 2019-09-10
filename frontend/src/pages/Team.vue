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
                {{ isMemberList ? 'Change menu access' : 'back' }}
            </VBtn>
        </VRow>
        <VRow>
            <InviteMemberForm v-if="isMemberList" />
            <MenuAccessTable v-if="!isMemberList" />
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