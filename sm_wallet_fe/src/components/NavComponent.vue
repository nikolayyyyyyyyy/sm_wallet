<script setup>
import { auth } from '../crud/auth';
import { useRouter } from 'vue-router';
const router = useRouter();
const { isLogged, logoutUser } = auth();

const logout = async () => {
    await logoutUser();
    router.push('/login');
};
</script>

<template>
    <nav class="nav shell">
        <div class="nav-auth-links">
            <RouterLink v-if="isLogged()" class="nav-item" to="/my-profile">
                <p>Профил</p>

                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                    <path
                        d="M19.2188 21.5V19.5C19.2188 18.4391 18.7973 17.4217 18.0472 16.6716C17.297 15.9214 16.2796 15.5 15.2188 15.5H9.21875C8.15788 15.5 7.14047 15.9214 6.39032 16.6716C5.64018 17.4217 5.21875 18.4391 5.21875 19.5V21.5"
                        stroke="#232323" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M12.2188 11.5C14.4279 11.5 16.2188 9.70914 16.2188 7.5C16.2188 5.29086 14.4279 3.5 12.2188 3.5C10.0096 3.5 8.21875 5.29086 8.21875 7.5C8.21875 9.70914 10.0096 11.5 12.2188 11.5Z"
                        stroke="#232323" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </RouterLink>

            <RouterLink v-if="!isLogged()" class="nav-item" to="/login">
                <p>Вход</p>

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-share">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h3" />
                    <path d="M16 22l5 -5" />
                    <path d="M21 21.5v-4.5h-4.5" />
                </svg>
            </RouterLink>

            <RouterLink v-if="!isLogged()" class="nav-item" to="/register">
                <p>Регистрация</p>

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-database-edit">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
                    <path d="M4 6v6c0 1.657 3.582 3 8 3c.478 0 .947 -.016 1.402 -.046" />
                    <path d="M20 12v-6" />
                    <path d="M4 12v6c0 1.526 3.04 2.786 6.972 2.975" />
                    <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                </svg>
            </RouterLink>
        </div>

        <div class="nav-logout">
            <RouterLink v-if="isLogged()" @click="logout" class="nav-item logout" to="/login">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                    <path d="M9 12h12l-3 -3" />
                    <path d="M18 15l3 -3" />
                </svg>

                <p>Изход</p>
            </RouterLink>
        </div>
    </nav>
</template>

<style scoped lang="scss">
.nav {
    display: flex;
    justify-content: space-between;
    background-color: var(--c-base);
    padding-block: 10px;
    border-bottom: 1px solid #334155;

    .nav-auth-links {
        display: flex;
        gap: 12px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 3px;
        padding: 5px;
        border-radius: 5px;
        background-color: var(--c-white);
        text-decoration: none;
        color: var(--c-black);
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .nav-item:hover {
        background: #f9eded;
    }

    p {
        font-weight: 500;
        font-size: 18px;
    }
}
</style>