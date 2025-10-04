import { createWebHistory, createRouter } from "vue-router";
import LoginPage from "./pages/auth/LoginPage.vue";
import RegisterPage from "./pages/auth/RegisterPage.vue";


const routes = [
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});