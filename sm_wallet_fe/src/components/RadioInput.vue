<script setup>
defineProps({
    text: {
        type: String,
        required: true
    }
});
</script>

<template>
    <div class="radio">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
            <circle cx="12.5" cy="12" r="8.935" stroke="#6784C1" stroke-width="2.13" />
        </svg>
        <div class="radio-text">
            {{ text }}
        </div>
        <input type="radio">
    </div>
</template>

<style scoped lang="scss">
.radio {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--c-base);
    border: 1px solid #475569;
    background: #334155;

    .radio-text {
        font-weight: 600;
    }

    input {
        visibility: hidden;
    }
}
</style>