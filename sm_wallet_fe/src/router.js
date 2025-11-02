import { createWebHistory, createRouter } from "vue-router";
import LoginPage from "./pages/auth/LoginPage.vue";
import RegisterPage from "./pages/auth/RegisterPage.vue";
import DashboardPage from "./pages/DashboardPage.vue";
import ProfilePage from "./pages/auth/ProfilePage.vue";
import CreateClientPage from "./pages/admin/CreateRecords/CreateClientPage.vue";
import CreateCurrencyPage from "./pages/admin/CreateRecords/CreateCurrencyPage.vue";
import CreateAccountTypePage from "./pages/admin/CreateRecords/CreateAccountTypePage.vue";
import CreateTransactionTypePage from "./pages/admin/CreateRecords/CreateTransactionTypePage.vue";
import CreateAccountPage from "./pages/admin/CreateRecords/CreateAccountPage.vue";
import CreateTransactionPage from "./pages/admin/CreateRecords/CreateTransactionPage.vue";
import AllClientsPage from "./pages/admin/AllRecordsListing/AllClientsPage.vue";
import AllCurrenciesPage from "./pages/admin/AllRecordsListing/AllCurrenciesPage.vue";
import AllAccountTypesPage from "./pages/admin/AllRecordsListing/AllAccountTypesPage.vue";
import AllTransactionTypesPage from "./pages/admin/AllRecordsListing/AllTransactionTypesPage.vue";
import AllAccountsPage from "./pages/admin/AllRecordsListing/AllAccountsPage.vue";
import AllTransactionsPage from "./pages/admin/AllRecordsListing/AllTransactionsPage.vue";


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
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});