<script setup>
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { get } from '@/crud/get';
import { update } from '@/crud/update';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import SuccessMessage from '@/components/SuccessMessage.vue';

const currency = ref(null);
const router = useRoute();
const id = router.params.id;
const { getItem } = get();
const { updateData } = update();
const is_loading = ref(false);
const is_fetching = ref(false);
const error = ref('');
const success = ref(false);

const handleUpdate = async () => {
    const form_data = new FormData();
    try{
        is_fetching.value = true;
        form_data.append('currency', currency.value.currency);
        await updateData(form_data, 'currencies', id);
        error.value = '';
        success.value = true;

        setTimeout(() => {
            success.value = false;
        }, 3000);
    }catch(e){
        error.value = JSON.parse(e.message).errors.currency[0];
    }finally{
        is_fetching.value = false;
    }
};

onMounted(async () => {
    is_loading.value = true;
    currency.value =  await getItem('currencies', id);
    is_loading.value = false;
});
</script>

<template>
    <section class="section-update-currency">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/currencies" />

                <h1>Промени валута</h1>
            </div>

            <form @submit.prevent="handleUpdate" v-if="currency && !is_loading" class="section__currency base-form">
                <FormInput :error v-model="currency.currency" label="Валута" />

                <Button type="submit" text="Промени" />
            </form>

            <LoadingComponent v-else class="loading"/>

            <SuccessMessage :class="{'green-bg': true}" v-if="success" text="Успешно променена валута!" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-update-currency {
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;

            h1{
                color: var(--c-gray);
            }
    }

    .section__currency{
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 20%;
        align-self: center;
    }

    .loading{
        align-self: center;
    }
}
</style>