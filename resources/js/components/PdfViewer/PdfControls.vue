<script setup lang="ts">
defineProps<{
    page: number;
    pages: number;
}>();

defineEmits(['prev', 'next', 'zoomIn', 'zoomOut']);
</script>

<template>
    <div class="flex items-center gap-3">
        <button @click="$emit('prev')" :disabled="page <= 1">◀</button>
        <span>{{ page }} / {{ pages }}</span>
        <button @click="$emit('next')" :disabled="page >= pages">▶</button>

        <button @click="$emit('zoomOut')">➖</button>
        <button @click="$emit('zoomIn')">➕</button>
    </div>
</template>
