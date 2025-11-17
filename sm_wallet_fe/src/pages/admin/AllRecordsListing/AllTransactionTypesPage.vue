<script setup>
import Button from '@/components/Button.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';

const transaction_types = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteTransactionType = async (id) => {
    await deleteData(id, 'transaction-types');
    transaction_types.value = transaction_types.value.filter(t => t.id !== id);
};

onMounted(async () => {
    transaction_types.value = await getData('transaction-types');
});
</script>

<template>
    <section class="section-account-types">
        <div v-for="transaction_type in transaction_types" class="section__account__type base-form">
            <p class="section__title">
                Тип на транзакция: {{ transaction_type.transaction_type }}
            </p>

            <div class="section__buttons">
                <Button text="Промени" :update_btn="true" />

                <Button text="Изтрий" :delete_btn="true" @click.prevent="deleteTransactionType(transaction_type.id)" />
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-account-types {
    margin-top: 50px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;

    .section__account__type {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 400px;
    }

    .section__title {
        font-size: 20px;
        font-weight: 500;
        color: var(--c-gray);
    }

    .section__buttons {
        display: flex;
        gap: 20px;
    }
}
</style>