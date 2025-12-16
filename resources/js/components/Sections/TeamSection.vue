<script setup lang="ts">
import { ref } from 'vue';
import { Users } from 'lucide-vue-next'

import henry from '@/../images/team/henry.png';
import diego from '@/../images/team/diego.png';
import geiler from '@/../images/team/geiler.png';
import arpidio from '@/../images/team/arpidio.png';

const team = ref([
    {
        img: diego,
        name: 'DIEGO DÁVILA',
        role: 'CEO & FUNDADOR',
        occupation: 'Ingeniero electrónico',
        perfil: 'Ingeniero electrónico con especialización en alta gerencia y formación en transformación digital y energías renovables. Con más de 12 años de experiencia, combina liderazgo técnico y gestión estratégica para el desarrollo de proyectos de alta calidad.',
    },
    {
        img: henry,
        name: 'JHON VÉLEZ',
        role: 'Obras Civiles',
        occupation: 'Ingeniero Civil',
        perfil: 'Ingeniero civil con más de 10 años de experiencia en diseño, planeación y mantenimiento de proyectos de infraestructura. Especialista en la gestión de obras civiles sostenibles y en la integración de soluciones tecnológicas para el desarrollo urbano y rural.',
    },
    {
        img: arpidio,
        name: 'ARPIDIO GOYENECHE',
        role: 'Técnico Fotovoltaico',
        occupation: 'Técnico en Energías Renovables',
        perfil: 'Llanero residenciado en Villavicencio (Meta), técnico certificado en energías renovables con formación en manejo, diseño y operación de sistemas fotovoltaicos. Acreditado por la Superintendencia de Industria y Comercio para la conversión de automotores a 100 % eléctricos. Con amplia experiencia en maquinaria amarilla para obras civiles y en la elaboración de pozos para piscicultura.',
    },

    {
        img: geiler,
        name: 'Geiler Radillo',
        role: 'Desarrollo Web',
        occupation: 'Ingeniero de sistemas',
        perfil:
            'Ingeniero de sistemas con énfasis en desarrollo de software y programación. Posee sólidos conocimientos en metodologías ágiles y buenas prácticas de ingeniería, con más de 5 años de experiencia liderando proyectos de software y transformación digital.',
    },
]);
</script>

<template>
    <section id="team" class="relative overflow-hidden bg-white py-24">
        <!-- Encabezado -->
        <div class="mb-16 text-center" data-aos="fade-up">
            <div
                class="mb-4 inline-flex items-center justify-center rounded-full bg-lime-500/10 p-3"
            >
                <Users class="w-6 h-6 text-orinoco-accent" />
            </div>
            <h2 class="mb-3 text-4xl font-extrabold text-orinoco-dark">
                Nuestro Equipo
            </h2>
            <p class="mx-auto max-w-3xl leading-relaxed text-gray-600">
                Contamos con profesionales apasionados y altamente capacitados
                en distintas disciplinas. Cada miembro aporta experiencia,
                visión y compromiso para ofrecer soluciones innovadoras y
                sostenibles que generan un impacto positivo en cada proyecto.
            </p>
        </div>

        <!-- Cards de miembros -->
        <div class="flex flex-wrap justify-center gap-10 px-6">
            <div
                v-for="(member, index) in team"
                :key="index"
                class="group relative max-w-[340px] overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-500 hover:-translate-y-2"
                data-aos="zoom-in"
            >
                <!-- Imagen -->
                <div class="relative overflow-hidden">
                    <img
                        :src="member.img"
                        :alt="member.name"
                        class="block h-auto w-full bg-gray-50 object-contain transition duration-700 group-hover:scale-105"
                    />
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-green-900/90 p-6 text-white opacity-0 transition duration-500 group-hover:opacity-100"
                    >
                        <p class="text-justify text-sm leading-relaxed">
                            {{ member.perfil }}
                        </p>
                    </div>
                </div>

                <!-- Información -->
                <div class="px-4 py-6 text-center">
                    <h3 class="text-xl font-bold text-orinoco-dark uppercase">
                        {{ member.name }}
                    </h3>
                    <p
                        class="text-sm font-semibold tracking-wide text-lime-600 uppercase"
                    >
                        {{ member.role }}
                    </p>
                    <p class="mt-1 text-sm font-medium text-gray-500">
                        {{ member.occupation }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.text-orinoco-dark {
    color: #0d3b1d;
}

/* AOS suavizado */
[data-aos='zoom-in'] {
    transition: all 0.5s ease;
}
</style>
