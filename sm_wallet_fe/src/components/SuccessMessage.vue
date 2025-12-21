<script setup>
defineProps({
    text: {
        type: String,
        required: true
    }
});
</script>

<template>
    <div class="success">
        <p>{{ text }}</p>
    </div>
</template>

<style scoped>
.success {
    color: var(--c-green);
    text-align: center;
}

.green-bg {
    background-color: var(--c-green);
    color: var(--c-white);
    padding: 8px 16px;
    border-radius: 4px;
    width: fit-content;
    align-self: center;
}
</style>