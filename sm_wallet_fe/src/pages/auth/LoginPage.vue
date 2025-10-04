<script setup>
import FormInput from '@/components/FormInput.vue';
import Button from '@/components/Button.vue';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import ErrorParagraph from '@/components/ErrorParagraph.vue';

const router = useRouter();
const loginData = ref({
    email: '',
    password: '',
});

const errors = ref([]);
const invalidCredentials = ref('');

const logUser = async () => {
    const request = await fetch('http://127.0.0.1:8000/api/login', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(loginData.value)
    });

    if (request.ok) {

        const responseData = await request.json();
        localStorage.setItem('token', responseData.token);
        router.push('/home');
        errors.value = [];
        invalidCredentials.value = '';
    } else {
        const errorArr = await request.json();

        if (errorArr.errors) {
            errors.value = errorArr.errors;
            invalidCredentials.value = '';
        } else {
            invalidCredentials.value = errorArr.message;
            errors.value = [];
        }
    }
};
</script>

<template>
    <section class="section-login">
        <div class="section__inner shell">
            <h1 class="section__title">Вход</h1>

            <form @submit.prevent="logUser">
                <FormInput label="Имейл" v-model="loginData.email" :error="errors?.email?.[0]" />

                <FormInput label="Парола" input-type="password" v-model="loginData.password"
                    :error="errors?.password?.[0]" />

                <Button text="вход" />

                <ErrorParagraph v-if="invalidCredentials" :text="invalidCredentials" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-login {
    margin-block: 32px;

    .section__title {
        text-align: center;
    }
}
</style>