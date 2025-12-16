<script setup lang="ts">
import ProfileImage from '@/../images/bg/bg-academia.jpg';
import ContactImage2 from '@/../images/bg/bg-cultural.jpg';
import HomeImage from '@/../images/bg/bg-home-2.png';
import ContactImage1 from '@/../images/bg/bg-sierranevada.jpg';
import GuestLayout from '@/layouts/GuestLayout.vue';

import { BookOpen, GraduationCap } from 'lucide-vue-next';
</script>

<template>
    <GuestLayout>
        <!-- 👩‍🏫 QUIÉN SOY -->
        <section
            id="perfil"
            class="text-orinoco-text relative overflow-hidden bg-white py-28"
        >
            <div class="relative mx-auto max-w-7xl px-6">
                <div class="grid items-center gap-16 md:grid-cols-2">
                    <!-- Texto -->
                    <div data-aos="fade-right">
                        <h2 class="text-orinoco-darker mb-6 text-4xl font-bold">
                            Acerca de mí
                        </h2>

                        <p
                            class="mb-5 text-justify text-lg leading-relaxed text-gray-700"
                        >
                            Soy <strong>Irina Esther Sarmiento Guerra</strong>,
                            Psicóloga Social Comunitaria, Especialista en
                            Planeación Educativa y Magíster en Educación, con
                            una trayectoria profesional orientada al
                            fortalecimiento de los procesos pedagógicos,
                            comunitarios y etnoeducativos.
                        </p>

                        <p
                            class="mb-5 text-justify text-lg leading-relaxed text-gray-700"
                        >
                            Nací en la ciudad de
                            <strong>Riohacha, La Guajira</strong>, territorio
                            que ha marcado profundamente mi visión del mundo, mi
                            compromiso con la educación y mi sensibilidad frente
                            a la diversidad cultural y social.
                        </p>

                        <p
                            class="text-justify text-lg leading-relaxed text-gray-700"
                        >
                            Desde el ejercicio docente, acompaño comunidades
                            educativas en la construcción de aprendizajes
                            significativos, promoviendo una educación humanista,
                            intercultural e inclusiva, que reconoce al
                            territorio, la identidad y la participación como
                            ejes fundamentales del desarrollo educativo.
                        </p>
                    </div>

                    <!-- Imagen -->
                    <div data-aos="fade-left" class="relative">
                        <img
                            :src="HomeImage"
                            alt="Irina Esther Sarmiento Guerra"
                            class="h-130 w-auto rounded-3xl object-cover shadow-xl"
                        />

                        <!-- Sello sutil -->
                        <div
                            class="absolute -bottom-6 -left-6 rounded-2xl bg-orinoco-light px-6 py-4 shadow-lg"
                        >
                            <p
                                class="text-sm font-semibold text-orinoco-primary"
                            >
                                Educación · Comunidad · Etnoeducación
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 🌱 CULTURA PEDAGÓGICA -->
        <section class="bg-orinoco-light py-24">
            <div
                class="mx-auto grid max-w-7xl items-center gap-16 px-6 md:grid-cols-2"
            >
                <!-- Imagen -->
                <div class="relative" data-aos="fade-right">
                    <img
                        :src="ProfileImage"
                        alt="Educación comunitaria"
                        class="w-full rounded-3xl object-cover shadow-2xl"
                    />
                    <div
                        class="absolute -top-6 -left-6 rounded-xl bg-orinoco-primary px-6 py-4 text-white shadow-lg"
                    >
                        <p class="text-4xl leading-none font-bold">18+</p>
                        <p
                            class="text-sm font-semibold tracking-wide uppercase"
                        >
                            Años de Experiencia Docente
                        </p>
                    </div>
                </div>

                <!-- Texto -->
                <div data-aos="fade-left">
                    <h2 class="text-orinoco-darker mb-6 text-4xl font-bold">
                        Mi Cultura Pedagógica
                    </h2>

                    <p class="mb-8 text-lg leading-relaxed text-gray-700">
                        Mi ejercicio profesional se fundamenta en una pedagogía
                        humanista, crítica y participativa, orientada al
                        fortalecimiento de las capacidades individuales y
                        colectivas.
                    </p>

                    <p class="mb-8 text-lg leading-relaxed text-gray-700">
                        Desde la planeación educativa y la etnoeducación,
                        acompaño procesos formativos que reconocen el contexto,
                        el territorio y la experiencia de vida como fuentes
                        legítimas de conocimiento.
                    </p>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="flex items-start gap-3">
                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-full bg-orinoco-primary text-white"
                            >
                                ✓
                            </span>
                            <p class="text-sm text-gray-700">
                                Planeación educativa con enfoque contextual.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-full bg-orinoco-primary text-white"
                            >
                                ✓
                            </span>
                            <p class="text-sm text-gray-700">
                                Educación intercultural y comunitaria.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-full bg-orinoco-primary text-white"
                            >
                                ✓
                            </span>
                            <p class="text-sm text-gray-700">
                                Acompañamiento pedagógico permanente.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-full bg-orinoco-primary text-white"
                            >
                                ✓
                            </span>
                            <p class="text-sm text-gray-700">
                                Formación integral con sentido social.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="studies" class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-6">
                <!-- Título -->
                <div class="mb-16 text-center">
                    <h2 class="text-orinoco-darker text-4xl font-bold">
                        Formación Académica
                    </h2>
                    <p class="mx-auto mt-4 max-w-3xl text-lg text-gray-600">
                        Trayectoria formativa orientada a la educación, la
                        psicología social comunitaria y la planeación educativa.
                    </p>
                </div>

                <!-- Grid -->
                <div class="grid gap-12 md:grid-cols-2">
                    <!-- Pregrado -->
                    <div
                        class="border-orinoco-border rounded-2xl border p-8 shadow-sm"
                    >
                        <div class="mb-6 flex items-center gap-3">
                            <GraduationCap
                                class="h-7 w-7 text-orinoco-primary"
                            />
                            <h3
                                class="text-orinoco-darker text-2xl font-semibold"
                            >
                                Pregrado
                            </h3>
                        </div>

                        <div class="space-y-4">
                            <p class="text-xl font-semibold text-gray-800">
                                Psicóloga Social Comunitaria
                            </p>

                            <p class="text-gray-600">
                                Universidad Nacional Abierta y a Distancia
                                (UNAD)
                            </p>

                            <p class="text-orinoco-text-muted text-sm">
                                Título obtenido el 14 de septiembre de 2001
                            </p>
                        </div>
                    </div>

                    <!-- Posgrados -->
                    <div
                        class="border-orinoco-border rounded-2xl border p-8 shadow-sm"
                    >
                        <div class="mb-6 flex items-center gap-3">
                            <BookOpen class="h-7 w-7 text-orinoco-primary" />
                            <h3
                                class="text-orinoco-darker text-2xl font-semibold"
                            >
                                Posgrados
                            </h3>
                        </div>

                        <div class="space-y-8">
                            <!-- Especialización -->
                            <div>
                                <p class="text-xl font-semibold text-gray-800">
                                    Especialista en Planeación Educativa
                                </p>
                                <p class="text-gray-600">
                                    Pontificia Universidad Javeriana
                                </p>
                                <p class="text-orinoco-text-muted text-sm">
                                    26 de octubre de 2004
                                </p>
                            </div>

                            <!-- Maestría -->
                            <div>
                                <p class="text-xl font-semibold text-gray-800">
                                    Magíster en Educación
                                </p>
                                <p class="text-gray-600">
                                    Universidad Tecnológica de Pereira
                                </p>
                                <p class="text-orinoco-text-muted text-sm">
                                    30 de noviembre de 2018
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACT CTA -->
        <section
            class="relative mx-4 my-12 mt-16 overflow-hidden rounded-3xl bg-gradient-to-r from-orinoco-primary via-orinoco-secondary to-orinoco-accent py-16 text-white shadow-2xl sm:py-20 md:mx-8 lg:mx-12 lg:py-24"
        >
            <!-- Fondos decorativos -->
            <div
                class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-orinoco-accent/20 blur-3xl"
            ></div>
            <div
                class="absolute top-0 right-0 h-64 w-64 rounded-full bg-white/10 blur-2xl"
            ></div>

            <div
                class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 sm:px-8 md:grid-cols-2"
            >
                <!-- Texto principal -->
                <div class="text-center md:text-left">
                    <h2
                        class="mb-4 text-[clamp(1.8rem,5vw,2.5rem)] leading-tight font-bold"
                    >
                        ¿Deseas establecer contacto?
                    </h2>

                    <p
                        class="mb-8 text-justify text-[clamp(1rem,2.5vw,1.125rem)] leading-relaxed text-white/90"
                    >
                        Estoy disponible para el diálogo académico, pedagógico y
                        comunitario. Puedes contactarme para procesos de
                        acompañamiento educativo, orientación pedagógica,
                        fortalecimiento institucional y proyectos con enfoque
                        social y etnoeducativo.
                    </p>

                    <div
                        class="flex flex-col items-center gap-6 sm:flex-row sm:justify-start sm:space-x-8"
                    >
                        <div class="text-center sm:text-left">
                            <p
                                class="text-sm font-semibold tracking-wide text-white/70 uppercase"
                            >
                                Correo Electrónico
                            </p>
                            <a
                                href="mailto:irina.sarmiento@wirelesslink.com.co"
                                class="hover:text-orinoco-accent-light text-xl font-bold break-all transition sm:text-2xl"
                            >
                                irina.sarmiento@wirelesslink.com.co
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tarjetas informativas -->
                <div class="grid gap-6 sm:grid-cols-2">
                    <div
                        class="overflow-hidden rounded-2xl bg-orinoco-light text-orinoco-dark shadow-lg transition-transform hover:-translate-y-2"
                    >
                        <img
                            :src="ContactImage1"
                            alt="Institución Educativa"
                            class="h-40 w-full object-cover sm:h-44"
                        />
                        <div class="p-4 sm:p-5">
                            <h3 class="mb-1 text-lg font-semibold">
                                Institución Educativa
                            </h3>
                            <p class="text-orinoco-text-muted text-sm">
                                Institución Etnoeducativa Sierra Nevada
                            </p>
                        </div>
                    </div>

                    <div
                        class="overflow-hidden rounded-2xl bg-orinoco-light text-orinoco-dark shadow-lg transition-transform hover:-translate-y-2"
                    >
                        <img
                            :src="ContactImage2"
                            alt="Territorio"
                            class="h-40 w-full object-cover sm:h-44"
                        />
                        <div class="p-4 sm:p-5">
                            <h3 class="mb-1 text-lg font-semibold">
                                Enfoque Territorial
                            </h3>
                            <p class="text-orinoco-text-muted text-sm">
                                Educación con impacto comunitario y enfoque
                                intercultural.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<style scoped></style>
