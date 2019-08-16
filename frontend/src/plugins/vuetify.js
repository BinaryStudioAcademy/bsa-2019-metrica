import Vue from "vue";
import Vuetify from "vuetify";
import light from "./theme";
import "@/scss/main.scss";

Vue.use(Vuetify);

export default new Vuetify({
  icons: {
    iconfont: 'mdi',
  },
  options: {
    customProperties: true,
  },
  theme: {
    themes: { light }
  },
});
