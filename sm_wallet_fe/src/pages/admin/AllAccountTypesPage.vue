<script setup>
import Button from '@/components/Button.vue';
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

onMounted(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }
    account_types.value = await getData('account-types');
    console.log(account_types.value);
});
</script>

<template>
    <section class="section-account-types">
        <div class="section__inner shell">
            <div v-for="account_type in account_types" class="section__account__type base-form">
                <p class="section__title">Тип на акаунт: {{ account_type.account_type }}</p>

                <div class="section__buttons">
                    <Button text="Промени" />

                    <Button text="Изтрий" @click.prevent="deleteAccountType(account_type.id)" :delete_btn="true" />
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