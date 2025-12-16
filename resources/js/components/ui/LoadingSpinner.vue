<template>
    <div class="animate-spin rounded-full border-2 border-gray-300 border-t-orinoco-primary" :class="sizeClasses"></div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

// Props con tipos
interface Props {
  size?: 'sm' | 'md' | 'lg';
}

const props = withDefaults(defineProps<Props>(), {
  size: 'md'
});

// Computadas con tipos
const sizeClasses = computed<string>(() => {
    const sizes: Record<string, string> = {
        sm: 'w-4 h-4',
        md: 'w-5 h-5',
        lg: 'w-6 h-6'
    };
    return sizes[props.size];
});
</script>