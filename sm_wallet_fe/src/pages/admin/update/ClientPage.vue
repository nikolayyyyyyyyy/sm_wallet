<script setup>
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import Button from '@/components/Button.vue';
import SuccessMessage from '@/components/SuccessMessage.vue';
const router = useRouter();
const props = defineProps({
    id: {
        type: Number,
        required: true
    }
});

const user = ref(null);
const updatedUser = ref({});
const { getItem } = get();
const is_loading = ref(false);
const errors = ref(null);
const successMessage = ref('');

const handleUpdate = async () => {
    errors.value = null;
    successMessage.value = '';
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/clients/${props.id}/update`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(updatedUser.value)
        });

        if (!response.ok) {
            const payload = await response.json();
            if (payload.errors) {
                errors.value = payload.errors;
            } else {
                throw new Error('Update failed');
            }
            return;
        }

        successMessage.value = 'Клиентът е обновен успешно!';
        setTimeout(() => router.replace('/clients'), 900);
    } catch (err) {
        console.error(err);
        errors.value = { general: ['Възникна грешка'] };
    }
};

onMounted(async () => {
    is_loading.value = true;
    user.value = await getItem('clients', props.id);
    // initialize updatedUser with current values
    updatedUser.value = {
        name: user.value.name || '',
        middle_name: user.value.middle_name || '',
        last_name: user.value.last_name || '',
        email: user.value.email || '',
        role_id: user.value.role_id || '',
        password: ''
    };

    is_loading.value = false;
});
</script>

<template>
    <section class="section-update-client">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/clients" />

                <h1>Промени информацията за клиент</h1>
            </div>

            <form v-if="is_loading == false" @submit.prevent="handleUpdate" class="base-form">
                <FormInput label="име" v-model="updatedUser.name" :placeholder="user?.name" />
            </form>

            <LoadingComponent v-else class="loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-update-client {
    margin-block: 32px;

    .loading {
        align-self: center;
    }

    .section__inner {
        display: flex;
        flex-direction: column;
        gap: 24px;

        .section__title {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            color: var(--c-gray);
            text-align: center;
            gap: 30px;
        }

        form {
            align-self: center;
        }
    }
}
</style>