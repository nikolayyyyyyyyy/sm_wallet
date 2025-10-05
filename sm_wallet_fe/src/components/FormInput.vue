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
    isOptional: {
        Boolean,
        default: false
    }
});

const model = defineModel();
</script>

<template>
    <div class="form-input">
        <label>{{ label }}
            <p class="required-green" v-if="isOptional">(не е задължително)<span>*</span></p>
            <p class="required-red" v-else>(задължително)<span>*</span></p>
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
        border-radius: 3px;
        padding: 5px;
        border: 1px solid var(--c-gray);
    }

    label {
        display: flex;
        align-items: center;
        gap: 3px;

        .required-green,
        .required-red {
            font-size: 12px;
            color: var(--c-gray);
        }

        .required-red span {
            color: var(--c-red);
        }

        .required-green span {
            color: var(--c-green);
        }
    }
}
</style>