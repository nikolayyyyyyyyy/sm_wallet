<script setup>
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import SelectComponent from '@/components/SelectComponent.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
import TextareaFormInput from '@/components/TextareaFormInput.vue';
import { auth } from '@/crud/auth';
import { store } from '@/crud/create';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';

const { getCurrentUser, refreshUser } = auth();
let user = getCurrentUser();
const transaction = ref({
    account_sender_id: 1,
    account_receiver_number: '',
    amount: '',
    note: '',
    transaction_type_id: ''
});
const transaction_types = ref([]);
const { getData } = get();
const { create } = store();

const is_fetching = ref(false);
const success_message = ref(false);
const errors = ref();
const other_error = ref(false);
const error_message = ref();

const submitTransaction = async () => {
    if(is_fetching.value) return;

    try{
        is_fetching.value = true;
        await create(transaction.value, 'transactions');
        await refreshUser();
        
        user = getCurrentUser();
        success_message.value = true;
        errors.value = [];
        Object.keys(transaction.value).forEach(t => transaction.value[t] = '');

        setTimeout(() => {
            success_message.value = false;
        },3000);
    }catch(err){
        if(JSON.parse(err.message).errors){
            errors.value = JSON.parse(err.message).errors;
        }else if(JSON.parse(err.message).same_account){
            other_error.value = true;
            error_message.value = JSON.parse(err.message).same_account;

            setTimeout(() => {
                other_error.value = false;
            }, 3000);
        }else {
            other_error.value = true;
            error_message.value = JSON.parse(err.message).notEnoughtMoney;

            setTimeout(() => {
                other_error.value = false;
            }, 3000);
        }
    }finally{
        is_fetching.value = false;
    }
};

onMounted(async () => {
    transaction_types.value = (await getData('transaction-types'))
        .map(t => { return { id: t.id, text: t.transaction_type }; });
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
                        <div class="section__radio-btn" :class="{ selected: transaction.account_sender_id === card.id }">
                            <Transition name="radio-toggle" mode="out-in">
                                <svg v-if="card.id != transaction.account_sender_id" class="unchecked" xmlns="http://www.w3.org/2000/svg" width="21"
                                    height="20" viewBox="0 0 21 20" fill="none">
                                    <circle cx="10.5" cy="10" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                                </svg>

                                <svg v-else class="checked" xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 22 24"
                                    fill="none">
                                    <circle cx="12.5" cy="12" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                                    <circle cx="12.5" cy="12" r="3.935" fill="#6784C1" stroke="#6784C1" stroke-width="2.13" />
                                </svg>
                            </Transition>
                        </div>
                        
                        <input type="radio" name="card" :id="'card-' + card.id" v-model="transaction.account_sender_id" :value="card.id" hidden>

                        <Card :card :class="{ light: index % 2 == 0, gray: index % 2 == 1 }" />
                    </label>
                </div>

                <form @submit.prevent="submitTransaction" class="section__send__money">
                    <div class="send__money__top">
                        <FormInput label="Сметка на получател" 
                            v-model="transaction.account_receiver_number"
                            :error="errors?.account_receiver_number?.[0]"/>

                        <FormInput label="Сума" v-model="transaction.amount"
                            :error="errors?.amount?.[0]" />
                    </div>

                    <TextareaFormInput label="Бележка" v-model="transaction.note"/>

                    <SelectComponent :options="transaction_types"
                        name="select-transaction-type"
                        id="select-transaction-type"
                        v-model="transaction.transaction_type_id"
                        :error="errors?.transaction_type_id?.[0]" />
                    
                    <Button class="submit_btn" type="submit" text="Направи транзакция" />
                </form>
            </div>

            <SuccessMessage v-if="success_message" text="Успешна транзакция." :class="{'green-bg': true}"/>
            
            <p v-if="other_error" class="err_message">{{ error_message }}</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-send-money{
    margin-block: 32px;

    .err_message{
        padding: 10px;
        background: var(--c-red);
        color: var(--c-gray);
        font-size: 18px;
        align-self: center;
        width: fit-content;
        border-radius: 10px;
    }
    .submit_btn{
        width: 200px;
    }

    .section__send__money{
        display: flex;
        flex-direction: column;
        gap: 12px;

        .send__money__top{
            display: flex;
            align-items: center;
            gap:16px;
        }
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
    }

    .section__content{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 100px;

        .section__cards{
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
    }

    .section__radio-btn{
        display: flex;
        align-items: center;
    }

    .radio-toggle-enter-active,
    .radio-toggle-leave-active {
        transition: opacity 0.2s ease;
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
        flex-grow: 1;
    }
}
</style>