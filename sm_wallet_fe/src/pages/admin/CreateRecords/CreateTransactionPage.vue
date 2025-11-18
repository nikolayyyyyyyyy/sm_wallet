<script setup lang="ts">
import FormInput from '@/components/FormInput.vue';
import SelectComponent from '@/components/SelectComponent.vue';
import Button from '@/components/Button.vue';
import TextareaFormInput from '@/components/TextareaFormInput.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';
import { store } from '@/crud/create';
import FormErrorMessage from '@/components/FormErrorMessage.vue';

const transactionTypes = ref(null);
const { getData } = get();
const { create } = store();
const errors = ref({});
const successMessage = ref('');
const senderDontHaveEnoughtMoney = ref('');
const transactionData = ref({
    amount: '',
    note: '',
    transaction_type_id: '',
    account_sender_number: '',
    account_receiver_number: ''
});

const storeTransaction = async () => {
    try {
        await create(transactionData.value, 'transactions');
        successMessage.value = 'Транзакцията е създадена успешно!'
        senderDontHaveEnoughtMoney.value = '';
        errors.value = {};
        Object.keys(transactionData.value).forEach(k => transactionData.value[k] = '');
    } catch (err) {
        errors.value = JSON.parse(err.message).errors;
        if (JSON.parse(err.message).notEnoughtMoney) {
            senderDontHaveEnoughtMoney.value = JSON.parse(err.message).notEnoughtMoney;
        }
        successMessage.value = '';
    }
};

onMounted(async () => {
    transactionTypes.value = (await getData('transaction-types'))
        .map(t => { return { id: t.id, text: t.transaction_type }; });
});
</script>

<template>
    <section class="section-create-transaction">
        <div class="section__inner">
            <h1 class="section__title">Добави Транзакция</h1>

            <form @submit.prevent="storeTransaction" class="base-form">
                <div class="section__form-top">
                    <FormInput label="Сума" v-model="transactionData.amount" :error="errors?.amount?.[0]" />

                    <FormInput label="Номер на карта на изпращач" v-model="transactionData.account_sender_number"
                        :error="errors?.account_sender_number?.[0]" />

                    <FormInput label="Номер на карта на получател" v-model="transactionData.account_receiver_number"
                        :error="errors?.account_receiver_number?.[0]" />
                </div>
                <TextareaFormInput label=" Бележка" v-model="transactionData.note" :error="errors?.note?.[0]" />

                <SelectComponent v-model="transactionData.transaction_type_id" label="Тип на транзакция"
                    :options="transactionTypes" name="transaction-type" id="transaction-type"
                    :error="errors?.transaction_type_id?.[0]" />

                <Button text="Добави" />

                <SuccessMessage v-if="successMessage" :text="successMessage" />

                <FormErrorMessage v-if="senderDontHaveEnoughtMoney" :text="senderDontHaveEnoughtMoney" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-transaction {
    margin-block: 32px;

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title {
        text-align: center;
        color: var(--c-gray);
    }

    form {
        width: fit-content;
        margin: auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .section__form-top {
        display: flex;
        gap: 20px;
    }
}
</style>