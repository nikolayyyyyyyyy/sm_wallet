<script setup>
import { onMounted, ref } from 'vue';
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import { store } from '@/crud/create';
import SuccesMessage from '@/components/SuccessMessage.vue';
import { useRouter } from 'vue-router';
import GoToArrow from '@/components/GoToArrow.vue';
const router = useRouter();

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

onMounted(() => {
    if (!localStorage.getItem('token')) {
        router.push('/login');
    }
});
</script>

<template>
    <section class="section-create-account-type">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" :reversed="true" />

                <h1>Добави Тип Акаунт</h1>
            </div>

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

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
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