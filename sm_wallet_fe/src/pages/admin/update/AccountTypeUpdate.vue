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
const account_type = ref({});
const is_loading = ref(false);
const success = ref(false);
const error = ref('');

const handleUpdate = async () => {
    const form_data = new FormData();
    form_data.append('account_type', account_type.value.account_type);

    try{
        await updateData(form_data, 'account-types', route.params.id);
        success.value = true;
        error.value = '';
        
        setTimeout(() => {
            success.value = false;
        }, 3000);

    }catch(err){
        error.value = JSON.parse(err.message).errors.account_type[0];
    }
}

onMounted(async () => {
    is_loading.value = true;
    account_type.value = await getItem('account-types', route.params.id);
    is_loading.value = false;
});
</script>

<template>
    <section class="section-update-account-type">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/account-types" :reversed="true" />

                <h1>Редактирай тип на сметка</h1>
            </div>

            <form @submit.prevent="handleUpdate" v-if="!is_loading" class="section__content base-form">
                <FormInput :error label="Тип на сметка" v-model="account_type.account_type" />

                <Button type="submit" text="Промени" />
            </form>

            <LoadingComponent v-else class="loading" />

            <SuccessMessage v-if="success" text="Типът на сметката е обновен успешно." :class="{'green-bg': true}"/>
        </div>
    </section>    
</template>

<style scoped lang="scss">
.section-update-account-type{
    margin-block: 32px;

    .loading{
        align-self: center;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__content{
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-self: center;
        width: 30%;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
    }
}
</style>