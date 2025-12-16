<template>
    <section id="servicios" class="bg-orinoco-light py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Encabezado -->
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-4xl font-bold text-orinoco-darker">
                    Áreas de Servicio
                </h2>
                <p class="mx-auto max-w-3xl text-lg text-orinoco-text-muted">
                    Líneas de acompañamiento educativo, comunitario y psicosocial
                    desde un enfoque humano e intercultural.
                </p>
            </div>

            <!-- Grid -->
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="service in store.services"
                    :key="service.id"
                    class="group cursor-pointer rounded-2xl border border-orinoco-border bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                    @click="openModal(service)"
                >
                    <!-- Icono -->
                    <div
                        class="mb-6 flex h-16 w-16 items-center justify-center rounded-xl bg-orinoco-accent/20 text-orinoco-accent transition group-hover:scale-110"
                    >
                        <component
                            :is="icons[service.icon]"
                            class="h-8 w-8"
                        />
                    </div>

                    <!-- Texto -->
                    <h3 class="mb-3 text-xl font-semibold text-orinoco-darker">
                        {{ service.titulo }}
                    </h3>
                    <p class="text-sm leading-relaxed text-orinoco-text-muted">
                        {{ service.descripcion }}
                    </p>

                    <span
                        class="mt-5 inline-block text-sm font-medium text-orinoco-accent"
                    >
                        Ver más →
                    </span>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <Transition name="fade">
            <div
                v-if="selected"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            >
                <div
                    class="w-full max-w-lg rounded-2xl bg-white p-8 shadow-2xl"
                >
                    <div class="mb-6 flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-orinoco-accent/20 text-orinoco-accent"
                        >
                            <component
                                :is="icons[selected.icon]"
                                class="h-6 w-6"
                            />
                        </div>
                        <h3 class="text-2xl font-semibold text-orinoco-darker">
                            {{ selected.titulo }}
                        </h3>
                    </div>

                    <p class="mb-6 text-orinoco-text-muted">
                        {{ selected.descripcion }}
                    </p>

                    <ul class="mb-8 space-y-2 text-sm text-orinoco-text">
                        <li
                            v-for="(item, i) in selected.detalle"
                            :key="i"
                            class="flex items-start gap-2"
                        >
                            <span class="mt-1 h-1.5 w-1.5 rounded-full bg-orinoco-accent"></span>
                            <span>{{ item }}</span>
                        </li>
                    </ul>

                    <div class="text-right">
                        <button
                            class="rounded-full bg-orinoco-accent px-6 py-2 text-sm font-semibold text-white transition hover:bg-orinoco-accent-dark"
                            @click="closeModal"
                        >
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useServicesStore } from '@/stores/useServicesStore'
import {
    GraduationCap,
    Globe,
    Users,
    ClipboardList,
    Search,
    HeartHandshake
} from 'lucide-vue-next'

const store = useServicesStore()

const icons: Record<string, any> = {
    GraduationCap,
    Globe,
    Users,
    ClipboardList,
    Search,
    HeartHandshake
}

const selected = ref<any>(null)

const openModal = (service: any) => {
    selected.value = service
}

const closeModal = () => {
    selected.value = null
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
