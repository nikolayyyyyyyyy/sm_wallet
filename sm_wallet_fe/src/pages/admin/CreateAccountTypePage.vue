<script setup>
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import { store } from '@/crud/create';
import SuccesMessage from '@/components/SuccessMessage.vue';

const accountTypeData = ref({
    account_type: ''
});

const error = ref('');
const successMessage = ref('');
const { create } = store();
const storeAccountType = async () => {
    try {
        await create(accountTypeData.value, 'account-types');
        error.value = '';
        accountTypeData.value.account_type = '';
        successMessage.value = 'Типът акаунт е създаден успешно!'
    } catch (err) {
        error.value = JSON.parse(err.message).errors.account_type[0];
        successMessage.value = '';
    }
}
</script>

<template>
    <section class="section-create-account-type">
        <div class="section__inner">
            <h1 class="section__title">Добави Тип Акаунт</h1>

            <form @submit.prevent="storeAccountType" class="base-form">
                <FormInput label="Тип Акаунт" v-model="accountTypeData.account_type" :error="error" />

                <Button text="Добави" />

                <SuccesMessage v-if="successMessage" :text="successMessage" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-account-type {
    margin-block: 32px;

    .section__title {
        text-align: center;
        color: var(--c-gray);
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