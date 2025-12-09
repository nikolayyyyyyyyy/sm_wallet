<script setup>
import MyCardsSection from '@/sections/MyCardsSection.vue';
import Card from '@/components/Card.vue';
import { auth } from '@/crud/auth';
import { ref } from 'vue';
import Popup from '@/components/Popup.vue';
import FormInput from '@/components/FormInput.vue';
import Button from '@/components/Button.vue';
import UserComponent from '@/components/UserComponent.vue';
import FormErrorMessage from '@/components/FormErrorMessage.vue';

const { getCurrentUser } = auth();
const user = ref(getCurrentUser());

const displayAddToFavoritesPopup = ref(false);
const userToSearch = ref({
    current_user: '',
    email: ''
});
const errors = ref(null);
const foundUser = ref(null);

const clearForm = () => {
    userToSearch.value.email = '';
    errors.value = null;
    foundUser.value = null;
};

const searchForUser = async () => {
    errors.value = null;
    foundUser.value = null;

    try {
        const baseUrl = 'http://127.0.0.1:8000/api';
        const response = await fetch(`${baseUrl}/clients/check-email`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({ email: userToSearch.value.email })
        });

        foundUser.value = (await response.json());
        errors.value = null;
    } catch (err) {
        errors.value = JSON.parse(err.message).errors;
        foundUser.value = null;
    }
};
</script>

<template>
    <section class="section-user">
        <MyCardsSection v-if="user.cards.length != 0"
            :total_price="user.cards.reduce((t, c) => t + Number(c.amount), 0)">
            <Card v-for="(card, index) in user.cards" :card :class="{ light: index % 2 == 0, gray: index % 2 == 1 }" />
        </MyCardsSection>

        <div v-else class="section__no-cards base-form">
            <p>Няма налични сметки.</p>
        </div>

        <div class="section__user-link">
            <div class="user__link">
                <div class="first">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M14.536 21.686C14.574 21.7807 14.64 21.8615 14.7253 21.9175C14.8105 21.9736 14.9108 22.0023 15.0128 21.9996C15.1148 21.997 15.2136 21.9633 15.2958 21.9029C15.3781 21.8426 15.4399 21.7585 15.473 21.662L21.973 2.662C22.005 2.5734 22.0111 2.47751 21.9906 2.38556C21.9701 2.29361 21.9238 2.2094 21.8572 2.14278C21.7906 2.07616 21.7064 2.0299 21.6144 2.00939C21.5225 1.98889 21.4266 1.995 21.338 2.027L2.33799 8.527C2.24148 8.5601 2.15741 8.62192 2.09706 8.70417C2.03671 8.78643 2.00296 8.88517 2.00035 8.98716C1.99773 9.08915 2.02638 9.18949 2.08245 9.27473C2.13851 9.35997 2.21931 9.42601 2.31399 9.464L10.244 12.644C10.4947 12.7444 10.7224 12.8945 10.9136 13.0852C11.1047 13.276 11.2552 13.5035 11.356 13.754L14.536 21.686Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M21.854 2.147L10.914 13.086" stroke="white" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <p>Изпрати</p>
            </div>


            <div @click="displayAddToFavoritesPopup = true" class="user__link">
                <div class="fourth">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                        <path fill="#ffd54f" d="m16 24l10 6l-4-10l8-8l-10-.032L16 2l-4 10H2l8 8l-4 10Z" />
                    </svg>
                </div>
                <p>Добави в любими</p>
            </div>

            <RouterLink to="/favorites" class="user__link">
                <div class="fifth">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <g fill="none">
                            <path fill="url(#SVG14vC6sni)"
                                d="M10 2a8 8 0 1 1-3.613 15.14l-.121-.065l-3.645.91a.5.5 0 0 1-.62-.441v-.082l.014-.083l.91-3.644l-.063-.12a8 8 0 0 1-.83-2.887l-.025-.382L2 10a8 8 0 0 1 8-8" />
                            <path fill="url(#SVGsqanyJ7e)"
                                d="M10.5 11h-3l-.09.008a.5.5 0 0 0 0 .984L7.5 12h3l.09-.008a.5.5 0 0 0 0-.984zm2-3h-5l-.09.008a.5.5 0 0 0 0 .984L7.5 9h5l.09-.008a.5.5 0 0 0 0-.984z" />
                            <defs>
                                <linearGradient id="SVG14vC6sni" x1="2.571" x2="16.54" y1="5" y2="28.815"
                                    gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#0FAFFF" />
                                    <stop offset="1" stop-color="#CC23D1" />
                                </linearGradient>
                                <linearGradient id="SVGsqanyJ7e" x1="7.525" x2="7.974" y1="8.07" y2="12.414"
                                    gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FDFDFD" />
                                    <stop offset="1" stop-color="#CCEAFF" />
                                </linearGradient>
                            </defs>
                        </g>
                    </svg>
                </div>
                <p>Изпрати съобщение</p>
            </RouterLink>
        </div>

        <Popup @empty-model-value="clearForm" title="Намери приятели" v-model="displayAddToFavoritesPopup">
            <FormInput v-model="userToSearch.email" label="търси по имейл" :error="errors?.email?.[0]"
                :is-for-email="true" />

            <div v-if="foundUser && !foundUser.errors" class="popup__user">
                <UserComponent :user="foundUser" />
            </div>

            <FormErrorMessage v-if="foundUser?.errors?.email" :text="foundUser.errors?.email[0]" />

            <Button @click="searchForUser" class="btn" text="Намери" />
        </Popup>
    </section>
</template>

<style scoped lang="scss">
.section-user {
    padding-inline: 20px;
    display: flex;
    flex-direction: column;
    gap: 100px;
    margin-bottom: 32px;

    .btn {
        margin-top: 30px;
    }

    :deep(.form-input) {
        width: 50%;
    }

    button {
        width: 200px;
    }

    .section__no-cards {
        font-size: 18px;
        color: var(--c-gray);
    }

    .section__user-link {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .user__link {
        display: flex;
        flex-direction: column;
        gap: 4px;
        align-items: center;
        color: var(--c-gray);
        cursor: pointer;

        .first,
        .second,
        .third,
        .fourth,
        .fifth {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 12px;
            border-radius: 9999px;
        }

        .fifth,
        .first {
            background: #4F46E5;
        }

        .fourth {
            background: rgb(130, 130, 48);
        }
    }

    a {
        text-decoration: none;
    }
}
</style>