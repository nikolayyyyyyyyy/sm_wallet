<script setup lang="ts">
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import RadioInput from '@/components/RadioInput.vue';
import { ref } from 'vue';
const clientData = ref({

});

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
                    <RadioInput text="Админ" />
                </div>

                <Button text="Добави" />
            </form>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-client {
    margin-block: 10px;

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