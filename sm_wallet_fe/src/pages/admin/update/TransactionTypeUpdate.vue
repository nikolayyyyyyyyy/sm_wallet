<script setup>
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
import { get } from '@/crud/get';
import { update } from '@/crud/update';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const { updateData } = update();
const { getItem } = get();
const route = useRoute();
const transaction_type = ref({});
const is_loading = ref(false);
const success = ref(false);
const error = ref('');

const handleUpdate = async () => {
    const form_data = new FormData();
    form_data.append('transaction_type', transaction_type.value.transaction_type);

    try{
        await updateData(form_data, 'transaction-types', route.params.id);
        success.value = true;
        error.value = '';

        setTimeout(() => {
            success.value = false;
        }, 3000);

    }catch(err){
        error.value = JSON.parse(err.message).errors.transaction_type[0];
    }
}

onMounted(async () => {
    is_loading.value = true;
    transaction_type.value = await getItem('transaction-types', route.params.id);
    is_loading.value = false;
});
</script>

<template>
    <section class="section-update-transaction-type">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/transaction-types" :reversed="true" />

                <h1>Редактирай вид транзакция</h1>
            </div>

            <form @submit.prevent="handleUpdate" v-if="!is_loading" class="section__content base-form">
                <FormInput :error label="Вид транзакция" v-model="transaction_type.transaction_type" />

                <Button type="submit" text="Промени" />
            </form>

            <LoadingComponent v-else class="loading" />

            <SuccessMessage v-if="success" text="Видът на транзакцията е обновен успешно." :class="{'green-bg': true}"/>
        </div>
    </section>    
</template>

<style scoped lang="scss">
.section-update-transaction-type{
    margin-block: 32px;
    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .loading{
        align-self: center;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
    }

    .section__content{
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 40%;
        align-self: center;
    }
}
</style>