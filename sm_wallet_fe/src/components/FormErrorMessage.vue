<script setup>
defineProps({
    text: {
        String,
        required: true
    }
});
</script>

<template>
    <p class="error">{{ text }}</p>
</template>

<style scoped>
.error {
    color: var(--c-red);
    font-size: 10px;
    padding-left: 8px;
}
</style>