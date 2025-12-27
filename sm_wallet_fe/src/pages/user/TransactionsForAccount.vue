<script setup>
import Card from '@/components/Card.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useRouter } from 'vue-router';
const props = defineProps({
    id:{
        type: String,
        required: true
    }
});
const router = useRouter();
const route = useRoute();

const account = ref();
const index = route.query.index;
const is_loading = ref(false);
const transactions = ref();

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;

    const loaded_account_response = await fetch(`http://127.0.0.1:8000/api/accounts/${props.id}/loaded`,{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    });

    account.value = await loaded_account_response.json();

    const transactions_response = await fetch(`http://127.0.0.1:8000/api/transactions/${account.value.account_number}`,{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    });

    transactions.value = await transactions_response.json();

    console.log(transactions.value);
    is_loading.value = false;
});
</script>

<template>
    <section class="section-transactions-for-account">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/" />

                <h1>Транзакции по сметка</h1>
            </div>

            <div v-if="!is_loading && account" class="section__card">
                <div class="section__card__content">
                    <Card :card="account" :class="{ light: index % 2 == 0, gray: index % 2 == 1 }" /> 
                </div>
            </div>

            <LoadingComponent v-else class="loading" />
        </div>
    </section>    
</template>

<style scoped lang="scss">
.section-transactions-for-account{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;

        .section__title{
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            color: var(--c-gray);
        }

        .section__card__content{
            display: flex;
            justify-content: center;
        }

        .loading{
            align-self: center;
        }
    }
}
</style>