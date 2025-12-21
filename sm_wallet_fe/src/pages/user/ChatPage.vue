<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { auth } from '@/crud/auth';
const route = useRoute();

const messages = ref();
const is_loading = ref(false);
const { getCurrentUser } = auth();
const currentUser = getCurrentUser();

onMounted(async () => {
    is_loading.value = true;
    messages.value = await(await fetch('http://127.0.0.1:8000/api/messages/' + route.params.id,{
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })).json();
    is_loading.value = false;
});
</script>

<template>
    <section class="section-chat-with-user">
        <div class="section__inner shell">
            <GoToArrow :reversed="true" nav-to="/favorites" />

            <div v-if="!is_loading" class="section__chat">
                <p class="chat__title">
                    <figure class="chat__image image-fit">
                        <img :src="messages?.[0]?.receiver?.profile_photo ?? '../../../public/avatar.png'" alt="User Image" />
                    </figure>

                    <p class="title__text">
                        {{ messages?.[0]?.receiver?.name }}
                        {{ messages?.[0]?.receiver?.middle_name }}
                        {{ messages?.[0]?.receiver?.last_name }}
                    </p>
                </p>

                <div class="chat__messages">
                    <div v-for="message in messages" :key="message.id" class="message">
                        <p v-if="message.sender.id == currentUser?.id" class="message__sender">
                            {{ message.message }}
                        </p>
                        <p v-else class="message__receiver">
                            {{ message.message }}
                        </p>
                    </div>
                </div>
            </div>

            <LoadingComponent v-else class="loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-chat-with-user{
    margin-block: 32px;
    color: var(--c-gray);

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .chat__title{
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 24px;
        font-weight: 500;
        background-color: var(--c-grayed);
        padding: 12px 16px;
        border-radius: 8px;

        .chat__image{
            width: 50px;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
        }
    }

    .chat__messages{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .section__chat{
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 70%;
        align-self: center;
    }

    .loading{
        align-self: center;
    }
}
</style>