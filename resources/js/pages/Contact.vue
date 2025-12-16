<script setup lang="ts">
import HomeImage from '@/../images/bg/bg-cultural.jpg';
import FormContactSection from '@/components/Sections/FormContactSection.vue';
import NewsletterSection from '@/components/Sections/NewsletterSection.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Mail } from 'lucide-vue-next';
const socials = [
    {
        icon: ['fab', 'facebook-f'],
        href: '#',
        name: 'Facebook',
    },
    {
        icon: ['fab', 'linkedin-in'],
        href: '#',
        name: 'LinkedIn',
    },
    {
        icon: ['fab', 'instagram'],
        href: '#',
        name: 'Instagram',
    },
];

const scrollToForm = () => {
    const formElement = document.querySelector('form');
    if (formElement) {
        formElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
};
</script>

<template>
    <GuestLayout>
        <section class="relative mt-10 overflow-hidden bg-orinoco-light py-28">
            <!-- Fondo decorativo -->
            <div class="absolute inset-0">
                <img
                    :src="HomeImage"
                    alt="Contacto académico"
                    class="h-full w-full object-cover opacity-10"
                />
            </div>

            <!-- Elementos suaves decorativos -->
            <div
                class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-orinoco-accent/20 blur-3xl"
            ></div>
            <div
                class="absolute right-0 bottom-0 h-80 w-80 rounded-full bg-orinoco-blue/20 blur-3xl"
            ></div>

            <!-- Contenido -->
            <div class="relative mx-auto max-w-7xl px-6 text-center">
                <Mail class="mx-auto mb-6 h-14 w-14 text-orinoco-primary" />

                <h1 class="text-orinoco-darker mb-4 text-4xl font-bold">
                    Contacto Académico
                </h1>

                <p
                    class="mx-auto max-w-3xl text-lg leading-relaxed text-gray-700"
                >
                    Este espacio está destinado a establecer comunicación para
                    fines académicos, institucionales y de colaboración
                    educativa.
                </p>

                <p class="mt-4 text-sm text-gray-600">
                    Para consultas relacionadas con investigación, docencia o
                    proyectos formativos.
                </p>
            </div>
        </section>

        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2">
                <!-- FORMULARIO -->
                <div data-aos="fade-right">
                    <FormContactSection id="form" />
                </div>

                <!-- INFORMACIÓN PROFESIONAL -->
                <div data-aos="fade-left" class="space-y-10">
                    <h3 class="font-heading mb-6 text-2xl font-semibold">
                        Información de Contacto
                    </h3>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div
                                class="mr-4 flex h-12 w-12 items-center justify-center rounded-lg bg-orinoco-primary"
                            >
                                <font-awesome-icon
                                    icon="fa-user-graduate"
                                    class="text-xl text-white"
                                />
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">
                                    Perfil profesional
                                </p>
                                <p
                                    class="text-lg font-semibold text-orinoco-dark"
                                >
                                    Docente · Psicóloga Social Comunitaria
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="mr-4 flex h-12 w-12 items-center justify-center rounded-lg bg-orinoco-primary"
                            >
                                <font-awesome-icon
                                    icon="fa-school"
                                    class="text-xl text-white"
                                />
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Institución</p>
                                <p
                                    class="text-lg font-semibold text-orinoco-dark"
                                >
                                    Institución Etnoeducativa Sierra Nevada
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="mr-4 flex h-12 w-12 items-center justify-center rounded-lg bg-orinoco-primary"
                            >
                                <font-awesome-icon
                                    icon="fa-envelope"
                                    class="text-xl text-white"
                                />
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">
                                    Correo electrónico
                                </p>
                                <p
                                    class="text-lg font-semibold text-orinoco-dark"
                                >
                                    informacion@dominioeducativo.com
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="mr-4 flex h-12 w-12 items-center justify-center rounded-lg bg-orinoco-primary"
                            >
                                <font-awesome-icon
                                    icon="fa-map-marker-alt"
                                    class="text-xl text-white"
                                />
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Ubicación</p>
                                <p
                                    class="text-lg font-semibold text-orinoco-dark"
                                >
                                    Riohacha, La Guajira – Colombia
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- HORARIO -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4
                            class="font-heading mb-3 text-lg font-semibold text-orinoco-dark"
                        >
                            Disponibilidad
                        </h4>
                        <p class="text-gray-700">
                            Atención académica y comunitaria previa solicitud.
                        </p>
                    </div>

                    <!-- REDES -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4
                            class="font-heading mb-4 text-lg font-semibold text-orinoco-dark"
                        >
                            Redes profesionales
                        </h4>

                        <div class="flex space-x-4">
                            <a
                                v-for="s in socials"
                                :key="s.name"
                                :href="s.href"
                                target="_blank"
                                rel="noopener"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 transition-transform hover:-translate-y-1 hover:scale-110"
                                :aria-label="s.name"
                            >
                                <font-awesome-icon
                                    :icon="s.icon"
                                    class="text-xl text-orinoco-primary"
                                />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAPA -->
            <div id="maps" class="mt-20" data-aos="fade-up">
                <iframe
                    class="h-96 w-full rounded-2xl shadow-lg"
                    src="https://www.google.com/maps?q=Riohacha,La+Guajira&output=embed"
                    loading="lazy"
                ></iframe>
            </div>
        </div>

        <NewsletterSection />
    </GuestLayout>
</template>
