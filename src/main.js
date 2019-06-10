import Vue from "vue";
import "./plugins/vuetify";
// import "./plugins/axios";
import App from "./App.vue";
import router from "./router";
import Axios from "axios";

Vue.config.productionTip = false;

const base = Axios.create({
    baseURL: "http://beasiswa.test"
});

Vue.prototype.$http = base;

new Vue({
    router,
    render: h => h(App)
}).$mount("#app");
