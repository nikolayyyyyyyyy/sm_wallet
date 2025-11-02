<script setup>
import FormInput from '@/components/FormInput.vue';
import Button from '@/components/Button.vue';
import SelectComponent from '@/components/SelectComponent.vue';
import { ref, onMounted } from 'vue';
import { get } from '@/crud/get';
import { store } from '@/crud/create';
import SuccessMessage from '@/components/SuccessMessage.vue';

const currencies = ref([]);
const accountTypes = ref([]);
const users = ref([]);
const accoutData = ref({
    account_number: '',
    amount: '',
    interest: '',
    currency_id: '',
    account_type_id: '',
    user_id: '',
});
const errors = ref({});
const successMessage = ref('');

const { getData } = get();
const { create } = store();

const storeAccount = async () => {
    try {
        await create(accoutData.value, 'accounts');
        errors.value = {};
        accoutData.value.account_number = '';
        accoutData.value.amount = '';
        accoutData.value.interest = '';
        accoutData.value.currency_id = '';
        accoutData.value.account_type_id = '';
        accoutData.value.user_id = '';
        successMessage.value = 'Акаунтът е създаден успешно!';
    } catch (err) {
        errors.value = JSON.parse(err.message).errors;
        successMessage.value = '';
    }
};

onMounted(async () => {
    currencies.value = (await getData('currencies'))
        .map(c => { return { id: c.id, text: c.currency }; });

    accountTypes.value = (await getData('account-types'))
        .map(at => { return { id: at.id, text: at.account_type }; });

    users.value = (await getData('clients'))
        .map(u => { return { id: u.id, text: `${u.name ?? '--'} ${u.last_name ?? '--'} ${u.email}` }; });
});
</script>

<template>
    <section class="section-create-account">
        <div class="section__inner">
            <h1 class="section__title">Добави акаунт</h1>

            <form @submit.prevent="storeAccount" class="base-form">
                <FormInput label="Номер на сметка" v-model="accoutData.account_number"
                    :error="errors?.account_number?.[0]" />

                <FormInput label="Наличност" v-model="accoutData.amount" :error="errors?.amount?.[0]" />

                <FormInput label="Лихва" v-model="accoutData.interest" :error="errors?.interest?.[0]" />

                <SelectComponent label="Валута" name="card-currencys" id="card-currencys" :options="currencies"
                    v-model="accoutData.currency_id" :error="errors?.currency_id?.[0]" />

                <SelectComponent label="Тип на сметка" name="card-types" id="card-types" :options="accountTypes"
                    v-model="accoutData.account_type_id" :error="errors?.account_type_id?.[0]" />

                <SelectComponent label="Потребител" name="card-users" id="card-users" :options="users"
                    v-model="accoutData.user_id" :error="errors?.user_id?.[0]" />

                <Button text="Добави" />

                <SuccessMessage v-if="successMessage" :text="successMessage" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-account {
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
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 400px;
        margin: 0 auto;
    }
}
</style>