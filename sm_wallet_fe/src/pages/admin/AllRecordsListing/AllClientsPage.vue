<script setup>
import Button from '@/components/Button.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';

const clients = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteClient = async (id) => {
    await deleteData(id, 'clients');
    clients.value = clients.value.filter(c => c.id !== id);
};

onMounted(async () => {
    clients.value = await getData('clients');
});
</script>

<template>
    <section class="section-clients">
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
    </section>
</template>

<style scoped lang="scss">
.section-clients {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    margin-block: 32px;

    .section__client {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 400px;
        color: var(--c-gray);
        font-size: 20px;
        font-weight: 500;
    }

    .section__buttons {
        display: flex;
        gap: 20px;
    }
}
</style>