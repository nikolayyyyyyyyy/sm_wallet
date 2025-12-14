<script setup>
import FormErrorMessage from '@/components/FormErrorMessage.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import UserComponent from '@/components/UserComponent.vue';
import { auth } from '@/crud/auth';
import { onMounted, ref } from 'vue';

const { getCurrentUser } = auth();
const current_user = getCurrentUser();
const liked_users = ref(null);
const is_loading = ref(false);

onMounted(async () => {
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
        <div class="section__inner">
            <h1 class="section__title">
                Харесани потребители
            </h1>

            <div v-if="liked_users" class="section__users">
                <UserComponent v-for="user in liked_users" :user :chat-icon="true" />
            </div>

            <LoadingComponent v-if="is_loading" />

            <FormErrorMessage v-if="is_loading == false && liked_users != []" text="Не сте добавили никой още." />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-favorites {
    position: relative;
    margin-block: 32px;

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