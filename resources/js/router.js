import Vue from "vue";
import Router from "vue-router";
Vue.use(Router);

// pages
import index from "./pages/index";
import login from "./pages/login";
import register from "./pages/register";
import admins from "./pages/admins";

// bring in all the modules routes
let routes = [
    { path: "/", name: "index", component: index },
    { path: "/login", name: "login", component: login },
    { path: "/register", name: "register", component: register },
    { path: "/admins", name: "admins", component: admins }
];

export default new Router({
    mode: "history",
    routes
});
