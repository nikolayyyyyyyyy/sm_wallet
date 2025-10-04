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
    width: 50%;
    align-self: center;
    font-size: 16px;
    padding: 5px;
    border-radius: 3px;
    border: 1px solid var(--c-gray);
    background-color: var(--c-base);
    color: var(--c-white);
}

.btn:hover {
    background-color: var(--c-blue);
    cursor: pointer;
}
</style>