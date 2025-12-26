<script setup>
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import SelectComponent from '@/components/SelectComponent.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
import TextareaFormInput from '@/components/TextareaFormInput.vue';
import { get } from '@/crud/get';
import { update } from '@/crud/update';
import { onMounted, ref } from 'vue';
const props = defineProps({
    id:{
        type: String,
        required: true
    }
});

const { getItem, getData } = get();
const { updateData } = update();
const transaction = ref();
const is_loading = ref(false);
const transaction_types = ref();
const is_fetching = ref();
const success_message = ref();
const errors = ref();

const updateTransaction = async () => {
    if(is_fetching.value) return;
    
    const form_data = new FormData();
    form_data.append("id", transaction.value.id);
    form_data.append("amount", transaction.value.amount);
    form_data.append("note", transaction.value.note);
    form_data.append("sender_account_number", transaction.value.sender_account.account_number);
    form_data.append("receiver_account_number", transaction.value.receiver_account.account_number);
    form_data.append("transaction_type_id", transaction.value.transaction_type_id);

    try{
        is_fetching.value = true;
        await updateData(form_data, 'transactions', props.id);
        success_message.value = true;
        errors.value = [];

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        errors.value = JSON.parse(err.message).errors;
        console.log(errors.value);
        
    }finally{
        is_fetching.value = false;
    }
};

onMounted(async () => {
    is_loading.value = true;
    transaction.value = await getItem('transactions', props.id);
    is_loading.value = false;

    transaction_types.value = (await getData('transaction-types'))
        .map(t => { return { id: t.id, text: t.transaction_type }; });
});
</script>

<template>
    <section class="section-update-transaction">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/transactions" />

                <h1>Промени транзакция</h1>
            </div>

            <form @submit.prevent="updateTransaction" v-if="!is_loading && transaction && transaction_types" class="section__content base-form">
                <FormInput label="Сума" v-model="transaction.amount" :error="errors?.amount?.[0]"/>
                
                <div class="content__users">
                    <FormInput label="Изпращач" v-model="transaction.sender_account.account_number" :error="errors?.sender_account_number?.[0]" />

                    <FormInput label="Получател" v-model="transaction.receiver_account.account_number" :error="errors?.receiver_account_number?.[0]"/>
                </div>

                <TextareaFormInput label="Бележка" v-model="transaction.note" :error="errors?.note?.[0]"/>

                <SelectComponent label="Тип на транзакцията"
                    :options="transaction_types"
                    id="transaction-select" 
                    name="transaction-select"
                    v-model="transaction.transaction_type_id" />

                <Button type="submit" text="Промени" class="update_btn" />
            </form>

            <LoadingComponent v-else class="loading" />

            <SuccessMessage v-if="success_message" text="Успешно променена транзакция." :class="{'green-bg': true}" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-update-transaction{
    margin-block: 32px;

    .update_btn{
        width: 50%;
    }

    .loading{
        align-self: center;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-white);
    }

    .section__content{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 50%;
        align-self: center;
    }

    .content__users{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
}
</style>