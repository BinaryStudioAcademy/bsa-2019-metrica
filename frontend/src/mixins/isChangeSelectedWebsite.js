import {mapState} from 'vuex';

export const isChangeSelectedWebsite = {
    computed: mapState(['selectedWebsite']),
    watch: {
        selectedWebsite() {
            this.onWebsiteChange();
        }
    }
};
