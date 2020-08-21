import Vue from "vue";
import Router from "vue-router";
import Home from "./components/Home.vue";

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: "/",
            name: "home",
            component: Home
        },
        {
            path: "/aspek",
            name: "aspek",
            component: () => import("./components/Aspek.vue")
        },
        {
            path: "/kriteria",
            name: "kriteria",
            component: () => import("./components/Kriteria.vue")
        },
        {
            path: "/nilai",
            name: "profil",
            component: () => import("./components/Profil.vue")
        },
        {
            path: "/hitung",
            name: "hitung",
            component: () => import("./components/Hitung.vue")
        }
        // {
        //     path: "/about",
        //     name: "about",
        //     // route level code-splitting
        //     // this generates a separate chunk (about.[hash].js) for this route
        //     // which is lazy-loaded when the route is visited.
        //     component: () =>
        //         import(/* webpackChunkName: "about" */ "./views/About.vue")
        // }
    ]
});
