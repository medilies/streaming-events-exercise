import { createRouter, createWebHistory } from "vue-router";

import HomePage from "@/pages/HomePage.vue";
import AuthPage from "@/pages/AuthPage.vue";
import CallbackPage from "@/pages/CallbackPage.vue";
import DashboardPage from "@/pages/DashboardPage.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: HomePage,
    },
    {
        path: "/auth",
        name: "auth",
        component: AuthPage,
    },
    {
        path: "/callback",
        name: "callback",
        component: CallbackPage,
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardPage,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
