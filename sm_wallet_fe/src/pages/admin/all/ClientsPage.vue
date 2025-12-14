<script setup>
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import SearchFieldSection from '@/sections/SearchFieldSection.vue';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();

const clients = ref([]);
const { getData } = get();
const { deleteData } = del();
const is_loading = ref(false);

const deleteClient = async (id) => {
    await deleteData(id, 'clients');
    clients.value = clients.value.filter(c => c.id !== id);
};

onMounted(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }
    is_loading.value = true;
    clients.value = await getData('clients');
    is_loading.value = false;
});

</script>

<template>
    <section class="section-clients">
        <div class="section__shell shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/" />

                <h1>Клиенти</h1>
            </div>

            <SearchFieldSection>
                <div class="section__search__name">
                    <p>Име:</p>
                    <FormInput />
                </div>

                <div class="section__search__name">
                    <p>Презиме:</p>
                    <FormInput />
                </div>

                <div class="section__search__name">
                    <p>Фамилия:</p>
                    <FormInput />
                </div>

                <div class="section__search__name">
                    <p>Имейл:</p>
                    <FormInput />
                </div>

                <div class="section__search__name">
                    <p>Роля:</p>
                    <FormInput />
                </div>
            </SearchFieldSection>

            <div v-if="is_loading == false" class="section__clients">
                <div v-for="client in clients" class="section__client base-form">
                    <p>Име: {{ client.name }}</p>
                    <p>Презиме: {{ client.middle_name ? client.middle_name : 'Не е въведено' }}</p>
                    <p>Фамилия: {{ client.last_name ? client.last_name : 'Не е въведено' }}</p>
                    <p>Имейл: {{ client.email }}</p>
                    <p>Роля: {{ client.role.role_name }}</p>

                    <div class="section__buttons">
                        <Button text="Промени" />

                        <Button text=" Изтрий" :delete_btn="true" @click.prevent="deleteClient(client.id)" />
                    </div>
                </div>
            </div>

            <LoadingComponent v-else class="loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-clients {
    margin-block: 32px;

    .loading {
        align-self: center;
    }

    .section__search__name {
        color: var(--c-white);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section__shell {
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

    .section__clients {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section__client {
        display: flex;
        flex-direction: column;
        gap: 24px;
        flex: 0 0 calc((100% - 40px) / 3);
        box-sizing: border-box;
        color: var(--c-gray);
        font-size: 20px;
        font-weight: 500;
    }

    .section__buttons {
        margin-top: auto;
        display: flex;
        gap: 20px;
    }
}
</style>