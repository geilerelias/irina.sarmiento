<!-- resources/js/Components/Pagination.vue -->
<script setup>
defineProps({ links: Array });
</script>

<template>
    <div class="mt-6 flex justify-center gap-2">
        <button
            v-for="link in links"
            :key="link.label"
            v-html="link.label"
            @click="$inertia.visit(link.url)"
            :disabled="!link.url"
            class="rounded px-3 py-1 text-sm"
            :class="[
                link.active
                    ? 'bg-blue-600 text-white'
                    : 'bg-gray-200 dark:bg-gray-700',
                !link.url && 'cursor-not-allowed opacity-40',
            ]"
        />
    </div>
</template>
