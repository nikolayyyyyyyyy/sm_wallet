<script setup>
import Button from '@/components/Button.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';

const accounts = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteAccount = async (id) => {
    await deleteData(id, 'accounts');
    accounts.value = accounts.value.filter(a => a.id != id);
};

onMounted(async () => {
    accounts.value = await getData('accounts');
});
</script>

<template>
    <section class="section-accounts">
        <div v-for="account in accounts" class="section__account base-form">
            <p>Номер на сметката: {{ account.account_number }}</p>

            <p>Наличност: {{ account.amount }} <span class="account__currency">
                    {{ account.currency.currency }}</span>
            </p>

            <p>Лихва: {{ account.interest }} <span class="account__currency">{{ account.currency.currency }}</span></p>

            <p>Тип на сметката: {{ account.card_type.account_type }}</p>

            <p>Имейл на притежателя: {{ account.user.email }}</p>

            <div class="section__buttons">
                <Button text="Промени" />

                <Button text="Изтрий" :delete_btn="true" @click="deleteAccount(account.id)" />
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-accounts {
    margin-block: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;

    .section__account {
        display: flex;
        flex-direction: column;
        gap: 24px;
        color: var(--c-gray);
        width: 400px;
    }

    p {
        font-size: 18px;
        font-weight: 500;
    }

    .account__currency {
        color: var(--c-green);
        font-weight: 600;
    }

    .section__buttons {
        display: flex;
        gap: 20px;
    }
}
</style>