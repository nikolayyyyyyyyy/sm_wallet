import { createWebHistory, createRouter } from "vue-router";
import LoginPage from "./pages/auth/LoginPage.vue";
import RegisterPage from "./pages/auth/RegisterPage.vue";
import DashboardPage from "./pages/DashboardPage.vue";
import ProfilePage from "./pages/auth/ProfilePage.vue";
import CreateClientPage from "./pages/admin/create/ClientPage.vue";
import CreateCurrencyPage from "./pages/admin/create/CurrencyPage.vue";
import CreateAccountTypePage from "./pages/admin/create/AccountTypePage.vue";
import CreateTransactionTypePage from "./pages/admin/create/TransactionTypePage.vue";
import CreateAccountPage from "./pages/admin/create/AccountPage.vue";
import CreateTransactionPage from "./pages/admin/create/TransactionPage.vue";
import AllClientsPage from "./pages/admin/all/ClientsPage.vue";
import AllCurrenciesPage from "./pages/admin/all/CurrenciesPage.vue";
import AllAccountTypesPage from "./pages/admin/all/AccountTypesPage.vue";
import AllTransactionTypesPage from "./pages/admin/all/TransactionTypesPage.vue";
import AllAccountsPage from "./pages/admin/all/AccountsPage.vue";
import AllTransactionsPage from "./pages/admin/all/TransactionsPage.vue";
import FavoritePage from "./pages/user/FavoritePage.vue";
import SendMoneyPage from "./pages/user/SendMoneyPage.vue";
import CurrencyUpdatePage from "./pages/admin/update/CurrencyUpdatePage.vue";
import AccountTypeUpdate from "./pages/admin/update/AccountTypeUpdate.vue";
import TransactionTypeUpdate from "./pages/admin/update/TransactionTypeUpdate.vue";
import ChatPage from "./pages/user/ChatPage.vue";

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
    { path: '/favorites', component: FavoritePage },
    { path: '/send-money', component: SendMoneyPage},
    { path: '/currencies/:id/update', name: 'currencies.update', component: CurrencyUpdatePage, props: true },
    { path: '/account-types/:id/update', name: 'account-types.update', component: AccountTypeUpdate, props: true },
    { path: '/transaction-types/:id/update', name: 'transaction-types.update', component: TransactionTypeUpdate, props: true },
    { path: '/chat/:id', name: 'chat', component: ChatPage, props: true }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});