<script setup>
import Button from '@/components/Button.vue';
import FormInput from '@/components/FormInput.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import SelectComponent from '@/components/SelectComponent.vue';
import { get } from '@/crud/get';
import { update } from '@/crud/update';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const props = defineProps({
    id:{
        type: String,
        required: true
    }
});
const router = useRouter();
const user = ref();
const { getItem } = get();
const is_loading = ref(false);
const is_fetching = ref(false);
const { updateData } = update();
const file__upload = ref();
const profile_photo_url = ref();
const errors = ref([]);

const updateUser = async () => {
    if(is_fetching.value) return;
    const form_data = new FormData();
    form_data.append('name', user.value.name);
    form_data.append('middle_name', user.value.middle_name);
    form_data.append('last_name', user.value.last_name);
    form_data.append('email', user.value.email);
    form_data.append('role_id', user.value.role_id);

    if (file__upload.value) {
        form_data.append('profile_picture', file__upload.value);
    }

    try{
        is_fetching.value = true;
        is_loading.value = true;

        await updateData(form_data, 'clients', props.id);
    }catch(err){
        errors.value = JSON.parse(err.message).errors;
    }finally{
        is_fetching.value = false;
        is_loading.value = false;
    }
};

function handleChangeOfPhoto(event)
{
    const file = event.target.files[0];
    file__upload.value = file;
    profile_photo_url.value = URL.createObjectURL(file);
}

const removeImage = async () => {
    profile_photo_url.value = null;
    file__upload.value = null;
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }
    is_loading.value = true;
    user.value = await getItem('clients', props.id);
    profile_photo_url.value = user.value.profile_photo;
    is_loading.value = false;
});
</script>

<template>
    <section class="section-client-update">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/clients" />

                <h1>Редактирай клиент</h1>
            </div>

            <div v-if="!is_loading && user" class="section__user">
                <label for="image-upload" class="image_upload">
                    <figure class="user__image image-fit">
                        <img :src="profile_photo_url ?? '/avatar.png'">
                    </figure>

                    <input type="file" @change="handleChangeOfPhoto" name="image-upload" id="image-upload" hidden>

                    <p v-if="profile_photo_url" @click.stop.prevent="removeImage" class="exit">X</p>
                </label>

                <form @submit.prevent="updateUser" class="section__user__content">
                    <div class="content__names">
                        <FormInput label="име" v-model="user.name" :error="errors?.name?.[0]"/>

                        <FormInput label="презиме" v-model="user.middle_name" :error="errors?.middle_name?.[0]"/>

                        <FormInput label="фамилия" v-model="user.last_name" :error="errors?.last_name?.[0]"/>
                    </div>

                    <FormInput label="имейл" v-model="user.email" :error="errors?.email?.[0]"/>

                    <SelectComponent v-model="user.role_id" name="select-role"
                        id="select-role" label="Права"
                        :options="[{ id: 1, text: 'Админ' }, { id: 2, text: 'Потребител' }]" />

                    <Button type="submit" text="Промени" class="update__btn" />
                </form>
            </div>

            <LoadingComponent v-else class="loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-client-update{
    margin-block: 32px;

    .exit{
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        right: 5px;
        top: 4px;
        padding: 5px 10px;
        color: var(--c-gray);
        font-size: 18px;
        background-color: var(--c-base);
        border-radius: 50%;
        cursor: pointer;
    }

    .update__btn{
        width: 200px;
        align-self: center;
        margin-top: 20px;
    }

    .section__user{
        display: flex;
        align-items: center;
        justify-content: center;
        gap:50px;
    }

    .content__names{
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section__user__content{
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .image_upload{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30%;
        position: relative;

        .user__image{
            border: 3px solid var(--c-base);
            border-radius: 10px;
            width: 100%;
            aspect-ratio: 1 / 1;
        }
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray)
    }

    .loading{
        align-self: center;
    }
}
</style>