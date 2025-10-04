<script setup>
import ErrorParagraph from './ErrorParagraph.vue';

defineProps({
    label: {
        String,
        required: true
    },
    inputType: {
        String,
        default: 'text'
    },
    error: {
        String,
        required: false
    }
});

const model = defineModel();
</script>

<template>
    <div class="form-input">
        <label>{{ label }}</label>

        <input :type="inputType" v-model="model">

        <ErrorParagraph v-if="error" :text="error" />
    </div>
</template>

<style scoped lang="scss">
.form-input {
    display: flex;
    flex-direction: column;
    gap: 4px;

    input {
        border-radius: 3px;
        padding: 5px;
        border: 1px solid var(--c-gray);
    }
}
</style>