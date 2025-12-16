<script setup lang="ts">
import { useSwipe } from '@vueuse/core';
import * as pdfjsLib from 'pdfjs-dist/build/pdf.mjs';
import workerSrc from 'pdfjs-dist/build/pdf.worker.mjs?url';
import { onMounted, ref, watch } from 'vue';

/* ================= PDF.JS ================= */
pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;

const props = defineProps<{
    src: string;
}>();

/* ================= STATE ================= */
const canvasLeft = ref<HTMLCanvasElement | null>(null);
const canvasRight = ref<HTMLCanvasElement | null>(null);
const bookRef = ref<HTMLElement | null>(null);

let pdfDoc: any = null;
const page = ref(1);
const pages = ref(0);
const scale = ref(1.1);
const flipping = ref(false);
const fullscreen = ref(false);

/* ================= CORE ================= */
const loadPdf = async () => {
    const res = await fetch(props.src);
    const data = await res.arrayBuffer();
    pdfDoc = await pdfjsLib.getDocument({ data }).promise;
    pages.value = pdfDoc.numPages;
    render();
};

const renderPage = async (
    canvas: HTMLCanvasElement | null,
    pageNum: number,
) => {
    if (!canvas || !pdfDoc || pageNum < 1 || pageNum > pages.value) return;

    const pageObj = await pdfDoc.getPage(pageNum);
    const viewport = pageObj.getViewport({ scale: scale.value });
    const ctx = canvas.getContext('2d')!;

    canvas.width = viewport.width;
    canvas.height = viewport.height;

    await pageObj.render({ canvasContext: ctx, viewport }).promise;
};

const render = async () => {
    await renderPage(canvasLeft.value, page.value);
    await renderPage(canvasRight.value, page.value + 1);
};

/* ================= NAVIGATION ================= */
const next = () => {
    if (page.value + 1 >= pages.value || flipping.value) return;
    flipping.value = true;
    setTimeout(async () => {
        page.value += 2;
        await render();
        flipping.value = false;
    }, 650);
};

const prev = () => {
    if (page.value <= 1 || flipping.value) return;
    flipping.value = true;
    setTimeout(async () => {
        page.value -= 2;
        await render();
        flipping.value = false;
    }, 650);
};

/* ================= ZOOM ================= */
const zoomIn = async () => {
    scale.value = Math.min(scale.value + 0.1, 2);
    await render();
};

const zoomOut = async () => {
    scale.value = Math.max(scale.value - 0.1, 0.6);
    await render();
};

/* ================= SWIPE ================= */
useSwipe(bookRef, {
    onSwipeEnd(_, dir) {
        if (dir === 'left') next();
        if (dir === 'right') prev();
    },
});

/* ================= LIFECYCLE ================= */
onMounted(loadPdf);
watch(() => props.src, loadPdf);
</script>

<template>
    <div class="pdf-viewer">
        <!-- CONTROLES -->
        <div class="toolbar">
            <button @click="prev" :disabled="page <= 1">◀</button>
            <span>{{ page }} - {{ page + 1 }} / {{ pages }}</span>
            <button @click="next" :disabled="page + 1 >= pages">▶</button>

            <button @click="zoomOut">➖</button>
            <button @click="zoomIn">➕</button>
            <button @click="fullscreen = true">⛶</button>
        </div>

        <!-- BOOK -->
        <div class="book-wrapper">
            <div ref="bookRef" class="book">
                <div class="page left">
                    <canvas ref="canvasLeft" />
                </div>

                <div class="page right" :class="{ flipping }">
                    <canvas ref="canvasRight" />
                </div>
            </div>
        </div>

        <!-- FULLSCREEN -->
        <Teleport to="body">
            <div
                v-if="fullscreen"
                class="modal"
                @click.self="fullscreen = false"
            >
                <div class="modal-content">
                    <button class="close" @click="fullscreen = false">✕</button>
                    <div class="book fullscreen">
                        <div class="page left">
                            <canvas ref="canvasLeft" />
                        </div>
                        <div class="page right">
                            <canvas ref="canvasRight" />
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<style scoped>
.pdf-viewer {
    width: 100%;
}

.toolbar {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    margin-bottom: 1rem;
}

.toolbar button {
    padding: 0.4rem 0.6rem;
    border-radius: 6px;
    background: #2b5cff;
    color: white;
}

.book-wrapper {
    display: flex;
    justify-content: center;
    overflow: auto;
}

.book {
    display: flex;
    perspective: 2000px;
}

.page {
    background: white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
}

.page canvas {
    max-width: 100%;
    height: auto;
}

.page.left {
    border-radius: 12px 0 0 12px;
}

.page.right {
    border-radius: 0 12px 12px 0;
    transform-origin: left center;
    transition: transform 0.65s ease;
}

.page.right.flipping {
    transform: rotateY(-180deg);
}

/* MODAL */
.modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
}

.modal-content {
    position: relative;
}

.close {
    position: absolute;
    top: -40px;
    right: 0;
    color: white;
    font-size: 1.5rem;
}

@media (max-width: 768px) {
    .book {
        flex-direction: column;
    }

    .page {
        margin-bottom: 1rem;
    }
}
</style>
