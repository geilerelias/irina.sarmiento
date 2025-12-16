<script setup lang="ts">
import * as pdfjsLib from 'pdfjs-dist/build/pdf.mjs';
import workerSrc from 'pdfjs-dist/build/pdf.worker.mjs?url';
import { onMounted, ref, watch } from 'vue';

pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;

const props = defineProps<{
    src: string;
    page: number;
    scale: number;
}>();

const emit = defineEmits<{
    (e: 'loaded', pages: number): void;
}>();

const canvasRef = ref<HTMLCanvasElement | null>(null);
let pdfDoc: any = null;
let rendering = false;
let pending: number | null = null;

const loadPdf = async () => {
    const res = await fetch(props.src);
    const data = await res.arrayBuffer();
    pdfDoc = await pdfjsLib.getDocument({ data }).promise;
    emit('loaded', pdfDoc.numPages);
    render(props.page);
};

const render = async (num: number) => {
    if (!canvasRef.value || !pdfDoc) return;
    rendering = true;

    const page = await pdfDoc.getPage(num);
    const viewport = page.getViewport({ scale: props.scale });

    const canvas = canvasRef.value;
    const ctx = canvas.getContext('2d')!;

    canvas.width = viewport.width;
    canvas.height = viewport.height;

    await page.render({ canvasContext: ctx, viewport }).promise;

    rendering = false;
    if (pending) {
        render(pending);
        pending = null;
    }
};

watch(
    () => [props.page, props.scale],
    ([p]) => {
        if (rendering) pending = p;
        else render(p);
    },
);

onMounted(loadPdf);
</script>

<template>
    <canvas ref="canvasRef" class="max-w-full rounded-xl shadow-lg" />
</template>
