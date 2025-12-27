<script setup>
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import LoadingComponent from '@/components/LoadingComponent.vue';
import { del } from '@/crud/delete';
import { get } from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();

const clients = ref([]);
const { getData } = get();
const { deleteData } = del();
const is_loading = ref(false);

const deleteClient = async (id) => {
    await deleteData(id, 'clients');
    clients.value = clients.value.filter(c => c.id !== id);
};

onMounted(async () => {
    if (!localStorage.getItem('token')) {
        router.push('login');
    }
    is_loading.value = true;
    clients.value = await getData('clients');
    is_loading.value = false;
});

</script>

<template>
    <section class="section-clients">
        <div class="section__shell shell">
            <div class="section__title">
                <GoToArrow :reversed="true" nav-to="/" />

                <h1>Клиенти</h1>
            </div>

            <div v-if="!is_loading" class="section__clients">
                <div v-for="client in clients" class="section__client base-form">
                    <div class="section__client__inner">
                        <figure class="inner__photo image-fit">
                            <img :src="client.profile_photo ?? '/avatar.png'">
                        </figure>

                        <div class="inner__content">
                            <p>Име: {{ client.name }}</p>
                            <p>Презиме: {{ client.middle_name ? client.middle_name : 'Не е въведено' }}</p>
                            <p>Фамилия: {{ client.last_name ? client.last_name : 'Не е въведено' }}</p>
                            <p>Имейл: {{ client.email }}</p>
                            <p>Роля: {{ client.role.role_name }}</p>
                        </div>
                    </div>

                    <div class="section__buttons">
                        <Button text="Изтрий" :delete_btn="true" @click.prevent="deleteClient(client.id)" />
                    </div>
                </div>
            </div>

            <LoadingComponent v-else class="loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-clients {
    margin-block: 32px;

    .section__title {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        color: var(--c-gray);
    }

    .section__shell {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__clients {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section__client {
        display: flex;
        flex-direction: column;
        gap: 24px;
        flex: 0 0 calc((100% - 40px) / 3);
        box-sizing: border-box;
        color: var(--c-gray);
        font-size: 18px;

        .inner__content{
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: fit-content;
        }

        .section__client__inner{
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .inner__photo{
            width: 50%;
            border-radius: 10px;
            aspect-ratio: 1 / 1;
            align-self: flex-start;
        }
    }

    .loading {
        align-self: center;
    }

    .section__buttons {
        margin-top: auto;
        display: flex;
        gap: 20px;

        .more_link{
            width: 100%;
        }
    }
}
</style>