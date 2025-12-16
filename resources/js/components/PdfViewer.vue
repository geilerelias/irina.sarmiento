<script setup lang="ts">
import { useSwipe } from '@vueuse/core';
import * as pdfjsLib from 'pdfjs-dist/build/pdf.mjs';
import workerSrc from 'pdfjs-dist/build/pdf.worker.mjs?url';
import { onMounted, ref, watch } from 'vue';

import { ChevronLeft, ChevronRight, X, ZoomIn, ZoomOut } from 'lucide-vue-next';

pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;

const props = defineProps<{
    src: string;
    viewBar?: boolean;
}>();

const canvasRef = ref<HTMLCanvasElement | null>(null);
const viewerRef = ref<HTMLElement | null>(null);

let pdfDoc: any = null;
const page = ref(1);
const pages = ref(0);
const scale = ref(1.1);
const fullscreen = ref(false);

/* ================= CORE ================= */
const loadPdf = async () => {
    const res = await fetch(props.src);
    const data = await res.arrayBuffer();
    pdfDoc = await pdfjsLib.getDocument({ data }).promise;
    pages.value = pdfDoc.numPages;
    render();
};

const render = async () => {
    if (!canvasRef.value || !pdfDoc) return;

    const pageObj = await pdfDoc.getPage(page.value);
    const viewport = pageObj.getViewport({ scale: scale.value });
    const ctx = canvasRef.value.getContext('2d')!;

    canvasRef.value.width = viewport.width;
    canvasRef.value.height = viewport.height;

    await pageObj.render({ canvasContext: ctx, viewport }).promise;
};

/* ================= NAVIGATION ================= */
const next = async () => {
    if (page.value >= pages.value) return;
    page.value++;
    await render();
};

const prev = async () => {
    if (page.value <= 1) return;
    page.value--;
    await render();
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
useSwipe(viewerRef, {
    onSwipeEnd(_, dir) {
        if (dir === 'left') next();
        if (dir === 'right') prev();
    },
});

/* ================= LIFECYCLE ================= */
onMounted(loadPdf);
watch(() => props.src, loadPdf);

const emit = defineEmits<{
    (e: 'close'): void;
}>();
</script>
<template>
    <div class="pdf-viewer">
        <!-- TOOLBAR -->
        <div
            v-if="viewBar"
            class="toolbar border-orinoco-border border bg-orinoco-light"
        >
            <button @click="prev" :disabled="page <= 1" class="btn">
                <ChevronLeft />
            </button>

            <span class="page-indicator text-orinoco-dark">
                {{ page }} / {{ pages }}
            </span>

            <button @click="next" :disabled="page >= pages" class="btn">
                <ChevronRight />
            </button>

            <button @click="zoomOut" class="btn">
                <ZoomOut />
            </button>

            <button @click="zoomIn" class="btn">
                <ZoomIn />
            </button>

            <button class="close" @click="emit('close')"><X /></button>
        </div>

        <!-- VIEWER -->
        <div class="book-wrapper">
            <div ref="viewerRef" class="page single">
                <canvas ref="canvasRef" />
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
                    <button class="close" @click="fullscreen = false">
                        <X />
                    </button>

                    <div ref="viewerRef" class="page single fullscreen">
                        <canvas ref="canvasRef" />
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>
<style scoped>
.pdf-viewer {
    width: 100%;
    font-family: var(--font-sans);
}

/* TOOLBAR */
.toolbar {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    align-items: center;
    margin-bottom: 1rem;
    padding: 0.5rem;
    border-radius: 0.75rem;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--orinoco-primary);
    color: var(--orinoco-text-light);
    border-radius: 0.5rem;
    padding: 0.4rem;
    transition: background 0.2s;
}

.btn:hover {
    background: var(--orinoco-primary-dark);
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-indicator {
    font-weight: 500;
}

/* VIEWER */
.book-wrapper {
    display: flex;
    justify-content: center;
    overflow: auto;
}

.page.single {
    background: white;
    box-shadow: 0 10px 30px var(--orinoco-shadow);
    border-radius: 1rem;
    padding: 0.75rem;
}

.page canvas {
    max-width: 100%;
    height: auto;
}

/* FULLSCREEN */
.modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    position: relative;
    width: 100%;
    height: 100%;
    padding: 1rem;
}

.page.fullscreen {
    width: 100%;
    height: 100%;
    overflow: auto;
    background: var(--orinoco-light);
}

.close {
    position: absolute;
    right: 1rem;
    background: var(--orinoco-error);
    color: white;
    height: 2rem;
    width: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    cursor: pointer;
}

/* MOBILE */
@media (max-width: 768px) {
    .toolbar {
        flex-wrap: wrap;
    }
}
</style>
