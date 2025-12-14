<script setup>
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onBeforeMount, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();

const currencies = ref([]);
const { getData } = get();
const { deleteData } = del();
const is_loading = ref(false);

const deleteCurrency = async (id) => {
    await deleteData(id, 'currencies');
    currencies.value = currencies.value.filter(c => c.id != id);
};

onBeforeMount(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }
    is_loading.value = true;
    currencies.value = await getData('currencies');
    is_loading.value = false;
});
</script>
<template>
    <section class="section-currencies">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" :reversed="true" />

                <h1>Валути</h1>
            </div>

            <div v-if="is_loading == false" class="section__currencies">
                <div class="section__currency" v-for="currency in currencies">
                    <div class="section__content">
                        <p class="currency__title">Валута:</p>
                        <p class="currency__name">{{ currency.currency }}</p>
                    </div>

                    <div class="section__buttons">
                        <Button :delete_btn="true" text="Изтрий" @click.prevent="deleteCurrency(currency.id)" />
                        <Button text="Промени" />
                    </div>
                </div>
            </div>

            <LoadingComponent v-else class="loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-currencies {
    margin-block: 32px;

    .loading {
        align-self: center;
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

    .section__currencies {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section__currency {
        display: flex;
        flex-direction: column;
        gap: 24px;
        background-color: var(--c-grayed);
        padding: 20px;
        flex: 0 0 calc((100% - 40px) / 3);
        box-sizing: border-box;
        border-radius: 15px;
        color: var(--c-gray);
    }

    .currency__title {
        font-size: 20px;
        font-weight: 500;
    }

    .section__content {
        display: flex;
        align-items: end;
        gap: 10px;
    }

    .section__buttons {
        display: flex;
        gap: 20px;
    }
}
</style>