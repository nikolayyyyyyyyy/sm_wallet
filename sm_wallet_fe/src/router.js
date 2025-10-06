import { createWebHistory, createRouter } from "vue-router";
import LoginPage from "./pages/auth/LoginPage.vue";
import RegisterPage from "./pages/auth/RegisterPage.vue";
import DashboardPage from "./pages/DashboardPage.vue";


const routes = [
    { path: '/', component: DashboardPage },
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});