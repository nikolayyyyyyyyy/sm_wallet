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

            <div class="section__content">
                <div class="section__iamge-upload">
                    <figure class="section__image image-fit">
                        <img src="../../../public/456799695_842499038025303_7209467520786118063_n.jpg" />
                    </figure>


                    <label for="file-upload" class="file__upload">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3 6C3 4.34315 4.34315 3 6 3H14C15.6569 3 17 4.34315 17 6V14C17 15.6569 15.6569 17 14 17H6C4.34315 17 3 15.6569 3 14V6Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21 7V18C21 19.6569 19.6569 21 18 21H7" stroke="#000000" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M3 12.375L6.66789 8.70711C7.05842 8.31658 7.69158 8.31658 8.08211 8.70711L10.875 11.5M10.875 11.5L13.2304 9.1446C13.6209 8.75408 14.2541 8.75408 14.6446 9.14461L17 11.5M10.875 11.5L12.8438 13.4688"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </label>

                    <input type="file" id="file-upload" hidden />
                </div>

                <form class="base-form">
                    <FormInput label="име" v-model="currentUser.name" />
                    <FormInput label="презиме" v-model="currentUser.middle_name" />
                    <FormInput label="фамилия" v-model="currentUser.last_name" />

                    <FormInput v-if="currentUser?.email" label="Имейл" v-model="currentUser.email" />
                    <FormInput label="Нова парола" v-model="new_password" />

                    <div class="section__buttons">
                        <Button @click.prevent="updateUser" text="Промени" />

                        <Button @click.prevent="deleteUser(currentUser.id)" :delete_btn="true" text="Изтрий" />
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-profile {
    margin-block: 32px;

    .file__upload {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid var(--c-gray);
        background-color: var(--c-base);
        width: 50%;
        cursor: pointer;
    }

    .section__iamge-upload {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        width: 30%;
    }

    .section__content {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .section__image {
        border-radius: 20px;
        border: 2px solid var(--c-gray);
        width: 200px;
        aspect-ratio: 1/1;
    }

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
        width: 40%;

        .section__buttons {
            display: flex;
            gap: 14px;
        }
    }
}
</style>