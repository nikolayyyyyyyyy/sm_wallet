<script setup lang="ts">
import { RouterLink } from 'vue-router';

</script>

<template>
    <section class="section__admin">
        <div class="base-form admin-panel-create">
            <RouterLink class="panel-item" to="/create-client">Добави Клиент</RouterLink>
            <RouterLink class="panel-item" to="/create-currency">Добави Валута</RouterLink>
            <RouterLink class="panel-item" to="/create-account-type">Добави Тип Акаунт</RouterLink>
            <RouterLink class="panel-item" to="/create-transaction-type">Добави Тип Транзакция</RouterLink>
            <RouterLink class="panel-item" to="/create-account">Добави Карта</RouterLink>
            <RouterLink class="panel-item" to="/create-transaction">Добави Транзакция</RouterLink>
        </div>

        <div class="base-form admin-panel-get">
            <RouterLink class="panel-item" to="/clients">Всички Клиенти</RouterLink>
            <RouterLink class="panel-item" to="/currencies">Всички Валути</RouterLink>
            <RouterLink class="panel-item" to="/account-types">Всички Типове Акаунти</RouterLink>
            <RouterLink class="panel-item" to="/transaction-types">Всички Типове Транзакции</RouterLink>
            <RouterLink class="panel-item" to="/accounts">Всички Карти</RouterLink>
            <RouterLink class="panel-item" to="/transactions">Всички Транзакции</RouterLink>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section__admin {
    margin-block: 32px;
    display: flex;
    justify-content: center;
    gap: 50px;
    flex-wrap: wrap;

    .admin-panel-get,
    .admin-panel-create {
        width: 300px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .panel-item {
        background-color: var(--c-white);
        padding: 13px;
        border-radius: 9999px;
        text-decoration: none;
        color: var(--c-black);
        font-weight: 900;
        text-align: center;
    }
}
</style>