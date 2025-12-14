<script setup>
import Button from '@/components/Button.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const transaction_types = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteTransactionType = async (id) => {
    await deleteData(id, 'transaction-types');
    transaction_types.value = transaction_types.value.filter(t => t.id !== id);
};

onMounted(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }
    transaction_types.value = await getData('transaction-types');
});
</script>

<template>
    <section class="section-account-types">
        <div class="section__inner shell">
            <div v-for="transaction_type in transaction_types" class="section__account__type base-form">
                <p class="section__title">
                    Тип на транзакция: {{ transaction_type.transaction_type }}
                </p>

                <div class="section__buttons">
                    <Button text="Промени" />

                    <Button text="Изтрий" :delete_btn="true"
                        @click.prevent="deleteTransactionType(transaction_type.id)" />
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-account-types {
    margin-block: 32px;

    .section__inner {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section__account__type {
        display: flex;
        flex-direction: column;
        gap: 24px;
        flex: 0 0 calc((100% - 40px) / 3);
        box-sizing: border-box;
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