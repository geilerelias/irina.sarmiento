<script setup lang="ts">
import HomeImage from '@/../images/bg/bg-academia.jpg';
import AcademicCard from '@/components/AcademicCard.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { useNavigationStore } from '@/stores/usePublicNavigationStore';
import { computed } from 'vue';

const navigation = useNavigationStore();

const academicProductionChildren = computed(() => {
    return (
        navigation.links.find((link) => link.href === '/academic-production')
            ?.children ?? []
    );
});
</script>

<template>
    <GuestLayout>
        <!-- HERO -->
        <section class="relative h-[70vh] overflow-hidden">
            <!-- Imagen -->
            <img
                :src="HomeImage"
                alt="Academic background"
                class="absolute inset-0 h-full w-full object-cover object-top"
            />

            <!-- Overlay -->
            <div class="absolute inset-0 bg-orinoco-dark/70"></div>

            <!-- Contenido -->
            <div
                class="relative z-10 mx-auto flex h-full max-w-7xl items-center px-6"
            >
                <div class="max-w-2xl text-white">
                    <p
                        class="text-orinoco-darker mb-3 inline-block rounded-full bg-orinoco-accent px-4 py-1 text-sm font-semibold"
                    >
                        Perfil académico
                    </p>

                    <h1
                        class="mb-6 text-4xl leading-tight font-bold md:text-5xl"
                    >
                        Academia y Producción Intelectual
                    </h1>

                    <p class="text-lg text-white/90">
                        Publicaciones, investigaciones, evaluaciones y procesos
                        formativos desarrollados desde la psicología social
                        comunitaria y la educación.
                    </p>
                </div>
            </div>
        </section>

        <!-- INTRO -->
        <section class="bg-white py-20">
            <div class="mx-auto max-w-4xl px-6 text-center">
                <h2 class="text-orinoco-darker mb-6 text-3xl font-bold">
                    Producción Académica
                </h2>

                <p class="text-lg leading-relaxed text-gray-600">
                    Este espacio reúne el trabajo académico desarrollado a lo
                    largo de la trayectoria profesional, articulando
                    investigación, docencia, evaluación y construcción de
                    conocimiento con enfoque comunitario y etnoeducativo.
                </p>
            </div>
        </section>

        <!-- CATEGORÍAS -->
        <section class="bg-orinoco-light py-24">
            <div class="mx-auto max-w-7xl px-6">
                <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    <AcademicCard
                        v-for="section in academicProductionChildren"
                        :key="section.href"
                        :href="section.href"
                        :title="section.title"
                        :description="section.description"
                        :route="section.href"
                        gradient="from-orinoco-primary to-orinoco-accent"
                        :icon="section.icon"
                    />
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
