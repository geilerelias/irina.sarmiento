<script setup lang="ts">
defineProps<{ open: boolean }>();
defineEmits(['close']);
</script>

<template>
    <Teleport to="body">
        <div
            v-if="open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80"
            @click.self="$emit('close')"
        >
            <div class="relative h-full w-full p-4">
                <slot />
                <button
                    class="absolute top-4 right-4 text-xl text-white"
                    @click="$emit('close')"
                >
                    ✕
                </button>
            </div>
        </div>
    </Teleport>
</template>
