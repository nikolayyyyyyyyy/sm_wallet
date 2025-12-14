import { createWebHistory, createRouter } from "vue-router";
import LoginPage from "./pages/auth/LoginPage.vue";
import RegisterPage from "./pages/auth/RegisterPage.vue";
import DashboardPage from "./pages/DashboardPage.vue";
import ProfilePage from "./pages/auth/ProfilePage.vue";
import CreateClientPage from "./pages/admin/create/CreateClientPage.vue";
import CreateCurrencyPage from "./pages/admin/create/CreateCurrencyPage.vue";
import CreateAccountTypePage from "./pages/admin/create/CreateAccountTypePage.vue";
import CreateTransactionTypePage from "./pages/admin/create/CreateTransactionTypePage.vue";
import CreateAccountPage from "./pages/admin/create/CreateAccountPage.vue";
import CreateTransactionPage from "./pages/admin/create/CreateTransactionPage.vue";
import AllClientsPage from "./pages/admin/AllClientsPage.vue";
import AllCurrenciesPage from "./pages/admin/AllCurrenciesPage.vue";
import AllAccountTypesPage from "./pages/admin/AllAccountTypesPage.vue";
import AllTransactionTypesPage from "./pages/admin/AllTransactionTypesPage.vue";
import AllAccountsPage from "./pages/admin/AllAccountsPage.vue";
import AllTransactionsPage from "./pages/admin/AllTransactionsPage.vue";
import FavoritePage from "./pages/user/FavoritePage.vue";


const routes = [
    { path: '/', component: DashboardPage },
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
    { path: '/my-profile', component: ProfilePage },
    { path: '/create-client', component: CreateClientPage },
    { path: '/create-currency', component: CreateCurrencyPage },
    { path: '/create-account-type', component: CreateAccountTypePage },
    { path: '/create-transaction-type', component: CreateTransactionTypePage },
    { path: '/create-account', component: CreateAccountPage },
    { path: '/create-transaction', component: CreateTransactionPage },
    { path: '/clients', component: AllClientsPage },
    { path: '/currencies', component: AllCurrenciesPage },
    { path: '/account-types', component: AllAccountTypesPage },
    { path: '/transaction-types', component: AllTransactionTypesPage },
    { path: '/accounts', component: AllAccountsPage },
    { path: '/transactions', component: AllTransactionsPage },
    { path: '/favorites', component: FavoritePage }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});