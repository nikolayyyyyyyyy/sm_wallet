<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { auth } from '@/crud/auth';
import FormInput from '@/components/FormInput.vue';
const route = useRoute();

const messages = ref();
const is_loading = ref(false);
const { getCurrentUser } = auth();
const currentUser = getCurrentUser();
const messageText = ref('');

const sendMessage = async() => {
    if(!messageText.value) return;

    const response = await fetch('http://127.0.0.1:8000/api/messages/' + route.params.id, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify({
            message: messageText.value
        })
    });

    messages.value.push(await response.json());
    messageText.value = '';
};

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
                        <div v-if="message.sender.id == currentUser?.id" class="message__sender">
                            <figure class="profile__photo image-fit">
                                <img :src="message.sender.profile_photo ?? '../../../public/avatar.png'" alt="User Image" />
                            </figure>

                            <p>{{ message.message }}</p>
                        </div>

                        <div v-else class="message__receiver">
                            <figure class="profile__photo image-fit">
                                <img :src="message.sender.profile_photo ?? '../../../public/avatar.png'" alt="User Image" />
                            </figure>

                           <p>{{ message.message }}</p>
                        </div>
                    </div>
                </div>

                <form class="section__form">
                    <FormInput class="input" v-model="messageText" />

                        <transition name="send" mode="out-in">
                            <div v-if="messageText" key="send" @click="sendMessage" class="section__send__btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M14.536 21.686C14.574 21.7807 14.64 21.8615 14.7253 21.9175C14.8105 21.9736 14.9108 22.0023 15.0128 21.9996C15.1148 21.997 15.2136 21.9633 15.2958 21.9029C15.3781 21.8426 15.4399 21.7585 15.473 21.662L21.973 2.662C22.005 2.5734 22.0111 2.47751 21.9906 2.38556C21.9701 2.29361 21.9238 2.2094 21.8572 2.14278C21.7906 2.07616 21.7064 2.0299 21.6144 2.00939C21.5225 1.98889 21.4266 1.995 21.338 2.027L2.33799 8.527C2.24148 8.5601 2.15741 8.62192 2.09706 8.70417C2.03671 8.78643 2.00296 8.88517 2.00035 8.98716C1.99773 9.08915 2.02638 9.18949 2.08245 9.27473C2.13851 9.35997 2.21931 9.42601 2.31399 9.464L10.244 12.644C10.4947 12.7444 10.7224 12.8945 10.9136 13.0852C11.1047 13.276 11.2552 13.5035 11.356 13.754L14.536 21.686Z"
                                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M21.854 2.147L10.914 13.086" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </transition>
                </form>
            </div>

            <LoadingComponent v-else class="loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-chat-with-user{
    margin-block: 32px;
    color: var(--c-gray);

    .section__form{
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .section__send__btn{
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        background-color: var(--c-base);
        border-radius: 8px;
        cursor: pointer;
        transition: transform .18s ease, opacity .18s ease;
    }

    .input{
        flex-grow: 1;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .profile__photo{
        width: 20px;
        aspect-ratio: 1 / 1;
        border-radius: 50%;
        margin-right: 12px;
    }

    .message__receiver,
    .message__sender{
        display: flex;
        align-items: center;
        p{
            width: fit-content;
            padding: 8px 12px;
            background: var(--c-base);
        }
    }

    .message{
        display: flex;
        align-items: center;
    }

    .message__sender{
        flex-direction: row-reverse;
        gap:12px;
        margin-left: auto;
    }
    .message__sender p{
        border-radius: 12px 12px 0 12px;
    }

    .message__receiver p{
        border-radius: 12px 12px 12px 0;
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
        justify-content: flex-end;
        gap: 12px;
        background: var(--c-grayed);
        padding: 16px;
        border-radius: 8px;
        height: 300px;
        overflow-y: auto;
    }

    .send-enter-active,
    .send-leave-active {
        transition: opacity .18s ease, transform .18s ease;
    }
    .send-enter-from,
    .send-leave-to {
        opacity: 0;
        transform: translateY(6px) scale(0.92);
    }
    .send-enter-to,
    .send-leave-from {
        opacity: 1;
        transform: translateY(0) scale(1);
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