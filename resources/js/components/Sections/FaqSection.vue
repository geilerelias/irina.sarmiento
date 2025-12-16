<template>
    <section class="bg-orinoco-light py-24">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <!-- Encabezado -->
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-4xl font-bold text-orinoco-darker">
                    Preguntas Frecuentes
                </h2>
                <p class="text-lg text-orinoco-text-muted">
                    Información clave sobre el ejercicio profesional,
                    académico y comunitario.
                </p>
            </div>

            <!-- FAQs -->
            <div class="space-y-4">
                <div
                    v-for="faq in faqs"
                    :key="faq.id"
                    class="rounded-2xl bg-white shadow-sm transition hover:shadow-md"
                >
                    <button
                        @click="toggleFaq(faq.id)"
                        type="button"
                        class="flex w-full items-center justify-between px-6 py-5 text-left"
                    >
                        <span
                            class="text-lg font-semibold text-orinoco-darker"
                        >
                            {{ faq.question }}
                        </span>

                        <component
                            :is="openFaq === faq.id ? ChevronUp : ChevronDown"
                            class="h-5 w-5 text-orinoco-primary transition-transform"
                        />
                    </button>

                    <Transition name="accordion">
                        <div
                            v-show="openFaq === faq.id"
                            class="px-6 pb-6"
                        >
                            <p class="leading-relaxed text-orinoco-text">
                                {{ faq.answer }}
                            </p>
                        </div>
                    </Transition>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import { ChevronDown, ChevronUp } from 'lucide-vue-next'

interface FAQ {
    id: number
    question: string
    answer: string
}

const faqs: FAQ[] = [
    {
        id: 1,
        question: '¿Cuál es su formación académica?',
        answer:
            'Psicóloga Social Comunitaria, Especialista en Planeación Educativa y Magíster en Educación, con formación orientada al fortalecimiento de procesos pedagógicos, comunitarios y etnoeducativos.'
    },
    {
        id: 2,
        question: '¿En qué contextos ha desarrollado su labor docente?',
        answer:
            'He trabajado en educación formal y comunitaria, con especial énfasis en contextos etnoeducativos, rurales y culturales diversos, promoviendo enfoques diferenciales e inclusivos.'
    },
    {
        id: 3,
        question: '¿Cuál es su enfoque pedagógico?',
        answer:
            'Un enfoque humanista, crítico e intercultural, centrado en el estudiante, la comunidad y el territorio como ejes fundamentales del proceso educativo.'
    },
    {
        id: 4,
        question: '¿Participa en proyectos educativos o sociales?',
        answer:
            'Sí. He participado y liderado procesos de planeación educativa, acompañamiento psicosocial y fortalecimiento comunitario en diferentes escenarios institucionales.'
    }
]

const openFaq = ref<number | null>(null)

const toggleFaq = (id: number): void => {
    openFaq.value = openFaq.value === id ? null : id
}
</script>
