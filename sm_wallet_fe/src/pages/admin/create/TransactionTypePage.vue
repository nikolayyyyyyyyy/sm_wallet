<script setup>
import { onMounted, ref } from 'vue';
import FormInput from '@/components/FormInput.vue';
import Button from '@/components/Button.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
import { store } from '@/crud/create';
import { useRouter } from 'vue-router';
import GoToArrow from '@/components/GoToArrow.vue';
const router = useRouter();
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

onMounted(() => {
    if (!localStorage.getItem('token')) {
        router.push('/login');
    }
});
</script>

<template>
    <section class="section-create-transaction-type">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" :reversed="true" />

                <h1>Добави тип транзакция</h1>
            </div>

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

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title {
        color: var(--c-gray);
        display: grid;
        grid-template-columns: 1fr auto 1fr;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 300px;
        align-self: center;
    }
}
</style>