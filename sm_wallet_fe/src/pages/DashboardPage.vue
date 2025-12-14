<script setup>
import { auth } from '@/crud/auth';
import Admin from '@/layouts/Admin.vue';
import User from '@/layouts/User.vue';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const user = ref({});

const { getCurrentUser } = auth();

onMounted(() => {
    if (!localStorage.getItem('token')) {
        router.push('/login');
    }

    user.value = getCurrentUser();
});
</script>

<template>
    <section class="section-dashboard">
        <div class="section__inner shell">
            <User v-if="user?.role_id == 2" />

            <Admin v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-dashboard {
    margin-block: 32px;
}
</style>