<script setup lang="ts">
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import { auth } from '@/crud/auth';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const errors = ref(null);
const registerData = ref({
    name: '',
    middle_name: '',
    last_name: '',
    email: '',
    password: ''
});
const { registerUser } = auth();

const handleRegister = async () => {
    try {
        await registerUser(registerData.value)
        router.push('/login');
    } catch (err) {
        errors.value = JSON.parse(err.message).errors;
    }
};
</script>

<template>
    <section class="section-register">
        <div class="section__inner shell">
            <h1 class="section__title">FinTech</h1>
            <p class="subtitle">регистрирай се в системата</p>

            <form class="base-form form-register" @submit.prevent="handleRegister">
                <FormInput label="Име" v-model="registerData.name" :error="errors?.name?.[0]" />

                <FormInput label="Презиме" v-model="registerData.middle_name" :optional="false"
                    :error="errors?.middle_name?.[0]" />

                <FormInput label=" Фамилия" v-model="registerData.last_name" :optional="false"
                    :error="errors?.last_name?.[0]" />

                <FormInput label=" Имейл" v-model="registerData.email" :error="errors?.email?.[0]"
                    :is-for-email="true" />

                <FormInput input-type="password" label="Парола" v-model="registerData.password"
                    :error="errors?.password?.[0]" :is-for-password="true" />

                <Button text="Продължи" />

                <div class="form-bottom">
                    <p class="text">Имаш акаунт?</p>
                    <a @click.prevent="router.push('/login')" class="text-colored">Sing up</a>
                </div>
            </form>
        </div>
    </section>
</template>


<style scoped lang="scss">
.section-register {
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

    .form-register {
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