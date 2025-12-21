<script setup>
import SuccessMessage from '@/components/SuccessMessage.vue';
import { watch } from 'vue';
const props = defineProps({
    text: {
        type: String,
        required: true
    },
    success: {
        type: Boolean,
        required: true
    }
});

const childSuccess = ref(props.success);
watch(() => childSuccess.value, (newVal) => {
    if(newVal){
        startTimer();
    }
});

const startTimer = () => {
    setTimeout(() => {
        success.value = false;
    }, 3000);
};
</script>

<template>
    <div v-if="success" class="success_message__wrapper">
        <SuccessMessage class="success_message" :text />
    </div>
</template>

<style scoped lang="scss">
.success_message{
    font-size: 22px;
}

.success_message__wrapper{
    padding: 10px;
    background: var(--c-green);
    width: fit-content;
    border-radius: 8px;
    align-self: center;
}
</style>