<script setup lang="ts">
import { RouterLink } from 'vue-router';

</script>

<template>
    <section class="section__admin">
        <div class="section__inner shell">
            <div class="base-form admin-panel">
                <RouterLink class="panel-item" to="/create-client">Добави Клиент</RouterLink>
                <RouterLink class="panel-item" to="/create-card">Добави Карта</RouterLink>
                <RouterLink class="panel-item" to="/clients/all">Всички Клиенти</RouterLink>
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