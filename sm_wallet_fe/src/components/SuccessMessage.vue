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
</style>