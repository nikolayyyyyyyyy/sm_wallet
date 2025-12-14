<script setup>
import Button from '@/components/Button.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';

const transactions = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteTransaction = async (id) => {
    await deleteData(id, 'transactions');
    transactions.value = transactions.value.filter(t => t.id != id);
};

onMounted(async () => {
    transactions.value = await getData('transactions');
});
</script>

<template>
    <section class="section-transactions">
        <div class="section__inner shell">
            <div v-for="transaction in transactions" class="section__transaction base-form">
                <p>Размер на превод: {{ transaction.amount }}
                    <span class="section__curency">
                        {{ transaction.sender_account.currency.currency }}
                    </span>
                </p>

                <p>Бележка: {{ transaction.note }}</p>

                <p>Тип на транзакция: {{ transaction.transaction_type.transaction_type }}</p>

                <p>Номер на сметка на изпращача: {{ transaction.sender_account.account_number }}</p>

                <p>Номер на сметка на получателя: {{ transaction.receiver_account.account_number }}</p>

                <div class="section__buttons">
                    <Button text="Промени" />

                    <Button text="изтрий" :delete_btn="true" @click="deleteTransaction(transaction.id)" />
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-transactions {
    margin-block: 32px;

    .section__inner {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section__transaction {
        flex: 0 0 calc((100% - 40px) / 3);
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        gap: 24px;
        color: var(--c-gray);
    }

    .section__curency {
        color: var(--c-green);
        font-weight: 500;
    }

    .section__buttons {
        display: flex;
        gap: 20px;
    }
}
</style>