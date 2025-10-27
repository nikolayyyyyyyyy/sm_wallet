<script setup>
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import { store } from '@/crud/create';
import SuccesMessage from '@/components/SuccessMessage.vue';

const currencyData = ref({
    currency: ''
});

const error = ref('');
const successMessage = ref('');
const { create } = store();
const storeCurrency = async () => {
    try {
        await create(currencyData.value, 'currencies');
        error.value = '';
        currencyData.value.currency = '';
        successMessage.value = 'Валутата e създадена успешно!'
    } catch (err) {
        error.value = JSON.parse(err.message).errors.currency[0];
        successMessage.value = '';
    }
}
</script>

<template>
    <section class="section-create-currency">
        <div class="section__inner">
            <h1 class="section__title">Добави Валута</h1>

            <form @submit.prevent="storeCurrency" class="base-form">
                <FormInput label="Валута" v-model="currencyData.currency" :error="error" />

                <Button text="Добави" />

                <SuccesMessage v-if="successMessage" :text="successMessage" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-currency {
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