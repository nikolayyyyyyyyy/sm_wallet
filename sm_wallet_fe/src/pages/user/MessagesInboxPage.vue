<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import UserComponent from '@/components/UserComponent.vue';
import FormErrorMessage from '@/components/FormErrorMessage.vue';

const router = useRouter();
const route = useRoute();
const unreadMessages = ref([]);
const totalUnreadCount = ref(0);
const isLoading = ref(true);

const loadUnreadMessages = async () => {
    try {
        isLoading.value = true;
        const response = await fetch('http://127.0.0.1:8000/api/chat/unread', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });

        if (response.ok) {
            const data = await response.json();
            unreadMessages.value = data.messages;
            totalUnreadCount.value = data.total_unread_count;
        }
    } catch (error) {
        console.error('Error loading unread messages:', error);
    } finally {
        isLoading.value = false;
    }
};

const navigateToChat = (senderId) => {
    router.push(`/chat/${senderId}`);
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    const diffHours = Math.ceil(diffTime / (1000 * 60 * 60));
    const diffMinutes = Math.ceil(diffTime / (1000 * 60));

    if (diffMinutes < 60) {
        return `Преди ${diffMinutes} мин`;
    } else if (diffHours < 24) {
        return `Преди ${diffHours} ч`;
    } else if (diffDays === 1) {
        return 'Днес';
    } else if (diffDays === 2) {
        return 'Вчера';
    } else {
        return date.toLocaleDateString('bg-BG');
    }
};

const truncateMessage = (message, maxLength = 50) => {
    if (message.length <= maxLength) return message;
    return message.substring(0, maxLength) + '...';
};

// Reload messages when route changes (user comes back from chat)
watch(() => route.path, () => {
    if (route.path === '/messages') {
        loadUnreadMessages();
    }
});

onMounted(() => {
    loadUnreadMessages();
});
</script>

<template>
    <section class="section-inbox">
        <div class="section__inner">
            <h1 class="section__title">
                Съобщения
                <span v-if="totalUnreadCount > 0" class="badge">{{ totalUnreadCount }}</span>
            </h1>

            <div v-if="isLoading" class="loading">
                <p>Зареждане...</p>
            </div>

            <div v-else-if="unreadMessages.length > 0" class="messages-list">
                <div v-for="messageGroup in unreadMessages" :key="messageGroup.sender.id"
                    @click="navigateToChat(messageGroup.sender.id)" class="message-item">
                    <div class="message-item__user">
                        <UserComponent :user="messageGroup.sender" :chat-icon="false" />
                    </div>
                    <div class="message-item__content">
                        <p class="message-preview">{{ truncateMessage(messageGroup.latest_message.message) }}</p>
                        <div class="message-item__meta">
                            <span class="message-time">{{ formatDate(messageGroup.latest_message.created_at) }}</span>
                            <span v-if="messageGroup.unread_count > 1" class="unread-badge">
                                {{ messageGroup.unread_count }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <FormErrorMessage v-else text="Нямате нови съобщения." />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-inbox {
    position: relative;
    margin-block: 32px;

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        max-width: 600px;
        width: 100%;
        padding: 0 20px;
    }

    .section__title {
        color: var(--c-gray);
        text-align: center;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;

        .badge {
            background: var(--c-red);
            color: var(--c-white);
            border-radius: 50%;
            padding: 4px 10px;
            font-size: 14px;
            font-weight: bold;
            min-width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }

    .loading {
        text-align: center;
        color: var(--c-gray);
        padding: 40px 0;
    }

    .messages-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .message-item {
        padding: 16px;
        border-radius: 10px;
        background: var(--c-blue);
        border: 1px solid var(--c-white);
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        gap: 12px;

        &:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .message-item__user {
            .user {
                width: 100%;
            }
        }

        .message-item__content {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding-left: 16px;

            .message-preview {
                color: var(--c-gray);
                font-size: 15px;
                margin: 0;
                line-height: 1.4;
            }

            .message-item__meta {
                display: flex;
                justify-content: space-between;
                align-items: center;

                .message-time {
                    color: var(--c-gray);
                    font-size: 12px;
                    opacity: 0.7;
                }

                .unread-badge {
                    background: var(--c-red);
                    color: var(--c-white);
                    border-radius: 12px;
                    padding: 2px 8px;
                    font-size: 12px;
                    font-weight: bold;
                    min-width: 20px;
                    text-align: center;
                }
            }
        }
    }
}
</style>
