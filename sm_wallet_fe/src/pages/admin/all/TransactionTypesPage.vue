<script setup>
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
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

const is_loading = ref(false);
onMounted(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }
    is_loading.value = true;
    transaction_types.value = await getData('transaction-types');
    transaction_types.value = [];
    is_loading.value = false;
});
</script>

<template>
    <section class="section-account-types">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/" />

                <h1>Видове транзакции</h1>
            </div>

            <div v-if="!is_loading && transaction_types.length > 0" class="section__transaction__types">
                <div v-for="transaction_type in transaction_types" class="section__account__type base-form">
                    <p class="section__account-title">
                        Тип на транзакция: {{ transaction_type.transaction_type }}
                    </p>

                    <div class="section__buttons">
                        <RouterLink class="update_btn" :to="{ name: 'transaction-types.update', params: { id: transaction_type.id }}">
                            <Button text="Промени" />
                        </RouterLink>

                        <Button text="Изтрий" :delete_btn="true"
                            @click.prevent="deleteTransactionType(transaction_type.id)" />
                    </div>
                </div>
            </div>

            <p class="err_message" v-if="!is_loading && transaction_types.length == 0">Няма добавени типове транзакции.</p>

            <LoadingComponent class="loading" v-if="is_loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-account-types {
    margin-block: 32px;

    .loading {
        align-self: center;
    }

    .update_btn{
        width: 100%;
    }

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        color: var(--c-gray);
    }

    .section__transaction__types {
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

    .section__account-title {
        font-size: 20px;
        font-weight: 500;
        color: var(--c-gray);
    }

    .section__buttons {
        margin-top: auto;
        display: flex;
        gap: 20px;
    }
}
</style>