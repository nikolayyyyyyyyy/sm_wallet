import { createMemoryHistory, createRouter } from "vue-router";
import LoginPage from "./pages/auth/LoginPage.vue";


const routes = [
    { path: '/login', component: LoginPage }
]

export const router = createRouter({
    history: createMemoryHistory(),
    routes
});