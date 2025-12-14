<script setup lang="ts">
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import SelectComponent from '@/components/SelectComponent.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
import { store } from '@/crud/create';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();

const clientData = ref({
    name: '',
    middle_name: '',
    last_name: '',
    email: '',
    password: '',
    role_id: ''
});
const errors = ref(null);
const { create } = store();
const successMessage = ref('');

const storeClient = async () => {
    try {
        await create(clientData.value, 'clients');
        errors.value = [];
        Object.keys(clientData.value).forEach(k => clientData.value[k] = '');
        successMessage.value = 'Клиентът е създаден успешно!'
    } catch (err) {
        errors.value = JSON.parse(err.message).errors;
        successMessage.value = '';
    }
};

onMounted(() => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }
});
</script>

<template>
    <section class="section-create-client">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" :reversed="true" />

                <h1>Добави Клиент</h1>
            </div>

            <form @submit.prevent="storeClient" class="base-form">
                <div class="form-names">
                    <FormInput label="Име" v-model="clientData.name" :error="errors?.name?.[0]" />

                    <FormInput label="Презиме" v-model="clientData.middle_name" :error="errors?.middle_name?.[0]" />

                    <FormInput label="Фамилия" v-model="clientData.last_name" :error="errors?.last_name?.[0]" />
                </div>

                <FormInput label="Имейл" v-model="clientData.email" :error="errors?.email?.[0]" />

                <SelectComponent v-model="clientData.role_id" :error="errors?.role_id?.[0]" name="select-role"
                    id="select-role" label="Права"
                    :options="[{ id: 1, text: 'Амин' }, { id: 2, text: 'Потребител' }]" />

                <FormInput label="Парола" v-model="clientData.password" :error="errors?.password?.[0]" />

                <Button text="Добави" />

                <SuccessMessage v-if="successMessage" :text="successMessage" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-client {
    margin-block: 32px;

    .section__title {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
    }

    .form-names {
        display: flex;
        gap: 24px;
    }

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-self: center;
    }
}
</style>