<script setup>
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const account_types = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteAccountType = async (id) => {
    await deleteData(id, 'account-types');
    account_types.value = account_types.value.filter(a => a.id !== id);
};

const is_loading = ref(false);
onMounted(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }

    is_loading.value = true;
    account_types.value = await getData('account-types');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-account-types">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" :reversed="true" />

                <h1>Видове сметки</h1>
            </div>

            <div v-if="is_loading == false" class="section__account__types">
                <div v-for="account_type in account_types" class="section__account__type base-form">
                    <p class="section__title--account">Тип на сметка: {{ account_type.account_type }}</p>

                    <div class="section__buttons">
                        <RouterLink class="update_link" :to="{ name: 'account-types.update', params: { id: account_type.id }}">
                            <Button text="Промени" />
                        </RouterLink>

                        <Button text="Изтрий" @click.prevent="deleteAccountType(account_type.id)" :delete_btn="true" />
                    </div>
                </div>
            </div>

            <LoadingComponent class="loading" v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-account-types {
    margin-block: 32px;

    .loading {
        align-self: center;
    }

    .update_link{
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
        align-items: center;
        color: var(--c-gray);
    }

    .section__account__types {
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

    .section__title--account {
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