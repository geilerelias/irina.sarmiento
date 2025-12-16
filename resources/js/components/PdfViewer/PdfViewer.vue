<script setup lang="ts">
import { ref } from 'vue';
import PdfCanvas from './PdfCanvas.vue';
import PdfControls from './PdfControls.vue';
import PdfModal from './PdfModal.vue';

const props = defineProps<{ src: string }>();

const page = ref(1);
const pages = ref(0);
const scale = ref(1.2);
const fullscreen = ref(false);

const next = () => page.value < pages.value && page.value++;
const prev = () => page.value > 1 && page.value--;
</script>

<template>
    <div class="w-full rounded-xl border p-4">
        <PdfControls
            :page="page"
            :pages="pages"
            @prev="prev"
            @next="next"
            @zoomIn="scale += 0.1"
            @zoomOut="scale = Math.max(0.6, scale - 0.1)"
        />

        <div class="flex justify-center py-4">
            <PdfCanvas
                :src="src"
                :page="page"
                :scale="scale"
                @loaded="pages = $event"
                @dblclick="fullscreen = true"
            />
        </div>

        <PdfModal :open="fullscreen" @close="fullscreen = false">
            <PdfCanvas :src="src" :page="page" :scale="scale + 0.3" />
        </PdfModal>
    </div>
</template>
