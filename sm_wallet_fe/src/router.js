import { createWebHistory, createRouter } from "vue-router";
import LoginPage from "./pages/auth/LoginPage.vue";
import RegisterPage from "./pages/auth/RegisterPage.vue";
import DashboardPage from "./pages/DashboardPage.vue";
import ProfilePage from "./pages/auth/ProfilePage.vue";
import CreateClientPage from "./pages/admin/CreateClientPage.vue";
import CreateCurrencyPage from "./pages/admin/CreateCurrencyPage.vue";
import CreateAccountTypePage from "./pages/admin/CreateAccountTypePage.vue";
import CreateTransactionTypePage from "./pages/admin/CreateTransactionTypePage.vue";


const routes = [
    { path: '/', component: DashboardPage },
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
    { path: '/my-profile', component: ProfilePage },
    { path: '/create-client', component: CreateClientPage },
    { path: '/create-currency', component: CreateCurrencyPage },
    { path: '/create-account-type', component: CreateAccountTypePage },
    { path: '/create-transaction-type', component: CreateTransactionTypePage }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});