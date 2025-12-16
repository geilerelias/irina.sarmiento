<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

import PdfViewer from '@/components/PdfViewer.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { useNavigationStore } from '@/stores/usePublicNavigationStore';
import { FileText } from 'lucide-vue-next';

/* ======================
 * Tipos
 * ====================== */
interface AcademicDocument {
    id: number;
    title: string;
    description?: string | null;
    published_at?: string | null;
    file_path?: string | null;
    file_type?: 'pdf' | 'image' | 'other';
}

/* ======================
 * Props desde Inertia
 * ====================== */
const page = usePage();

const documents = computed<AcademicDocument[]>(
    () => page.props.documents as AcademicDocument[],
);

const category = computed(() => page.props.category as string);

/* ======================
 * Información de navegación
 * ====================== */
const nav = useNavigationStore();

const categoryInfo = computed(() => {
    return (
        nav.links
            .find((link) => link.href === '/academic-production')
            ?.children?.find((child) => child.href.endsWith(category.value)) ??
        {}
    );
});

const categoryTitle = computed(
    () => categoryInfo.value.title ?? category.value,
);

const categoryDescription = computed(
    () => categoryInfo.value.description ?? '',
);

const categoryIcon = computed(() => categoryInfo.value.icon ?? FileText);

/* ======================
 * Helpers
 * ====================== */
const formatYear = (date?: string | null) => {
    if (!date) return '';
    return new Date(date).getFullYear();
};

/* ======================
 * Modal state
 * ====================== */
const isModalOpen = ref(false);
const activeDocument = ref<AcademicDocument | null>(null);

const openModal = (doc: AcademicDocument) => {
    activeDocument.value = doc;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    activeDocument.value = null;
};
</script>

<template>
    <GuestLayout>
        <!-- HERO -->
        <section class="relative overflow-hidden bg-orinoco-light py-24">
            <div class="absolute inset-0">
                <img
                    src="/images/academic/articles-hero.jpg"
                    alt="Documentos académicos"
                    class="h-full w-full object-cover opacity-10"
                />
            </div>

            <div class="relative mx-auto max-w-7xl px-6 text-center">
                <component
                    :is="categoryIcon"
                    class="mx-auto mb-6 h-14 w-14 text-orinoco-primary"
                />

                <h1 class="text-orinoco-darker mb-4 text-4xl font-bold">
                    {{ categoryTitle }}
                </h1>

                <p
                    v-if="categoryDescription"
                    class="mx-auto max-w-3xl text-lg text-gray-700"
                >
                    {{ categoryDescription }}
                </p>
            </div>
        </section>

        <!-- CONTENIDO -->
        <section class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-6">
                <div
                    v-if="documents.length"
                    class="grid gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="doc in documents"
                        :key="doc.id"
                        class="group border-orinoco-border rounded-2xl border bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
                    >
                        <!-- Header -->
                        <div class="mb-4 flex items-start justify-between">
                            <span
                                v-if="doc.published_at"
                                class="inline-flex items-center rounded-full bg-orinoco-light px-3 py-1 text-xs font-medium text-orinoco-primary"
                            >
                                {{ formatYear(doc.published_at) }}
                            </span>

                            <FileText class="h-5 w-5 text-orinoco-primary" />
                        </div>

                        <!-- Title -->
                        <h3
                            class="text-orinoco-darker mb-3 text-lg leading-snug font-semibold"
                        >
                            {{ doc.title }}
                        </h3>

                        <!-- Description -->
                        <p
                            v-if="doc.description"
                            class="mb-4 text-sm text-gray-600"
                        >
                            {{ doc.description }}
                        </p>

                        <!-- Preview -->
                        <div class="mt-auto space-y-3">
                            <!-- PDF preview -->
                            <PdfViewer
                                v-if="doc.file_type === 'pdf' && doc.file_path"
                                :src="doc.file_path"
                                :height="200"
                                :viewBar="false"
                            />

                            <!-- Imagen preview -->
                            <img
                                v-else-if="
                                    doc.file_type === 'image' && doc.file_path
                                "
                                :src="doc.file_path"
                                alt="Vista previa"
                                class="h-48 w-full rounded-lg border object-cover"
                            />

                            <!-- Acción -->
                            <button
                                @click="openModal(doc)"
                                class="w-full rounded-lg border border-orinoco-primary px-4 py-2 text-sm font-semibold text-orinoco-primary transition hover:bg-orinoco-primary hover:text-white"
                            >
                                Ver documento
                            </button>
                        </div>

                        <!-- Tipo -->
                        <span
                            v-if="doc.file_type"
                            class="mt-2 block text-xs text-gray-500"
                        >
                            {{ doc.file_type.toUpperCase() }}
                        </span>
                    </article>
                </div>

                <p v-else class="text-center text-gray-500">
                    No hay documentos disponibles en esta categoría.
                </p>
            </div>
        </section>

        <!-- MODAL FULLSCREEN -->
        <div
            v-if="isModalOpen && activeDocument"
            class="fixed inset-0 z-50 bg-black/80"
        >
            <div class="relative flex h-screen w-screen flex-col bg-white">
                <!-- Content -->
                <div class="flex-1 overflow-hidden">
                    <!-- PDF -->
                    <PdfViewer
                        v-if="activeDocument.file_type === 'pdf'"
                        :src="activeDocument.file_path!"
                        class="h-full w-full"
                        :viewBar="true"
                        @close="closeModal"
                    />

                    <!-- Imagen -->
                    <div
                        v-else-if="activeDocument.file_type === 'image'"
                        class="flex h-full items-center justify-center bg-gray-100"
                    >
                        <img
                            :src="activeDocument.file_path!"
                            alt="Documento"
                            class="max-h-full max-w-full object-contain"
                        />
                    </div>

                    <!-- Fallback -->
                    <div
                        v-else
                        class="flex h-full items-center justify-center text-gray-500"
                    >
                        No se puede previsualizar este tipo de archivo.
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
