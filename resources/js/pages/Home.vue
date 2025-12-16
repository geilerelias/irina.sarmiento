<script lang="ts" setup>
import HomeBanner from '@/../images/bg/bg-home-2.png';
import FaqSection from '@/components/Sections/FaqSection.vue';
import NewsletterSection from '@/components/Sections/NewsletterSection.vue';
import ServicesSection from '@/components/Sections/ServicesSection.vue';
import StatisticsSection from '@/components/Sections/StatisticsSection.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';

import { Globe, GraduationCap, Users } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref } from 'vue';

const valores = [
    {
        icon: Users,
        title: 'Compromiso Comunitario',
        desc: 'Trabajo desde y para las comunidades, fortaleciendo procesos educativos con enfoque social y territorial.',
    },
    {
        icon: GraduationCap,
        title: 'Excelencia Educativa',
        desc: 'Promuevo prácticas pedagógicas reflexivas, planificadas y orientadas a la mejora continua.',
    },
    {
        icon: Globe,
        title: 'Respeto por la Diversidad',
        desc: 'Reconozco la interculturalidad, la identidad y el saber propio como pilares del aprendizaje.',
    },
];

const scrolled = ref<boolean>(false);
ref<boolean>(false);

const handleScroll = (): void => {
    scrolled.value = window.scrollY > 50;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

const scrollToSection = (sectionId: string): void => {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
        });
    }
};
</script>

<template>
    <GuestLayout>
        <!-- Hero Section | Irina Esther Sarmiento Guerra -->
        <section
            class="from-orinoco-rose/10 via-orinoco-secondary-light/30 text-orinoco-text relative h-screen overflow-hidden bg-gradient-to-br to-orinoco-primary/90"
        >
            <!-- Fondo -->
            <div class="absolute inset-0">
                <img
                    :src="HomeBanner"
                    alt="Educación y comunidad"
                    class="h-full w-full object-cover opacity-40"
                />
            </div>

            <!-- Contenido -->
            <div
                class="relative mx-auto flex h-full max-w-7xl items-center px-6 pt-32 pb-24 sm:px-8 lg:px-12"
            >
                <div class="grid items-center gap-14 lg:grid-cols-2">
                    <!-- Texto -->
                    <div>
                        <!-- Badge -->
                        <div class="mb-4">
                            <span
                                class="inline-block rounded-full bg-orinoco-accent/90 px-5 py-2 text-sm font-semibold tracking-wide text-orinoco-dark"
                            >
                                Educación · Comunidad · Etnoeducación
                            </span>
                        </div>

                        <!-- Título -->
                        <h1
                            class="mb-4 text-3xl font-bold sm:text-4xl lg:text-5xl"
                        >
                            Irina Esther<br />
                            <span class="font-poppins text-orinoco-primary">
                                Sarmiento Guerra
                            </span>
                        </h1>

                        <!-- Subtítulo -->
                        <p
                            class="text-orinoco-text-muted mb-8 max-w-md text-lg leading-relaxed"
                        >
                            Docente · Magíster en Educación · Psicóloga Social
                            Comunitaria.<br />
                            Comprometida con la formación integral, el
                            desarrollo humano y la transformación social desde
                            los territorios.
                        </p>

                        <!-- CTA -->
                        <div class="flex flex-wrap gap-4">
                            <button
                                @click="scrollToSection('perfil')"
                                class="hover:bg-orinoco-primary-dark rounded-full bg-orinoco-primary px-8 py-3 font-semibold text-white shadow-md transition-all hover:scale-105"
                            >
                                Acerca de mi
                            </button>

                            <button
                                @click="scrollToSection('contact')"
                                class="rounded-full border-2 border-orinoco-primary px-8 py-3 font-semibold text-orinoco-primary transition-all hover:bg-orinoco-primary hover:text-white"
                            >
                                Contacto Académico
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 💎 VALORES -->
        <section class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-6 text-center" data-aos="fade-up">
                <h2 class="text-orinoco-darker mb-12 text-4xl font-bold">
                    Valores que orientan mi labor
                </h2>

                <div class="grid gap-10 md:grid-cols-3">
                    <div
                        v-for="(valor, i) in valores"
                        :key="i"
                        class="rounded-2xl bg-orinoco-light p-8 shadow-lg transition hover:-translate-y-2"
                    >
                        <!-- ICONO LUCIDE -->
                        <component
                            :is="valor.icon"
                            class="mx-auto mb-4 h-12 w-12 text-orinoco-primary"
                            stroke-width="1.8"
                        />

                        <h3 class="mb-2 text-2xl font-semibold">
                            {{ valor.title }}
                        </h3>

                        <p class="leading-relaxed text-gray-600">
                            {{ valor.desc }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sections -->

        <ServicesSection id="services" class="bg-white" />
        <StatisticsSection />
        <FaqSection />
        <NewsletterSection />
    </GuestLayout>
</template>

<style scoped>
.energy-glow {
    box-shadow: 0 0 20px rgba(139, 195, 74, 0.3);
}

@keyframes scaleIn {
    0% {
        transform: scale(0.85);
        opacity: 0;
    }

    60% {
        transform: scale(1.03);
        opacity: 1;
    }

    100% {
        transform: scale(1);
    }
}

.animate-scaleIn {
    animation: scaleIn 0.5s ease-out;
}
</style>
