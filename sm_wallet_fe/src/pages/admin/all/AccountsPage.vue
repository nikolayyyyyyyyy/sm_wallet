<script setup>
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onBeforeMount, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();

const accounts = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteAccount = async (id) => {
    await deleteData(id, 'accounts');
    accounts.value = accounts.value.filter(a => a.id != id);
};

const is_loading = ref(false);
onBeforeMount(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }

    is_loading.value = true;
    accounts.value = await getData('accounts');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-accounts">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/" />

                <h1>Сметки</h1>
            </div>

            <div v-if="is_loading == false" class="section__accounts">
                <div v-for="account in accounts" class="section__account base-form">
                    <p>Номер на сметката: {{ account.account_number }}</p>

                    <p>Наличност: {{ account.amount }} <span class="account__currency">
                            {{ account.currency.currency }}</span>
                    </p>

                    <p>Лихва: {{ account.interest }} <span class="account__currency">{{ account.currency.currency
                    }}</span>
                    </p>

                    <p>Тип на сметката: {{ account.card_type.account_type }}</p>

                    <p>Имейл на притежателя: {{ account.user.email }}</p>

                    <div class="section__buttons">
                        <Button text="Промени" />

                        <Button text="Изтрий" :delete_btn="true" @click="deleteAccount(account.id)" />
                    </div>
                </div>
            </div>

            <LoadingComponent class="loading" v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-accounts {
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

    .section__accounts {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section__account {
        display: flex;
        flex-direction: column;
        gap: 24px;
        color: var(--c-gray);
        flex: 0 0 calc((100% - 40px) / 3);
        box-sizing: border-box;
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