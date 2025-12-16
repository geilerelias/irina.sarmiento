<template>
    <div class="min-h-screen overflow-x-hidden bg-gray-50" >
        <!-- Navigation reutilizable -->
        <PublicNav :scrolled="scrolled" @toggle-mobile-menu="toggleMobileMenu" :mobile-menu-open="mobileMenuOpen" />
        <PublicDrawer :scrolled="scrolled" :mobile-menu-open="mobileMenuOpen" @close-drawer="toggleMobileMenu" />
        <!-- Page Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <PublicFooter />
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

import PublicNav from '@/components/Navigation/PublicNav.vue';
import PublicDrawer from '@/components/Navigation/PublicDrawer.vue';
import PublicFooter from '@/components/Navigation/PublicFooter.vue';

const scrolled = ref<boolean>(false);
const mobileMenuOpen = ref<boolean>(false);

const toggleMobileMenu = (): void => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};

const handleScroll = (): void => {
    scrolled.value = window.scrollY > 50;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>
