<!-- resources/js/Components/Modal.vue -->
<script setup>
defineProps({ show: Boolean });
defineEmits(['close']);
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="w-full max-w-xl rounded-xl bg-white p-6 dark:bg-gray-900">
            <slot />
            <div class="mt-6 text-right">
                <button
                    @click="$emit('close')"
                    class="rounded bg-gray-200 px-4 py-2 dark:bg-gray-700"
                >
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>
