<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
const route = useRoute();

const messages = ref([]);

onMounted(async () => {
    messages.value = await fetch('http://127.0.0.1:8000/api/messages/' + route.params.id,{
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    });
});
</script>

<template>
    {{ route.params.id }}
</template>