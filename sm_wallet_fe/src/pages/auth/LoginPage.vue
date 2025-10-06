<script setup>
import FormInput from '@/components/FormInput.vue';
import Button from '@/components/Button.vue';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import FormErrorMessage from '@/components/FormErrorMessage.vue';
import { auth } from '@/crud/auth';

const router = useRouter();
const loginData = ref({
    email: '',
    password: '',
});

const errors = ref([]);
const invalidCredentials = ref('');
const { loginUser } = auth();

const handleLogin = async () => {
    try {
        await loginUser(loginData.value, 'login');
        invalidCredentials.value = '';
        errors.value = [];
        router.push('/');
    } catch (err) {
        if (JSON.parse(err.message).errors) {
            invalidCredentials.value = '';
            errors.value = JSON.parse(err.message).errors;
        } else {
            errors.value = [];
            invalidCredentials.value = JSON.parse(err.message).message;
        }
    }
};
</script>

<template>
    <section class="section-login">
        <div class="section__inner shell">
            <h1 class="section__title">FinTech</h1>
            <p class="subtitle">вход в системата</p>

            <form @submit.prevent="handleLogin">
                <FormInput label="Имейл" v-model="loginData.email" :error="errors?.email?.[0]" />

                <FormInput label="Парола" input-type="password" v-model="loginData.password"
                    :error="errors?.password?.[0]" />

                <Button text="вход" />

                <FormErrorMessage v-if="invalidCredentials" :text="invalidCredentials" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-login {
    margin-block: 32px;
}
</style>