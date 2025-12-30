<script setup>
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import SelectComponent from '@/components/SelectComponent.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
import { get } from '@/crud/get';
import { update } from '@/crud/update';
import { onMounted, ref } from 'vue';
const props = defineProps({
    id:{
        type: String,
        required: true
    }
});

const account = ref();
const currencies = ref();
const account_types = ref();
const users = ref();
const errors = ref();
const is_loading = ref(false);
const is_fetching = ref(false);
const success_message = ref(false);

const { getItem , getData } = get();
const { updateData } = update();

const updateAccount = async () => {
    if(is_fetching.value) return;

    const form_data = new FormData();
    form_data.append("account_number", account.value.account_number);
    form_data.append("amount", account.value.amount);
    form_data.append("interest", account.value.interest);
    form_data.append("currency_id", account.value.currency_id);
    form_data.append("account_type_id", account.value.account_type_id);
    form_data.append("user_id", account.value.user_id);

    try{
        is_fetching.value = true;
        await updateData(form_data, 'accounts', props.id);
        errors.value = [];
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        errors.value = JSON.parse(err.message).errors;
    }finally{
        is_fetching.value = false
    }
};

onMounted(async () => {
    is_loading.value = true;
    account.value = await getItem('accounts', props.id);

    currencies.value = (await getData('currencies'))
        .map(c => { return { id: c.id, text: c.currency }; });

    account_types.value = (await getData('account-types'))
        .map(at => { return { id: at.id, text: at.account_type }; });

    users.value = (await getData('clients'))
        .map(u => { return { id: u.id, text: `${u.name ?? '--'} ${u.last_name ?? '--'} ${u.email}` }; });
    is_loading.value = false;
});
</script>

<template>
    <section class="section-account-update">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/accounts" />

                <h1>Редактирай сметка</h1>
            </div>

            <form @submit.prevent="updateAccount" v-if="!is_loading && account" class="section__account base-form">
                <div class="account-top">
                    <FormInput label="Номер на сметка" v-model="account.account_number" :error="errors?.account_number?.[0]" />

                    <FormInput label="Наличност" v-model="account.amount" :error="errors?.amount?.[0]" />

                    <FormInput label="Лихва" v-model="account.interest" :error="errors?.interest?.[0]"/>
                </div>

                <div class="account-bottom">
                    <SelectComponent label="Валута" name="currency-select" id="currency-select" :options="currencies" v-model="account.currency_id"/>

                    <SelectComponent label="Вид сметка" name="account_type-select" id="account_type-select" :options="account_types" v-model="account.account_type_id"/>

                    <SelectComponent label="Притежател" name="user-select" id="user-select" :options="users" v-model="account.user_id"/>
                </div>

                <Button type="submit" class="btn" text="Промени" />
            </form>

            <LoadingComponent v-else class="loading" />

            <SuccessMessage text="Успешно променена сметка." :class="{'green-bg': true}" v-if="success_message" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-account-update{
    margin-block: 32px;

    .btn{
        width: 30%;
    }

    .loading{
        align-self: center;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__account{
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 50%;
        align-self: center;

        .account-top{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .account-bottom{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
    }
}
</style>