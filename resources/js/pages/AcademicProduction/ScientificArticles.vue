<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { FileText } from "lucide-vue-next";

interface AcademicArticle {
  id: number;
  title: string;
  journal: string;
  year: string;
  type: string;
  pdf: string;
}

const articles: AcademicArticle[] = [
  {
    id: 1,
    title:
      "Educación comunitaria y construcción de tejido social en contextos vulnerables",
    journal: "Revista Latinoamericana de Educación Comunitaria",
    year: "2019",
    type: "Artículo científico",
    pdf: "/pdfs/articles/articulo-educacion-comunitaria.pdf",
  },
  {
    id: 2,
    title:
      "Planeación educativa como herramienta para la transformación social",
    journal: "Revista Colombiana de Estudios Educativos",
    year: "2021",
    type: "Artículo científico",
    pdf: "/pdfs/articles/planeacion-educativa.pdf",
  },
  {
    id: 3,
    title:
      "Prácticas pedagógicas inclusivas en contextos rurales",
    journal: "Revista Iberoamericana de Educación",
    year: "2023",
    type: "Artículo científico",
    pdf: "/pdfs/articles/practicas-pedagogicas-inclusivas.pdf",
  },
];
</script>
<template>
  <GuestLayout>
    <!-- HERO -->
    <section class="relative overflow-hidden bg-orinoco-light py-24">
      <div class="absolute inset-0">
        <img
          src="/images/academic/articles-hero.jpg"
          alt="Artículos científicos"
          class="h-full w-full object-cover opacity-10"
        />
      </div>

      <div class="relative mx-auto max-w-7xl px-6 text-center">
        <FileText class="mx-auto h-14 w-14 text-orinoco-primary mb-6" />

        <h1 class="text-4xl font-bold text-orinoco-darker mb-4">
          Artículos Científicos
        </h1>

        <p class="mx-auto max-w-3xl text-lg text-gray-700">
          Producción académica revisada por pares, orientada a la difusión del
          conocimiento científico en el campo de la educación, la psicología
          social y los estudios comunitarios.
        </p>
      </div>
    </section>

    <!-- CONTENIDO -->
    <section class="bg-white py-24">
      <div class="mx-auto max-w-7xl px-6">

        <!-- Intro -->
        <div class="mb-16 max-w-4xl">
          <h2 class="text-2xl font-semibold text-orinoco-darker mb-4">
            Publicaciones académicas
          </h2>
          <p class="text-gray-600 leading-relaxed">
            En esta sección se presentan artículos científicos publicados en
            revistas académicas, resultado de procesos de investigación,
            reflexión teórica y análisis crítico, con impacto en contextos
            educativos y sociales.
          </p>
        </div>

        <!-- LISTADO -->
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
          <article
            v-for="article in articles"
            :key="article.id"
            class="group rounded-2xl border border-orinoco-border bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
          >
            <!-- Header -->
            <div class="mb-4 flex items-start justify-between">
              <span
                class="inline-flex items-center rounded-full bg-orinoco-light px-3 py-1 text-xs font-medium text-orinoco-primary"
              >
                {{ article.year }}
              </span>

              <FileText class="h-5 w-5 text-orinoco-primary" />
            </div>

            <!-- Title -->
            <h3 class="mb-3 text-lg font-semibold text-orinoco-darker leading-snug">
              {{ article.title }}
            </h3>

            <!-- Meta -->
            <p class="mb-4 text-sm text-gray-600">
              {{ article.journal }}
            </p>

            <!-- Actions -->
            <div class="mt-auto flex items-center justify-between pt-4">
              <a
                :href="article.pdf"
                target="_blank"
                class="text-sm font-semibold text-orinoco-primary transition hover:underline"
              >
                Ver PDF
              </a>

              <span class="text-xs text-gray-500">
                {{ article.type }}
              </span>
            </div>
          </article>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>


