<script setup lang="ts">
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import { auth } from '@/crud/auth';
import { onBeforeMount, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const currentUser = ref();
const new_password = ref();
const repeat_new_password = ref();

const { getUser } = auth();
onBeforeMount(async () => {
    if (!localStorage.getItem('token')) {
        router.push('/login');
        return;
    }

    currentUser.value = await getUser();
});

const updateUser = async () => {
    console.log(currentUser?.value);
};

const deleteUser = async () => {

};
</script>

<template>
    <section class="section-profile">
        <div class="section__inner shell">
            <form class="base-form">
                <FormInput v-if="currentUser?.name" label="Име" v-model="currentUser.name" />
                <FormInput v-if="currentUser?.middle_name" label="Презиме" v-model="currentUser.middle_name" />
                <FormInput v-if="currentUser?.last_name" label="Фамилия" v-model="currentUser.last_name" />

                <FormInput v-if="currentUser?.email" label="Имейл" v-model="currentUser.email" />
            </form>

            <form class="base-form">
                <FormInput label="Стара парола" />
                <FormInput label="Нова парола" v-model="new_password" />
                <FormInput label="Повтори нова парола" v-model="repeat_new_password" />
            </form>
        </div>
        <div class="section__buttons shell">
            <Button @click.prevent="updateUser" text="Промени" :update_btn="true" />

            <Button @click.prevent="deleteUser" :delete_btn="true" text="Изтрий акаунта" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-profile {
    margin-top: 20px;

    .section__inner {
        display: flex;
        gap: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 50%;
        margin-bottom: 30px;
    }

    .section__buttons {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
}
</style>