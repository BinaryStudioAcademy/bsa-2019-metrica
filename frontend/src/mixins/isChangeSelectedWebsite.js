import store from "../store";

export const isChangeSelectedWebsite = {
    mounted() {
        store.watch(
            (state) => state.selectedWebsite,
            (newValue, oldValue) => {
                if(newValue !== oldValue) {
                    this.onWebsiteChange();
                }
            }
        );
    },
    methods: {
        onWebsiteChange: function () {

        }
    }
};
