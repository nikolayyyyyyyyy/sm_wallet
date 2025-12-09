<script setup>
import UserComponent from '@/components/UserComponent.vue';
import { auth } from '@/crud/auth';
import { onMounted, ref } from 'vue';

const { getCurrentUser } = auth();
const current_user = getCurrentUser();
const liked_users = ref(null);

onMounted(async () => {
    liked_users.value = await (await fetch('http://127.0.0.1:8000/api/favorites-all', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify({ user_id: current_user.id })
    })).json();
});
</script>

<template>
    <section class="section-favorites">
        <div class="section__inner">
            <h1 class="section__title">
                Харесани потребители
            </h1>

            <div class="section__users">
                <UserComponent v-for="user in liked_users" :user :chat-icon="true" />
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-favorites {
    position: relative;
    margin-block: 32px;

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .section__title {
        color: var(--c-gray);
        text-align: center;
    }

    .section__users {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
}
</style>