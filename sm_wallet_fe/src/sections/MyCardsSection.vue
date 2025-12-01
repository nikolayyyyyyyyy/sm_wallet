<script setup>
const props = defineProps({
    total_price: {
        type: Number,
        required: true
    }
});

</script>

<template>
    <section class="section-my-cards base-form">
        <div class="section__head">
            <p class="section__text">Total Balance</p>

            <p class="section__amount">${{ total_price }}</p>
        </div>

        <div class="section__cards">
            <slot />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-my-cards {
    display: flex;
    flex-direction: column;
    gap: 20px;

    .section__cards {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .section__head {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .section__text {
        color: var(--c-gray);
        font-size: 15px;
        font-weight: 400;
    }

    .section__amount {
        font-size: 25px;
        color: var(--c-white);
        font-weight: 500;
    }
}
</style>