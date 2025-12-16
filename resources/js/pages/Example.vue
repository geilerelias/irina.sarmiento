<script setup lang="ts">
import PdfViewer from '@/components/PdfViewer.vue';
import AppLayout from '@/layouts/AppLayout.vue';
</script>
<template>
    <AppLayout title="Example">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h2 class="text-xl font-semibold leading-tight">
                    Example Page
                </h2>
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        This is an example page.
                    </div>
                </div>
                <PdfViewer
                    :src="`/secure-pdf/academic-documents/506mSq8vzS81B4pcW6khRboUuvHowdRdsiVJ5qtH.pdf`"
                />
            </div>
        </div>
    </AppLayout>
</template>
