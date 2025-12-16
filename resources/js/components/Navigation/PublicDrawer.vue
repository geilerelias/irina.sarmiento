<script setup lang="ts">
import HomeImage from '@/../images/bg/bg-home-2.png';
import AppLogoIcon from '@/components/AppLogoIcon.vue';

import { useNavigationStore } from '@/stores/usePublicNavigationStore';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const navigation = useNavigationStore();
const page = usePage();

const drawerOpen = computed(() => navigation.drawerOpen);
const closeDrawer = () => navigation.closeDrawer();
const currentYear = new Date().getFullYear();

// Detectar enlace activo
const isActive = (href: string) => {
    if (page.url === href) return true;
    return page.url.startsWith(href + '/');
};

const socials = [
    {
        name: 'Facebook',
        href: 'https://facebook.com',
        icon: ['fab', 'facebook-f'],
    },
    {
        name: 'LinkedIn',
        href: 'https://linkedin.com',
        icon: ['fab', 'linkedin-in'],
    },
    {
        name: 'Instagram',
        href: 'https://instagram.com',
        icon: ['fab', 'instagram'],
    },
];
</script>

<template>
    <transition name="slide-fade">
        <div v-if="drawerOpen" class="fixed inset-0 z-50 flex">
            <!-- Fondo semitransparente -->
            <div
                class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                @click="closeDrawer"
            ></div>

            <!-- Drawer principal -->
            <div
                class="relative ml-auto flex h-full w-72 flex-col overflow-hidden bg-white shadow-2xl sm:w-80"
                @click.stop
            >
                <!-- Imagen de encabezado -->
                <div class="relative h-44 w-full overflow-hidden">
                    <img
                        :src="HomeImage"
                        alt="Irina Sarmiento"
                        class="h-full w-full object-cover"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-orinoco-dark/90 via-orinoco-secondary/70 to-transparent"
                    ></div>

                    <div class="absolute bottom-1 left-4 text-white">
                        <AppLogoIcon
                            class="h-22 w-auto"
                            :withLetter="true"
                            :white="true"
                        />
                    </div>
                </div>

                <!-- Contenido del menú -->
                <nav
                    class="flex-1 overflow-y-auto bg-gradient-to-b from-white via-[#F9FAFB] to-[#F0FDF4] px-5 py-6"
                >
                    <h2
                        class="mb-4 text-sm font-semibold tracking-wide text-orinoco-dark uppercase"
                    >
                        Navegación
                    </h2>
                    <ul class="space-y-2">
                        <li
                            v-for="link in navigation.links"
                            :key="link.href"
                            class="relative"
                        >
                            <!-- LINK PADRE -->
                            <Link
                                :href="link.href"
                                @click="closeDrawer"
                                :class="[
                                    'group flex items-center justify-between rounded-md px-3 py-2.5 text-sm font-medium transition-all duration-200',
                                    isActive(link.href)
                                        ? 'border-l-4 border-orinoco-primary bg-[#2F9E44]/10 text-orinoco-primary'
                                        : 'text-orinoco-dark hover:bg-[#2F9E44]/10 hover:text-orinoco-primary',
                                ]"
                            >
                                <div class="flex items-center gap-3">
                                    <component
                                        v-if="link.icon"
                                        :is="link.icon"
                                        class="h-4 w-4"
                                    />
                                    <span>{{ link.title }}</span>
                                </div>

                                <font-awesome-icon
                                    v-if="link.children"
                                    :icon="['fas', 'angle-down']"
                                    class="text-xs transition-transform duration-200"
                                    :class="{
                                        'rotate-180': isActive(link.href),
                                    }"
                                />
                            </Link>

                            <!-- SUBMENÚ -->
                            <ul
                                v-if="link.children && isActive(link.href)"
                                class="mt-1 space-y-1 pl-6"
                            >
                                <li
                                    v-for="child in link.children"
                                    :key="child.href"
                                >
                                    <Link
                                        :href="child.href"
                                        @click="closeDrawer"
                                        :class="[
                                            'flex items-center gap-3 rounded-md px-3 py-2 text-sm transition',
                                            page.url === child.href
                                                ? 'bg-orinoco-light font-medium text-orinoco-primary'
                                                : 'text-gray-600 hover:bg-orinoco-light hover:text-orinoco-primary',
                                        ]"
                                    >
                                        <component
                                            v-if="child.icon"
                                            :is="child.icon"
                                            class="h-4 w-4"
                                        />
                                        {{ child.title }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <Link
                            :href="navigation.admin.href"
                            @click="closeDrawer"
                            class="inline-flex w-full items-center justify-center rounded-md bg-orinoco-primary px-4 py-2.5 font-medium text-white transition-colors duration-200 hover:bg-orinoco-dark"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'user-shield']"
                                class="mr-2 text-sm"
                            />
                            {{ navigation.admin.title }}
                        </Link>
                    </div>
                </nav>

                <!-- Pie del drawer -->
                <div
                    class="bg-orinoco-darker flex items-center justify-between px-5 py-4 text-xs text-gray-200"
                >
                    <span>© {{ currentYear }} Irina Sarmiento Guerra</span>
                    <div class="flex space-x-3">
                        <a
                            v-for="icon in socials"
                            :key="icon.name"
                            :href="icon.href"
                            target="_blank"
                            rel="noopener"
                            class="transition hover:text-[#A3E635]"
                        >
                            <font-awesome-icon
                                :icon="icon.icon"
                                class="text-sm"
                            />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.35s ease-in-out;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
}
</style>
