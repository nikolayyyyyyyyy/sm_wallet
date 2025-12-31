<script setup>
import FormErrorMessage from '@/components/FormErrorMessage.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import UserComponent from '@/components/UserComponent.vue';
import { auth } from '@/crud/auth';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();

const { getCurrentUser } = auth();
const current_user = getCurrentUser();
const liked_users = ref(null);
const is_loading = ref(false);

onMounted(async () => {
    if (!localStorage.getItem('token')) {
        router.push('/login');
    }

    is_loading.value = true;
    liked_users.value = await (await fetch('http://127.0.0.1:8000/api/favorites-all', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify({ user_id: current_user.id })
    })).json();
    is_loading.value = false;
});
</script>

<template>
    <section class="section-favorites">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/"/>

                <h1>
                    Харесани потребители
                </h1>
            </div>
            
            <div class="section__content">
                <div v-if="liked_users" class="section__users">
                    <UserComponent v-for="user in liked_users" :key="user.id" :user="user" :chat-icon="true" />
                </div>

                <LoadingComponent v-if="is_loading" />

                <p v-else class="err_message">Не сте добавили никой в харесани.</p>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-favorites {
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 24px;
    }

    .loading {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--c-gray);
        font-size: 18px;
    }

    .loading_icon {
        width: 50px !important;
    }

    .section__content {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
        width: 100%;
    }

    .section__users {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
}
</style>