<script setup>
import FormErrorMessage from './FormErrorMessage.vue';

defineProps({
    label: {
        type: String,
        required: true
    },
    inputType: {
        type: String,
        default: 'text'
    },
    error: {
        type: String,
        required: false
    },
    optional: {
        type: Boolean,
        default: true
    },
    isForEmail: {
        type: Boolean,
        default: false
    },
    isForPassword: {
        type: Boolean,
        default: false
    },
    placeholder: {
        type: String,
        required: false
    }
});

const model = defineModel();
</script>

<template>
    <div class="form-input">
        <label>
            <div class="form-label">
                <p class="label-title">{{ label }}</p>
                <p class="label-optional" v-if="optional != true">(не е задължително)*</p>
            </div>

            <svg v-if="isForEmail" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                <path d="M3 7l9 6l9 -6" />
            </svg>

            <svg v-if="isForPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-shield-heart">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 21a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3a12.01 12.01 0 0 1 .378 5" />
                <path
                    d="M18 22l3.35 -3.284a2.143 2.143 0 0 0 .005 -3.071a2.242 2.242 0 0 0 -3.129 -.006l-.224 .22l-.223 -.22a2.242 2.242 0 0 0 -3.128 -.006a2.143 2.143 0 0 0 -.006 3.071l3.355 3.296z" />
            </svg>
        </label>

        <input :type="inputType" v-model="model" :placeholder>

        <FormErrorMessage v-if="error" :text="error" />
    </div>
</template>

<style scoped lang="scss">
.form-input {
    display: flex;
    flex-direction: column;
    gap: 4px;

    input::placeholder {
        color: var(--c-white);
        font-size: 15px;
    }

    input {
        border-radius: 8px;
        padding: 13px;
        flex-shrink: 0;
        border: 1px solid #475569;
        background: #334155;
        color: var(--c-white);
    }

    label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 3px;

        .label-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--c-gray);
        }

        .label-optional {
            color: var(--c-red);
            font-size: 10px;
            font-weight: 200;
            align-self: flex-end;
        }

        .form-label {
            display: flex;
            gap: 4px;
        }
    }
}
</style>