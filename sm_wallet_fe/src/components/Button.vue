<script setup>
defineProps({
    text: {
        String,
        required: true
    }
});
</script>

<template>
    <button class="btn">
        {{ text }}
    </button>
</template>

<style scoped>
.btn {
    width: 100%;
    align-self: center;
    font-size: 16px;
    color: var(--c-white);
    cursor: pointer;
    border-radius: 9999px;
    background: var(--c-blue);
    padding-block: 15px;
}
</style>