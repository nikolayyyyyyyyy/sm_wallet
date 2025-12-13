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

            <form class="base-form login-form" @submit.prevent="handleLogin">
                <FormInput label="Имейл" v-model="loginData.email" :error="errors?.email?.[0]" :is-for-email="true" />

                <FormInput label="Парола" input-type="password" v-model="loginData.password"
                    :error="errors?.password?.[0]" :is-for-password="true" />

                <Button text="вход" />

                <FormErrorMessage v-if="invalidCredentials" :text="invalidCredentials" />

                <div class="form-bottom">
                    <p class="text">Нямаш акаунт?</p>
                    <a @click.prevent="router.push('/register')" class="text-colored">Register</a>
                </div>
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-login {
    margin-block: 32px;

    .section__title,
    .subtitle {
        text-align: center;
        color: var(--c-white);
    }

    .subtitle {
        font-size: 12px;
        font-weight: 200;
    }

    .login-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 35%;
        margin: 30px auto;
    }

    .form-bottom {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 11.9px;
        font-weight: 400;
        gap: 3px;

        .text {
            color: #94A3B8;
        }

        .text-colored {
            color: #818CF8;
        }

        .text-colored:hover {
            cursor: pointer;
        }
    }
}
</style>