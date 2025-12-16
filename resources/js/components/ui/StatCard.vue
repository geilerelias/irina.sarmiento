<template>
    <div :class="['bg-gradient-to-br ' + color, 'p-6 rounded-xl text-white text-center']">
        <div class="stat-number">{{ value }}</div>
        <p class="text-sm mt-2">{{ label }}</p>
    </div>
</template>

<script setup lang="ts">
// Props con tipos
interface Props {
    value: string;
    label: string;
    color: string;
}

defineProps<Props>();
</script>

<style scoped>
.stat-number {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1;
}
</style>