<script setup lang="ts">
import { RouterLink } from 'vue-router';

</script>

<template>
    <section class="section__admin">
        <div class="section__inner shell">
            <div class="base-form admin-panel">
                <RouterLink class="panel-item" to="/create-client">Добави Клиент</RouterLink>
                <RouterLink class="panel-item" to="/create-currency">Добави Валута</RouterLink>
                <RouterLink class="panel-item" to="create-account-type">Добави Тип Акаунт</RouterLink>
                <RouterLink class="panel-item" to="create-transaction-type">Добави Тип Транзакция</RouterLink>
                <RouterLink class="panel-item" to="create-account">Добави Карта</RouterLink>
                <RouterLink class="panel-item" to="create-transaction">Добави Транзакция</RouterLink>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.admin-panel {
    width: 30%;
    margin: 100px auto;
    display: flex;
    flex-direction: column;
    gap: 12px;

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