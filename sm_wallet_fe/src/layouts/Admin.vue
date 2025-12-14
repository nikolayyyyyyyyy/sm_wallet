<script setup lang="ts">
import { RouterLink } from 'vue-router';

</script>

<template>
    <section class="section__admin">
        <div class="base-form admin-panel-create">
            <RouterLink class="panel-item" to="/create-client">Добави клиент</RouterLink>
            <RouterLink class="panel-item" to="/create-currency">Добави валута</RouterLink>
            <RouterLink class="panel-item" to="/create-account-type">Добави вид сметка</RouterLink>
            <RouterLink class="panel-item" to="/create-transaction-type">Добави вид транзакция</RouterLink>
            <RouterLink class="panel-item" to="/create-account">Добави карта</RouterLink>
            <RouterLink class="panel-item" to="/create-transaction">Добави транзакция</RouterLink>
        </div>

        <div class="base-form admin-panel-get">
            <RouterLink class="panel-item" to="/clients">Клиенти</RouterLink>
            <RouterLink class="panel-item" to="/currencies">Валути</RouterLink>
            <RouterLink class="panel-item" to="/account-types">Видове сметки</RouterLink>
            <RouterLink class="panel-item" to="/transaction-types">Видове Транзакции</RouterLink>
            <RouterLink class="panel-item" to="/accounts">Сметки</RouterLink>
            <RouterLink class="panel-item" to="/transactions">Транзакции</RouterLink>
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
        border-radius: 10px;
        text-decoration: none;
        color: var(--c-black);
        font-weight: 900;
        text-align: center;
    }

    .panel-item:hover {
        background: #f9eded;
    }
}
</style>