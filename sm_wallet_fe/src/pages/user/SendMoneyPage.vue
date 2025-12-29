<script setup>
import Card from '@/components/Card.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import { auth } from '@/crud/auth';
import { ref } from 'vue';

const { getCurrentUser } = auth();
const user = getCurrentUser();
const transaction = ref({
    accont_sender_id: 1
});
</script>

<template>
    <section class="section-send-money">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/" />

                <h1>Прати пари</h1>
            </div>

            <div class="section__content">
                <div class="section__cards">
                    <label class="content__card" v-for="(card, index) in user.cards" :key="card.id" :for="'card-' + card.id">
                        <div class="section__radio-btn" :class="{ selected: transaction.accont_sender_id === card.id }">
                            <transition name="radio-toggle" mode="out-in">
                                <svg v-if="card.id != transaction.accont_sender_id" class="unchecked" xmlns="http://www.w3.org/2000/svg" width="21"
                                    height="20" viewBox="0 0 21 20" fill="none">
                                    <circle cx="10.5" cy="10" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                                </svg>

                                <svg v-else class="checked" xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 22 24"
                                    fill="none">
                                    <circle cx="12.5" cy="12" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                                    <circle cx="12.5" cy="12" r="3.935" fill="#6784C1" stroke="#6784C1" stroke-width="2.13" />
                                </svg>
                            </transition>
                        </div>
                        
                        <input type="radio" name="card" :id="'card-' + card.id" v-model="transaction.accont_sender_id" :value="card.id" hidden>

                        <Card :card :class="{ light: index % 2 == 0, gray: index % 2 == 1 }" />
                    </label>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-send-money{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
    }

    .section__content{
        display: flex;

        .section__cards{
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 25%;
        }
    }

    .section__radio-btn{
        display: flex;
        align-items: center;
    }

    .radio-toggle-enter-active,
    .radio-toggle-leave-active {
        transition: opacity 0.1s ease;
    }

    .radio-toggle-enter-from,
    .radio-toggle-leave-to {
        opacity: 0;
    }

    .content__card{
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    :deep(.section__card){
        width: 350px;
    }
}
</style>