<script setup>
import { ref } from 'vue';
import FormInput from '@/components/FormInput.vue';
import Button from '@/components/Button.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
import { store } from '@/crud/create';

const transactionTypeData = ref({
    transaction_type: ''
});
const successMessage = ref('');
const error = ref('');
const { create } = store();

const storeTransactionType = async () => {
    try {
        await create(transactionTypeData.value, 'transaction-types');
        error.value = '';
        transactionTypeData.value.transaction_type = '';
        successMessage.value = 'Типът транзакция е създаден успешно!';
    } catch (err) {
        error.value = JSON.parse(err.message).errors.transaction_type[0];
        successMessage.value = '';
    }
}
</script>

<template>
    <section class="section-create-transaction-type">
        <div class="section__inner">
            <h1 class="section__title">Добави тип транзакция</h1>

            <form @submit.prevent="storeTransactionType" class="base-form">
                <FormInput v-model="transactionTypeData.transaction_type" label="Име на тип транзакция" :error />

                <Button text="Добави" />

                <SuccessMessage v-if="successMessage" :text="successMessage" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-transaction-type {
    margin-top: 24px;
    color: var(--c-gray);

    .section__title {
        text-align: center;
        margin-bottom: 24px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 300px;
        margin: 0 auto;
    }
}
</style>