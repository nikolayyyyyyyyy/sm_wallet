<script setup>
import Button from '@/components/Button.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onBeforeMount, ref } from 'vue';

const currencies = ref([]);
const { getData } = get();
const { deleteData } = del();

const deleteCurrency = async (id) => {
    await deleteData(id, 'currencies');
    currencies.value = currencies.value.filter(c => c.id != id);
};

onBeforeMount(async () => {
    currencies.value = await getData('currencies');
});
</script>
<template>
    <section class="section-currencies">
        <div class="section__inner">
            <div class="section__currency" v-for="currency in currencies">
                <div class="section__content">
                    <p class="currency__title">Валута:</p>
                    <p class="currency__name">{{ currency.currency }}</p>
                </div>

                <div class="section__buttons">
                    <Button :delete_btn="true" text="Изтрий" @click.prevent="deleteCurrency(currency.id)" />
                    <Button :update_btn="true" text="Промени" />
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-currencies {
    margin-top: 50px;

    .section__inner {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 50px;
    }

    .section__currency {
        display: flex;
        flex-direction: column;
        gap: 24px;
        background-color: var(--c-grayed);
        padding: 20px;
        width: 400px;
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