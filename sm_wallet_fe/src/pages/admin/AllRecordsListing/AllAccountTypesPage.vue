<script setup>
import Button from '@/components/Button.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';

const account_types = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteAccountType = async (id) => {
    await deleteData(id, 'account-types');
    account_types.value = account_types.value.filter(a => a.id !== id);
};

onMounted(async () => {
    account_types.value = await getData('account-types');
    console.log(account_types.value);
});
</script>

<template>
    <section class="section-account-types">
        <div v-for="account_type in account_types" class="section__account__type base-form">
            <p class="section__title">Тип на акаунт: {{ account_type.account_type }}</p>

            <div class="section__buttons">
                <Button text="Промени" :update_btn="true" />

                <Button text="Изтрий" @click.prevent="deleteAccountType(account_type.id)" :delete_btn="true" />
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-account-types {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-top: 50px;

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