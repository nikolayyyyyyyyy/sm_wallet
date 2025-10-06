<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
const roter = useRouter();

onMounted(() => {
    if (!localStorage.getItem('token')) {
        roter.push('/login');
    }
});
</script>

<template>
    <section class="section-dashboard">

    </section>
</template>