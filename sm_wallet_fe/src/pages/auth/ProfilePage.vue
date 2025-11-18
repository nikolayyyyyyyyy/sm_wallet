<script setup lang="ts">
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import { auth } from '@/crud/auth';
import { del } from '@/crud/delete';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const currentUser = ref();
const new_password = ref();
const repeat_new_password = ref();

const { getCurrentUser, isLogged } = auth();
currentUser.value = getCurrentUser();

if (!isLogged()) {
    router.push('/login');
}

const { deleteData } = del();
const updateUser = async () => {
    console.log(currentUser?.value);
};

const deleteUser = async (id) => {
    await deleteData(id, 'clients');
};
</script>

<template>
    <section class="section-profile">
        <div class="section__inner">
            <form class="base-form">
                <FormInput v-model="currentUser.name" />
                <FormInput v-model="currentUser.middle_name" />
                <FormInput v-model="currentUser.last_name" />

                <FormInput v-if="currentUser?.email" label="Имейл" v-model="currentUser.email" />
            </form>

            <form class="base-form">
                <FormInput label="Стара парола" />
                <FormInput label="Нова парола" v-model="new_password" />
            </form>
        </div>
        <div class="section__buttons">
            <Button @click.prevent="updateUser" text="Промени" />

            <Button @click.prevent="deleteUser(currentUser.id)" :delete_btn="true" text="Изтрий акаунта" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-profile {
    margin: 50px 200px;

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

        button {
            width: 50%;
        }
    }
}
</style>