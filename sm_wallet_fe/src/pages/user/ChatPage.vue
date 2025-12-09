<script setup>
import { onMounted, ref, onUnmounted, nextTick } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { auth } from '@/crud/auth';

const route = useRoute();
const router = useRouter();
const { getCurrentUser } = auth();
const current_user = getCurrentUser();

const otherUserId = ref(route.params.id);
const otherUser = ref(null);
const messages = ref([]);
const newMessage = ref('');
const messagesContainer = ref(null);
const pollInterval = ref(null);

const loadUserInfo = async () => {
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/clients`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        if (response.ok) {
            const users = await response.json();
            otherUser.value = users.find(u => u.id === parseInt(otherUserId.value));
        }
    } catch (error) {
        console.error('Error loading user info:', error);
    }
};

const loadMessages = async () => {
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/chat/messages?user_id=${otherUserId.value}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });

        if (response.ok) {
            messages.value = await response.json();
            
            // Get other user info from first message
            if (messages.value.length > 0) {
                const firstMessage = messages.value[0];
                otherUser.value = current_user.id === firstMessage.sender_id 
                    ? firstMessage.receiver 
                    : firstMessage.sender;
            }
            
            await nextTick();
            scrollToBottom();
        }
    } catch (error) {
        console.error('Error loading messages:', error);
    }
};

const sendMessage = async () => {
    if (!newMessage.value.trim()) return;

    try {
        const response = await fetch('http://127.0.0.1:8000/api/chat/messages', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({
                receiver_id: otherUserId.value,
                message: newMessage.value
            })
        });

        if (response.ok) {
            const sentMessage = await response.json();
            messages.value.push(sentMessage);
            newMessage.value = '';
            await nextTick();
            scrollToBottom();
        }
    } catch (error) {
        console.error('Error sending message:', error);
    }
};

const scrollToBottom = () => {
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays === 1) {
        return 'Днес';
    } else if (diffDays === 2) {
        return 'Вчера';
    } else {
        return date.toLocaleDateString('bg-BG');
    }
};

const formatTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleTimeString('bg-BG', { hour: '2-digit', minute: '2-digit' });
};

onMounted(async () => {
    await loadUserInfo();
    await loadMessages();
    // Poll for new messages every 3 seconds
    pollInterval.value = setInterval(loadMessages, 3000);
});

onUnmounted(() => {
    if (pollInterval.value) {
        clearInterval(pollInterval.value);
    }
});
</script>

<template>
    <section class="section-chat">
        <div class="section__inner">
            <div class="chat__header">
                <button @click="router.back()" class="back-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </button>
                <h1 class="section__title">
                    {{ otherUser ? `${otherUser.name} ${otherUser.middle_name || ''} ${otherUser.last_name || ''}`.trim() : 'Чат' }}
                </h1>
            </div>

            <div ref="messagesContainer" class="chat__messages">
                <div v-if="messages.length === 0" class="chat__empty">
                    <p>Няма съобщения. Започнете разговор!</p>
                </div>
                <div v-for="(message, index) in messages" :key="message.id" class="message-wrapper">
                    <div v-if="index === 0 || new Date(message.created_at).toDateString() !== new Date(messages[index - 1].created_at).toDateString()" 
                         class="date-divider">
                        {{ formatDate(message.created_at) }}
                    </div>
                    <div class="message" :class="{ 'message--sent': message.sender_id === current_user.id, 'message--received': message.sender_id !== current_user.id }">
                        <div class="message__content">
                            <p>{{ message.message }}</p>
                            <span class="message__time">{{ formatTime(message.created_at) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat__input">
                <input 
                    v-model="newMessage" 
                    type="text" 
                    placeholder="Напишете съобщение..."
                    @keyup.enter="sendMessage"
                    class="chat-input"
                />
                <button @click="sendMessage" class="send-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                </button>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-chat {
    position: relative;
    margin-block: 32px;
    height: calc(100vh - 200px);
    display: flex;
    flex-direction: column;

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 16px;
        height: 100%;
        max-width: 800px;
        width: 100%;
        margin: 0 auto;
        padding: 0 20px;
    }

    .chat__header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #475569;

        .back-button {
            background: transparent;
            border: none;
            color: var(--c-gray);
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: background 0.2s;

            &:hover {
                background: #334155;
            }
        }

        .section__title {
            color: var(--c-gray);
            font-size: 20px;
            margin: 0;
        }
    }

    .chat__messages {
        flex: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 16px 0;

        .chat__empty {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--c-gray);
            opacity: 0.6;
        }

        .date-divider {
            text-align: center;
            color: var(--c-gray);
            font-size: 12px;
            opacity: 0.7;
            padding: 8px 0;
        }

        .message-wrapper {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .message {
            max-width: 70%;
            display: flex;
            flex-direction: column;

            &--sent {
                align-self: flex-end;

                .message__content {
                    background: var(--c-blue);
                    border-radius: 18px 18px 4px 18px;
                }
            }

            &--received {
                align-self: flex-start;

                .message__content {
                    background: #334155;
                    border: 1px solid #475569;
                    border-radius: 18px 18px 18px 4px;
                }
            }

            .message__content {
                padding: 12px 16px;
                display: flex;
                flex-direction: column;
                gap: 4px;

                p {
                    margin: 0;
                    color: var(--c-white);
                    font-size: 15px;
                    word-wrap: break-word;
                }

                .message__time {
                    font-size: 11px;
                    color: var(--c-gray);
                    opacity: 0.7;
                    align-self: flex-end;
                }
            }
        }
    }

    .chat__input {
        display: flex;
        gap: 12px;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid #475569;

        .chat-input {
            flex: 1;
            border-radius: 8px;
            padding: 13px;
            border: 1px solid #475569;
            background: #334155;
            color: var(--c-white);
            font-size: 15px;

            &::placeholder {
                color: var(--c-gray);
                opacity: 0.7;
            }
        }

        .send-button {
            background: var(--c-blue);
            border: none;
            color: var(--c-white);
            cursor: pointer;
            padding: 13px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.2s;

            &:hover {
                opacity: 0.9;
            }

            &:active {
                opacity: 0.8;
            }
        }
    }
}
</style>

