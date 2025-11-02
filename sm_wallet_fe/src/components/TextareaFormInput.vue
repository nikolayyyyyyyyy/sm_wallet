<script setup>
import FormErrorMessage from './FormErrorMessage.vue';

defineProps({
    label: {
        type: String,
        required: true
    },
    error: {
        type: String
    }
});

const model = defineModel();
</script>

<template>
    <div class="textarea-input">
        <label>
            <p class="section__title">{{ label }}</p>
        </label>

        <textarea v-model="model" name="note-textarea" rows="7" id="note-textarea"></textarea>

        <FormErrorMessage v-if="error" :text="error" />
    </div>
</template>

<style scoped lang="scss">
.textarea-input {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 4px;

    .section__title {
        font-size: 13px;
        font-weight: 500;
        color: var(--c-gray);
    }

    textarea {
        color: var(--c-gray);
        background-color: #334155;
        border: 1px solid #475569;
        border-radius: 8px;
        padding: 13px;
        font-size: 15px;
        resize: none;
    }
}
</style>