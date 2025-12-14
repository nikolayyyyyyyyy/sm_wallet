<script setup>
import Button from '@/components/Button.vue';
import FormErrorMessage from '@/components/FormErrorMessage.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const transactions = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteTransaction = async (id) => {
    await deleteData(id, 'transactions');
    transactions.value = transactions.value.filter(t => t.id != id);
};

const is_loading = ref(false);
onMounted(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }

    is_loading.value = true;
    transactions.value = await getData('transactions');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-transactions">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/" />

                <h1>Tранзакций</h1>
            </div>

            <div v-if="is_loading == false && transactions" class="section__transactions">
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

            <LoadingComponent class="loading" v-if="is_loading" />

            <FormErrorMessage v-else text="Няма намерени транзакций" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-transactions {
    margin-block: 32px;

    .loading {
        align-self: center;
    }

    .section__title {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
    }

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__transactions {
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