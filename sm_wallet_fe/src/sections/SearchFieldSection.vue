<template>
    <section class="section-search-bar">
        <div class="section__inner">
            <div class="section__opitons">
                <slot />
            </div>

            <div class="section__search__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M14.584 14.583L18.334 18.333" stroke="white" stroke-width="1.66667" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M16.667 9.16602C16.667 5.02388 13.3091 1.66602 9.16699 1.66602C5.02486 1.66602 1.66699 5.02388 1.66699 9.16602C1.66699 13.3082 5.02486 16.666 9.16699 16.666C13.3091 16.666 16.667 13.3082 16.667 9.16602Z"
                        stroke="white" stroke-width="1.66667" stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-search-bar {
    .section__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;

        .section__opitons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .section__search__icon {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px 8px;
            background: var(--c-base);
            width: fit-content;
            border-radius: 10px;
            cursor: pointer;
        }
    }
}
</style>