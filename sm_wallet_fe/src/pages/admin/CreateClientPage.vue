<script setup lang="ts">
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import { ref } from 'vue';

const clientData = ref({
    name: '',
    middle_name: '',
    last_name: '',
    email: '',
    password: '',
    role_id: null
});

const displayAdminInput = ref(false);
const displayUserInput = ref(false);

function adminChoose() {
    clientData.value.role_id = 1;
    displayAdminInput.value = !displayAdminInput.value;
}

function userChoose() {
    clientData.value.role_id = 2;
    displayUserInput.value = displayUserInput.value;
}
</script>

<template>
    <section class="section-create-client">
        <div class="section__inner">
            <h1 class="section__title">Добави Клиент</h1>

            <form class="base-form">
                <div class="form-names">
                    <FormInput label="Име" />

                    <FormInput label="Презиме" />

                    <FormInput label="Фамилия" />
                </div>

                <FormInput label="Имейл" />

                <FormInput label="Парола" />

                <div class="radio-inputs">
                    <div @click.prevent="adminChoose" class="radio">
                        <svg v-if="displayAdminInput" xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                            viewBox="0 0 25 24" fill="none">
                            <circle cx="12.5" cy="12" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                            <circle cx="12.5" cy="12" r="3.935" fill="#6784C1" stroke="#6784C1" stroke-width="2.13" />
                        </svg>

                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                            fill="none">
                            <circle cx="12.5" cy="12" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                        </svg>

                        <div class="radio-text">
                            Админ
                        </div>
                        <input type="radio" name="radio" value="1" v-model="clientData.role_id" hidden>
                    </div>

                    <div @click.prevent="userChoose" class="radio">
                        <svg v-if="displayUserInput" xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                            viewBox="0 0 25 24" fill="none">
                            <circle cx="12.5" cy="12" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                            <circle cx="12.5" cy="12" r="3.935" fill="#6784C1" stroke="#6784C1" stroke-width="2.13" />
                        </svg>

                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                            fill="none">
                            <circle cx="12.5" cy="12" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                        </svg>

                        <div class="radio-text">
                            Потребител
                        </div>
                        <input type="radio" name="radio" value="2" v-model="clientData.role_id" hidden>
                    </div>
                </div>

                <Button text="Добави" />
            </form>
            {{ clientData.role_id }}
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-client {
    margin-block: 10px;

    .radio-inputs {
        display: flex;
        gap: 10px;

        .radio {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--c-base);
            border: 1px solid #475569;
            background: #334155;
            border-radius: 8px;
            padding: 13px;
            cursor: pointer;
            flex-grow: 1;

            .radio-text {
                font-weight: 600;
            }
        }
    }

    .section__title {
        color: var(--c-gray);
    }

    .form-names {
        display: flex;
        gap: 24px;
    }

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: center;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: fit-content
    }
}
</style>