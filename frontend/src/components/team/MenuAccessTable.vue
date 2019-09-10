<template>
    <ContentLayout>
        <VFlex
            lg12
            md12
            sm12
            xs12
        >
            <VSimpleTable>
                <thead>
                    <th>Team Member</th>
                    <th>Visitors</th>
                    <th>Page Views</th>
                    <th>Geo location</th>
                    <th>Behaviour</th>
                    <th>Screencast</th>
                    <th>Page Timings</th>
                    <th>Error Reports</th>
                </thead>
                <tbody>
                    <tr
                        v-for="member in localTeam"
                        :key="member.name"
                    >
                        <td>{{ member.name }}</td>
                        <td
                            v-for="item in menu_items"
                            :key="item"
                        >
                            <VCheckbox
                                v-model="member.permitted_menu"
                                :value="item"
                            />
                        </td>
                    </tr>
                </tbody>
            </VSimpleTable>
            <VCardActions class="px-0 mt-8 mb-12 ml-6">
                <VBtn
                    @click="update"
                    color="primary"
                    width="100"
                >
                    update
                </VBtn>
            </VCardActions>
        </VFlex>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../layout/ContentLayout.vue';
    import { mapGetters, mapActions } from 'vuex';
    import {GET_CURRENT_TEAM} from "../../store/modules/team/types/getters";
    import {UPDATE_MENU_ACCESS} from "../../store/modules/team/types/actions";

    export default {
        name: 'MenuAccessTable',
        components: {ContentLayout},
        data () {
            return {
                menu_items: [
                    'visitors',
                    'page-views',
                    'geo-location',
                    'behaviour',
                    'screencast',
                    'page-timings',
                    'error-reports'
                ],
                localTeam: null
            };
        },
        computed: {
            ...mapGetters('team', {
                currentTeam: GET_CURRENT_TEAM
            })
        },
        created() {
            this.localTeam = this.currentTeam.map(member => {
                return {
                    id: member.id,
                    name: member.name,
                    email: member.email,
                    permitted_menu: member.permitted_menu.split(', '),
                };
            });
        },
        methods: {
            ...mapActions('team', {
                updateMenuAccess: UPDATE_MENU_ACCESS
            }),
            update() {
                let ids = this.localTeam.map(m => m.id);
                let permitted_menu = this.localTeam.map(m => m.permitted_menu.join(', '));
                let data = {
                    ids: ids,
                    permitted_menu: permitted_menu
                };
                this.updateMenuAccess(data);
            },
        },
    };
</script>