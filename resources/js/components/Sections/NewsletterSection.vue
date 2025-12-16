<template>
    <section
        class="to-orinoco-rose/80 bg-gradient-to-br from-orinoco-primary/90 via-orinoco-secondary/90 py-24 text-white"
    >
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <!-- Icono -->
            <div class="mb-8 flex justify-center">
                <div
                    class="flex h-20 w-20 items-center justify-center rounded-full bg-orinoco-accent/90 shadow-lg"
                >
                    <Mail class="text-orinoco-darker h-9 w-9" />
                </div>
            </div>

            <!-- Título -->
            <h2 class="mb-4 text-4xl font-bold tracking-tight">
                Mantente en contacto
            </h2>

            <!-- Descripción -->
            <p class="mx-auto mb-10 max-w-2xl text-lg text-orinoco-light/90">
                Recibe información académica, reflexiones pedagógicas y
                experiencias en educación, comunidad y etnoeducación.
            </p>

            <!-- Formulario -->
            <form
                @submit.prevent="subscribe"
                class="mx-auto flex max-w-md flex-col gap-4 sm:flex-row"
            >
                <input
                    v-model="email"
                    type="email"
                    placeholder="Tu correo electrónico"
                    required
                    class="placeholder:text-orinoco-text-muted flex-1 rounded-full bg-white px-6 py-3 text-orinoco-primary focus:ring-4 focus:ring-orinoco-accent/50 focus:outline-none"
                />

                <button
                    type="submit"
                    :disabled="loading"
                    class="text-orinoco-darker hover:bg-orinoco-accent-light cursor-pointer rounded-full bg-orinoco-accent px-8 py-3 font-semibold transition-all duration-300 hover:scale-105 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    {{ loading ? 'Registrando…' : 'Suscribirme' }}
                </button>
            </form>
        </div>
    </section>
</template>

<script setup lang="ts">
import axios from 'axios';
import { Mail } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const email = ref<string>('');
const loading = ref<boolean>(false);

const subscribe = async (): Promise<void> => {
    if (!email.value) return;

    loading.value = true;

    try {
        const { data } = await axios.post('/newsletter', {
            email: email.value,
        });

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: data.message || 'Registro exitoso',
            showConfirmButton: false,
            timer: 3000,
            background: '#3d3d3d',
            color: '#ffffff',
        });

        email.value = '';
    } catch (error: any) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title:
                error.response?.data?.message ||
                'No fue posible completar el registro.',
            showConfirmButton: false,
            timer: 3500,
            background: '#3d3d3d',
            color: '#ffffff',
        });
    } finally {
        loading.value = false;
    }
};
</script>
