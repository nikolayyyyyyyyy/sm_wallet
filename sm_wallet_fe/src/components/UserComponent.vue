<script setup>
const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});
import LikeStarComponent from './LikeStarComponent.vue';
</script>

<template>
    <div class="user">
        <div class="user__content">
            <figure class="content__image image-fit">
                <img src="/public/456799695_842499038025303_7209467520786118063_n.jpg">
            </figure>

            <div class="content">
                <p class="content__title">
                    {{ user.name ?? '' }} {{ user.middle_name ?? '' }} {{ user.last_name ?? '' }}
                </p>

                <p class="content__text">
                    {{ user.email ?? '' }}
                </p>
            </div>
        </div>

        <LikeStarComponent :element-id="user.id" :is-liked="user.is_favorited" />
    </div>
</template>

<style scoped lang="scss">
.user {
    display: flex;
    gap: 10px;
    align-items: center;
    padding: 20px;
    border-radius: 10px;
    background: var(--c-blue);
    width: fit-content;

    .content__image {
        width: 50px;
        aspect-ratio: 1 / 1;
        border-radius: 100%;
        display: flex;
    }

    .user__content {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--c-gray);
    }

    .content__text,
    .content__title {
        font-weight: 400;
    }

    .content__title {
        font-size: 18px;
    }

    .content__text {
        font-size: 15px;
    }

    svg {
        cursor: pointer;
    }
}
</style>