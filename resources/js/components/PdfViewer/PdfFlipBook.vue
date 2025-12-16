<script setup lang="ts">
import { ref } from 'vue';
import PdfCanvas from './PdfCanvas.vue';

const props = defineProps<{
    src: string;
}>();

const page = ref(1);
const pages = ref(0);
const scale = ref(1.1);

const flipping = ref(false);

const next = () => {
    if (page.value >= pages.value || flipping.value) return;
    flipping.value = true;
    setTimeout(() => {
        page.value++;
        flipping.value = false;
    }, 600);
};

const prev = () => {
    if (page.value <= 1 || flipping.value) return;
    flipping.value = true;
    setTimeout(() => {
        page.value--;
        flipping.value = false;
    }, 600);
};

import { useSwipe } from '@vueuse/core';

useSwipe(bookRef, {
    onSwipeEnd(_, dir) {
        if (dir === 'left') next();
        if (dir === 'right') prev();
    },
});
</script>

<template>
    <div class="flipbook-wrapper">
        <div class="book">
            <!-- Página izquierda -->
            <div class="page left">
                <PdfCanvas
                    :src="src"
                    :page="page"
                    :scale="scale"
                    @loaded="pages = $event"
                />
            </div>

            <!-- Página derecha (flip) -->
            <div class="page right" :class="{ flipping }">
                <PdfCanvas :src="src" :page="page + 1" :scale="scale" />
            </div>
        </div>

        <!-- Controles -->
        <div class="controls">
            <button @click="prev">◀</button>
            <span>{{ page }} / {{ pages }}</span>
            <button @click="next">▶</button>
        </div>
    </div>
</template>
<style scoped>
.flipbook-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.book {
    position: relative;
    display: flex;
    perspective: 2000px;
}

.page {
    width: 45vw;
    max-width: 420px;
    background: white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.page.left {
    border-radius: 12px 0 0 12px;
}

.page.right {
    border-radius: 0 12px 12px 0;
    transform-origin: left center;
    transition: transform 0.6s ease;
}

.page.right.flipping {
    transform: rotateY(-180deg);
}

.controls {
    margin-top: 1rem;
    display: flex;
    gap: 1rem;
}
</style>
