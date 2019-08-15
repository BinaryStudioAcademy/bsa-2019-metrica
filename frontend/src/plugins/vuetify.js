import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/src/styles/main.sass";
import light from "./theme";

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
