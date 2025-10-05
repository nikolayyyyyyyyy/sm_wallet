<script setup lang="ts">
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import { auth } from '@/crud/auth';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const errors = ref(null);
const registerUser = ref({
    name: '',
    middle_name: '',
    last_name: '',
    email: '',
    password: ''
});
const { authenticate } = auth();

const handleRegister = async () => {
    try {
        await authenticate(registerUser.value, 'register')
        router.push('/login');
    } catch (err) {
        errors.value = JSON.parse(err.message).errors;
    }
};
</script>

<template>
    <section class="section-register">
        <div class="section__inner shell">
            <h1 class="section__title">Регистрация</h1>

            <form @submit.prevent="handleRegister">
                <FormInput label="Име" v-model="registerUser.name" :error="errors?.name?.[0]" />

                <FormInput label="Презиме" v-model="registerUser.middle_name" :is-optional="true"
                    :error="errors?.middle_name?.[0]" />

                <FormInput label=" Фамилия" v-model="registerUser.last_name" :is-optional="true"
                    :error="errors?.last_name?.[0]" />

                <FormInput label=" Имейл" v-model="registerUser.email" :error="errors?.email?.[0]" />

                <FormInput label="Парола" v-model="registerUser.password" :error="errors?.password?.[0]" />

                <Button text="Продължи" />
            </form>
        </div>
    </section>
</template>


<style scoped lang="scss">
.section-register {
    margin-block: 32px;

    .section__title {
        text-align: center;
    }
}
</style>