<script setup lang="ts">
// 👉 Importamos el componente PDF
import PdfViewer from '@/components/PdfViewer.vue';

import GuestLayout from '@/layouts/GuestLayout.vue';
import { useNavigationStore } from '@/stores/usePublicNavigationStore';
import { usePage } from '@inertiajs/vue3';
import { FileText } from 'lucide-vue-next';

// 👉 Props desde el controller
const page = usePage();
const documents = page.props.documents as {
    id: number;
    title: string;
    journal: string;
    year: string;
    type: string;
    pdf: string;
}[];

const category = page.props.category as string;

// 👉 Usamos el store de navegación para obtener título, descripción e ícono
const nav = useNavigationStore();

const categoryInfo =
    nav.links
        .find((link) => link.href === '/academic-production')
        ?.children?.find((child) => child.href.endsWith(category)) || {};

const categoryTitle = categoryInfo.title || category;
const categoryDescription = categoryInfo.description || '';
const categoryIcon = categoryInfo.icon || FileText;
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
                <p class="mx-auto max-w-3xl text-lg text-gray-700">
                    {{ categoryDescription }}
                </p>
            </div>
        </section>

        <!-- CONTENIDO -->
        <section class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-6">
                <!-- LISTADO DE DOCUMENTOS -->
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="doc in documents"
                        :key="doc.id"
                        class="group border-orinoco-border rounded-2xl border bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
                    >
                        <!-- Header -->
                        <div class="mb-4 flex items-start justify-between">
                            <span
                                class="inline-flex items-center rounded-full bg-orinoco-light px-3 py-1 text-xs font-medium text-orinoco-primary"
                            >
                                {{ doc.year }}
                            </span>
                            <FileText class="h-5 w-5 text-orinoco-primary" />
                        </div>

                        <!-- Title -->
                        <h3
                            class="text-orinoco-darker mb-3 text-lg leading-snug font-semibold"
                        >
                            {{ doc.title }}
                        </h3>

                        <!-- Journal -->
                        <p class="mb-4 text-sm text-gray-600">
                            {{ doc.journal }}
                        </p>

                        <!-- PDF Viewer -->
                        <div class="mt-auto flex flex-col gap-2">
                            <a
                                :href="doc.pdf"
                                target="_blank"
                                class="text-sm font-semibold text-orinoco-primary transition hover:underline"
                            >
                                Abrir PDF
                            </a>
                            <!-- Componente PDF inline -->
                            <PdfViewer
                                :src="doc.pdf"
                                :height="200"
                                :viewBar="false"
                            />
                        </div>

                        <!-- Tipo -->
                        <span class="mt-2 block text-xs text-gray-500">{{
                            doc.type
                        }}</span>
                    </article>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
