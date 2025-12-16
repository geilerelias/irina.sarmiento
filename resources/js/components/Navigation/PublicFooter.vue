<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { useNavigationStore } from '@/stores/usePublicNavigationStore';
import { Link } from '@inertiajs/vue3';
import { Mail, MapPin } from 'lucide-vue-next';

const navigation = useNavigationStore();
const currentYear = new Date().getFullYear();

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
</script>

<template>
    <!--Llamado a la acción-->
    <section class="py-16 text-center" data-aos="fade-up">
        <h2 class="font-heading mb-4 text-3xl font-bold">
            ¿Desea establecer contacto académico o institucional?
        </h2>
        <p class="font-body mb-6">
            Educación con sentido humano, identidad cultural y compromiso
            comunitario.
        </p>
        <Link
            href="/contact"
            class="rounded-full bg-orinoco-primary px-6 py-3 font-semibold text-white shadow-lg transition-transform hover:scale-105"
        >
            Contactar
        </Link>
    </section>

    <footer
        class="via-orinoco-secondary-light/40 to-orinoco-rose/30 text-orinoco-text relative overflow-hidden bg-gradient-to-br from-orinoco-light pt-10 pb-12"
    >
        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-12 px-6 sm:px-8 md:grid-cols-3 lg:grid-cols-4"
        >
            <!-- Identidad -->
            <div>
                <AppLogoIcon class="h-24 w-auto" :withLetter="true" />
                <p class="text-orinoco-text-muted mt-1 text-sm leading-relaxed">
                    <span class="">
                        Irina Esther Sarmiento Guerra 
                    </span >
                    <br />
                    Docente · Magíster en Educación <br />
                    Psicóloga Social Comunitaria
                </p>
            </div>

            <!-- Navegación extraída del store -->
            <div>
                <h3
                    class="rounded-2xl text-lg font-semibold text-orinoco-primary"
                >
                    Navegación
                </h3>
                <div class="mb-4 flex space-x-2 pb-0.5">
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-primary"
                    ></span>
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-blue"
                    ></span>
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-accent"
                    ></span>
                </div>

                <ul class="grid grid-cols-2 gap-x-6 gap-y-2">
                    <li
                        v-for="link in navigation.links"
                        :key="link.href"
                        class="flex items-center space-x-2"
                    >
                        <component
                            :is="link.icon"
                            class="h-5 w-5 text-orinoco-accent"
                        />
                        <Link
                            :href="link.href"
                            class="transition-colors duration-200 hover:text-primary"
                        >
                            {{ link.title }}
                        </Link>
                    </li>
                </ul>
            </div>

            <!-- Contacto -->
            <div>
                <h3 class="text-lg font-semibold text-orinoco-primary">
                    Contacto
                </h3>
                <div class="mb-4 flex space-x-2 pb-0.5">
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-primary"
                    ></span>
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-blue"
                    ></span>
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-accent"
                    ></span>
                </div>
                <ul class="space-y-2 text-sm text-gray-300">
                    <!-- Dirección (abre Google Maps) -->
                    <li class="group flex items-center space-x-2">
                        <a
                            href="https://www.google.com/maps?q=Villavicencio+Meta,+Colombia"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center space-x-2 text-black transition-colors duration-300 hover:text-primary"
                        >
                            <MapPin
                                class="h-5 w-5 text-orinoco-accent transition-transform duration-300 group-hover:scale-110"
                            />
                            <span>Riohacha, La Guajira, Colombia</span>
                        </a>
                    </li>

                    <!-- Correo (abre app de correo) -->
                    <li class="group flex items-center space-x-2">
                        <a
                            href="mailto:irinasarmiento@ecorinocosas.com"
                            class="flex items-center space-x-2 text-black transition-colors duration-300 hover:text-primary"
                        >
                            <Mail
                                class="h-5 w-5 text-orinoco-accent transition-transform duration-300 group-hover:scale-110"
                            />
                            <span>irinasarmiento@ecorinocosas.com</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Redes -->
            <div>
                <h3 class="text-lg font-semibold text-orinoco-primary">
                    Redes
                </h3>
                <div class="mb-4 flex space-x-2 pb-0.5">
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-primary"
                    ></span>
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-blue"
                    ></span>
                    <span
                        class="block h-[2px] w-4 rounded bg-orinoco-accent"
                    ></span>
                </div>
                <div class="mt-4 flex space-x-4">
                    <a
                        v-for="s in socials"
                        :key="s.name"
                        :href="s.href"
                        target="_blank"
                        rel="noopener"
                        class="flex h-10 w-10 transform items-center justify-center rounded-full bg-orinoco-accent/10 transition-transform hover:-translate-y-1 hover:scale-110 hover:bg-white/20"
                    >
                        <font-awesome-icon
                            :icon="s.icon"
                            class="text-lg text-orinoco-accent"
                        />
                    </a>
                </div>
            </div>
        </div>

        <!-- Línea inferior -->
        <div
            class="border-orinoco-border text-orinoco-text-muted mt-12 border-t pt-6 text-center text-sm"
        >
            © {{ currentYear }} Irina Esther Sarmiento Guerra.<br />
            <span class="text-xs"> Educación · Comunidad · Etnoeducación </span>
        </div>
    </footer>
</template>
