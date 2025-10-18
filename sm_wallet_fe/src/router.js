import { createWebHistory, createRouter } from "vue-router";
import LoginPage from "./pages/auth/LoginPage.vue";
import RegisterPage from "./pages/auth/RegisterPage.vue";
import DashboardPage from "./pages/DashboardPage.vue";
import ProfilePage from "./pages/auth/ProfilePage.vue";
import CreateClientPage from "./pages/admin/CreateClientPage.vue";
import CreateEmployeesPage from "./pages/admin/CreateEmployeesPage.vue";


const routes = [
    { path: '/', component: DashboardPage },
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
    { path: '/my-profile', component: ProfilePage },
    { path: '/create-client', component: CreateClientPage },
    { path: '/create-employee', component: CreateEmployeesPage }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});