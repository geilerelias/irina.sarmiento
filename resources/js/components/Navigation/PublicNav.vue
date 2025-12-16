<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { useNavigationStore } from '@/stores/usePublicNavigationStore';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

const props = defineProps({ scrolled: Boolean });
const navigation = useNavigationStore();
const page = usePage();

// Detecta ruta activa incluyendo hijas
const isActive = (href: string) => {
    return page.url === href || page.url.startsWith(href + '/');
};

// Detecta si estás en la home
const isHome = computed(() => page.url === '/');

// Breadcrumb dinámico
const breadcrumb = computed(() => {
    const parts = page.url.split('/').filter(Boolean);
    if (parts.length === 0) return [{ name: 'Inicio', href: '/' }];

    const crumbs = [{ name: 'Inicio', href: '/' }];
    let path = '';

    parts.forEach((part) => {
        path += `/${part}`;
        crumbs.push({
            name: part
                .replace(/-/g, ' ')
                .replace(/\b\w/g, (l) => l.toUpperCase()),
            href: path,
        });
    });

    return crumbs;
});

// Clases de enlaces adaptadas a modo oscuro
const navLinkClass = computed(() => {
    const s = props.scrolled || !isHome.value;
    return s
        ? 'relative text-orinoco-primary hover:text-orinoco-accent dark:text-gray-200 dark:hover:text-white px-3 py-2 text-sm md:text-lg font-medium transition'
        : 'relative text-white hover:text-green-200 dark:text-gray-100 dark:hover:text-gray-300 px-3 py-2 text-sm md:text-lg font-medium transition';
});

// Estado del tema
const darkMode = ref(false);

// Recuperar tema guardado
onMounted(() => {
    if (localStorage.getItem('theme') === 'dark') {
        darkMode.value = true;
        document.documentElement.classList.add('dark');
    }
});

// Alternar tema + guardar preferencia
const toggleTheme = () => {
    darkMode.value = !darkMode.value;
    document.documentElement.classList.toggle('dark', darkMode.value);
    localStorage.setItem('theme', darkMode.value ? 'dark' : 'light');
};

const routeLabels: Record<string, string> = {
    home: 'Inicio',
    about: 'Acerca de',
    contact: 'Contacto',
    academicproduction: 'Academia',
};

const getRouteText = (route: string) => {
    console.log('Route:', route);
    let value = route.toLowerCase().replace(/\s+/g, '');
    console.log('Label:', routeLabels);
    console.log('Value:', value);

    return routeLabels[value] ?? route;
};
</script>

<template>
    <nav
        class="header-banner my-0 bg-gradient-to-br px-4 py-2 text-white"
        :class="[
            'fixed top-0 z-50 w-full backdrop-blur-sm transition-all duration-300',
            scrolled || !isHome
                ? 'bg-white/95 shadow-lg dark:bg-gray-900/90 dark:text-gray-200'
                : 'bg-transparent dark:bg-transparent',
        ]"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <AppLogoIcon
                    class="h-15 w-auto transition"
                    :withLetter="true"
                    :white="!scrolled && isHome && !darkMode"
                />

                <!-- Desktop Navigation -->
                <div class="hidden items-center space-x-4 md:flex">
                    <template v-for="link in navigation.links" :key="link.href">
                        <ul class="flex items-center gap-6">
                            <li class="group relative">
                                <!-- LINK PRINCIPAL -->
                                <Link
                                    :href="link.href"
                                    :class="[navLinkClass, 'px-2 py-1 text-sm']"
                                >
                                    {{ link.title }}

                                    <!-- Indicador activo -->
                                    <div
                                        v-if="isActive(link.href)"
                                        class="absolute right-0 -bottom-[2px] left-0 flex justify-center gap-[2px]"
                                    >
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
                                </Link>
                                <!-- SUBMENÚ -->
                                <ul
                                    v-if="link.children"
                                    class="invisible absolute top-full left-1/2 z-50 mt-4 w-72 -translate-x-1/2 border border-gray-100 bg-white/95 opacity-0 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] backdrop-blur-lg transition-all duration-300 group-hover:visible group-hover:translate-y-1 group-hover:opacity-100"
                                >
                                    <li
                                        v-for="child in link.children"
                                        :key="child.href"
                                    >
                                        <Link
                                            :href="child.href"
                                            :class="[
                                                'relative flex items-center gap-3 px-5 py-3 text-sm transition',
                                                isActive(child.href)
                                                    ? 'bg-orinoco-light font-semibold text-orinoco-primary'
                                                    : 'text-gray-700 hover:bg-orinoco-light hover:text-orinoco-primary',
                                            ]"
                                        >
                                            <component
                                                :is="child.icon"
                                                class="h-4 w-4"
                                                :class="
                                                    isActive(child.href)
                                                        ? 'text-orinoco-primary'
                                                        : 'text-gray-400'
                                                "
                                            />

                                            {{ child.title }}

                                            <!-- Barra activa -->
                                            <span
                                                v-if="isActive(child.href)"
                                                class="absolute top-0 left-0 h-full w-1 rounded-r bg-orinoco-primary"
                                            ></span>
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </template>

                    <Link
                        :href="navigation.admin.href"
                        class="flex items-center rounded-md bg-orinoco-accent px-3 py-1.5 text-sm font-medium text-orinoco-dark transition hover:bg-orinoco-primary hover:text-white dark:hover:bg-orinoco-accent dark:hover:text-orinoco-dark"
                    >
                        <font-awesome-icon
                            :icon="['fas', 'user-shield']"
                            class="mr-1 text-sm"
                        />
                        {{ navigation.admin.title }}
                    </Link>

                    <!-- Botón de cambio de tema -->
                    <!--                    <button
                                            @click="toggleTheme"
                                            class=" disabled rounded-md p-2 transition hover:bg-gray-200 dark:hover:bg-gray-800"
                                            :title="darkMode ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
                                        >
                                            <component
                                                :is="darkMode ? Sun : Moon"
                                                class="h-5 w-5 text-gray-700 dark:text-gray-200"
                                            />
                                        </button>-->
                </div>

                <!-- Mobile: Breadcrumb + Menu -->
                <div class="flex items-center gap-3 md:hidden">
                    <!-- Breadcrumb -->
                    <ol
                        v-if="breadcrumb.length > 1"
                        class="flex max-w-[70vw] flex-wrap items-center gap-1 overflow-hidden text-sm text-gray-600 dark:text-gray-300"
                    >
                        <li
                            v-for="(crumb, index) in breadcrumb"
                            :key="crumb.href"
                            class="flex items-center"
                        >
                            <Link
                                v-if="index !== breadcrumb.length - 1"
                                :href="crumb.href"
                                class="font-medium text-orinoco-primary hover:underline"
                            >
                                {{ crumb.name }}
                            </Link>

                            <span
                                v-else
                                class="font-semibold text-gray-800 dark:text-gray-100"
                            >
                                {{ getRouteText(crumb.name) }}
                            </span>

                            <span
                                v-if="index < breadcrumb.length - 1"
                                class="mx-1 text-gray-400"
                            >
                                /
                            </span>
                        </li>
                    </ol>

                    <!-- Botón menú -->
                    <button
                        @click="navigation.toggleDrawer"
                        class="p-2 transition"
                        :class="
                            scrolled || !isHome
                                ? 'text-gray-700 dark:text-gray-200'
                                : 'text-white'
                        "
                    >
                        <font-awesome-icon
                            :icon="['fas', 'bars']"
                            class="text-xl"
                        />
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.header-banner {
    border-radius: 0 0 40px 40px;
    width: 100%;
}
</style>
