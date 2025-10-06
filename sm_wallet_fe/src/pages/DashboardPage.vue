<script setup>
import { auth } from '@/crud/auth';
import Admin from '@/layouts/Admin.vue';
import User from '@/layouts/User.vue';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const roter = useRouter();
const user = ref({});

const { getUser } = auth();
onMounted(async () => {
    if (!localStorage.getItem('token')) {
        roter.push('/login');
    }

    user.value = await getUser();

    console.log(user.value);

});
</script>

<template>
    <section class="section-dashboard">
        <div class="section__inner shell">
            <Admin v-if="user.role_id == 1" />

            <User v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-dashboard {
    margin-top: 20px;

    .section__header {

        color: var(--c-gray);
    }
}
</style>