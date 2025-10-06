<script setup>
import FormErrorMessage from './FormErrorMessage.vue';

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
    },
    optional: {
        Boolean,
        default: true
    }
});

const model = defineModel();
</script>

<template>
    <div class="form-input">
        <label>{{ label }}
            <p v-if="optional != true">(не е задължително)<span>*</span></p>
        </label>

        <input :type="inputType" v-model="model">

        <FormErrorMessage v-if="error" :text="error" />
    </div>
</template>

<style scoped lang="scss">
.form-input {
    display: flex;
    flex-direction: column;
    gap: 4px;

    input {
        border-radius: 8px;
        padding: 13px 13px 13px 41px;
        flex-shrink: 0;
        border: 1px solid #475569;
        background: #334155;
        color: var(--c-white);
    }

    label {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: 14px;
        font-weight: 500;
        color: var(--c-gray);

        p {
            font-size: 10px;
        }

        span {
            color: var(--c-red);
        }
    }
}
</style>