<script setup lang="ts">
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import { auth } from '@/crud/auth';
import { del } from '@/crud/delete';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const currentUser = ref();
const new_password = ref();

const { getCurrentUser } = auth();
currentUser.value = getCurrentUser();

const { deleteData } = del();
const updateUser = async () => {
    console.log(currentUser?.value);
};

const deleteUser = async (id) => {
    await deleteData(id, 'clients');
    window.location.reload();
};

onMounted(() => {
    if (!localStorage.getItem('token')) {
        router.push('/login');
    }
});
</script>

<template>
    <section class="section-profile">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" :reversed="true" />

                <h1>Моят Профил</h1>
            </div>

            <form class="base-form">
                <FormInput label="име" v-model="currentUser.name" />
                <FormInput label="презиме" v-model="currentUser.middle_name" />
                <FormInput label="фамилия" v-model="currentUser.last_name" />

                <FormInput v-if="currentUser?.email" label="Имейл" v-model="currentUser.email" />
                <FormInput label="Нова парола" v-model="new_password" />

                <div class="section__buttons">
                    <Button @click.prevent="updateUser" text="Промени" />

                    <Button @click.prevent="deleteUser(currentUser.id)" :delete_btn="true" text="Изтрий акаунта" />
                </div>
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-profile {
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
        gap: 8px;
        width: 50%;
        align-self: center;

        .section__buttons {
            display: flex;
            gap: 14px;
        }
    }
}
</style>