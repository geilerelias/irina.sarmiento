<script setup lang="ts">
import PdfViewer from '@/components/PdfViewer.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { router, useForm } from '@inertiajs/vue3';

import { computed, ref } from 'vue';

function handleCreateFileChange(e: Event) {
    const target = e.target as HTMLInputElement;
    form.file = target.files?.[0] ?? null;
}

function handleEditFileChange(e: Event) {
    const target = e.target as HTMLInputElement;
    editForm.file = target.files?.[0] ?? null;
}

/* =====================
   TYPES
===================== */
interface AcademicDocument {
    id: number;
    title: string;
    description: string | null;
    published_at: string | null;
    file_path: string;
}

/* =====================
   PROPS
===================== */
const props = defineProps<{
    category: string;
    documents: AcademicDocument[];
}>();

/* =====================
   CREATE FORM
===================== */
const form = useForm({
    title: '',
    description: '',
    published_at: '',
    file: null as File | null,
});

function submit() {
    form.post(`/admin/academic-production/${props.category}`, {
        forceFormData: true,
        onSuccess: () => form.reset(),
    });
}

/* =====================
   EDIT
===================== */
const editing = ref<AcademicDocument | null>(null);

const editForm = useForm({
    title: '',
    description: '',
    published_at: '',
    file: null as File | null,
});

function openEdit(doc: AcademicDocument) {
    editing.value = doc;
    editForm.title = doc.title;
    editForm.description = doc.description ?? '';
    editForm.published_at = doc.published_at ?? '';
    editForm.file = null;
}

function update() {
    if (!editing.value) return;

    editForm.post(
        `/admin/academic-production/${props.category}/${editing.value.id}`,
        {
            method: 'put',
            forceFormData: true,
            onSuccess: () => {
                editing.value = null;
                editForm.reset();
            },
        },
    );
}

/* =====================
   DELETE
===================== */
function destroy(doc: AcademicDocument) {
    if (!confirm('¿Eliminar este documento?')) return;

    router.delete(`/admin/academic-production/${props.category}/${doc.id}`);
}

/* =====================
   HELPERS
===================== */
function isImage(path: string): boolean {
    return /\.(jpg|jpeg|png|webp)$/i.test(path);
}

const categoryLabels: Record<string, string> = {
    articles: 'Artículos científicos',
    research: 'Investigaciones libres',
    thesis: 'Tesis doctoral',
    evaluations: 'Evaluaciones',
    workshops: 'Talleres',
};

const categoryText = computed(() => {
    return categoryLabels[props.category] ?? 'Categoría desconocida';
});
</script>

<template>
    <AppLayout>
        <div class="mx-auto max-w-6xl space-y-10 px-4 py-6 md:px-6 md:py-8">
            <!-- HEADER -->
            <div
                class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
            >
                <div>
                    <h1
                        class="text-2xl font-semibold text-gray-800 md:text-3xl dark:text-gray-100"
                    >
                        Producción Académica
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Gestión de documentos — {{ categoryText }}
                    </p>
                </div>

                <span
                    class="w-fit rounded-full bg-orinoco-primary/10 px-4 py-1 text-sm font-medium text-orinoco-primary dark:text-orinoco-light"
                >
                    {{ categoryText }}
                </span>
            </div>

            <!-- CREATE FORM -->
            <form
                @submit.prevent="submit"
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg dark:border-orinoco-primary dark:bg-sidebar"
            >
                <div
                    class="h-1 w-full bg-gradient-to-r from-orinoco-primary to-orinoco-light"
                ></div>

                <div class="space-y-6 p-6 md:p-8">
                    <h2
                        class="text-lg font-semibold text-gray-800 md:text-xl dark:text-gray-100"
                    >
                        Nuevo documento
                    </h2>

                    <input
                        v-model="form.title"
                        class="input dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                        placeholder="Título"
                        required
                    />

                    <textarea
                        v-model="form.description"
                        class="input dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                        rows="3"
                        placeholder="Descripción"
                    />

                    <input
                        type="date"
                        v-model="form.published_at"
                        class="input dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                    />

                    <label
                        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 p-6 text-center transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-gray-600 dark:hover:bg-gray-800"
                    >
                        <input
                            type="file"
                            accept=".pdf,image/*"
                            class="hidden"
                            @change="
                                (e) =>
                                    (form.file =
                                        (e.target as HTMLInputElement)
                                            .files?.[0] ?? null)
                            "
                            required
                        />
                        <span class="text-3xl">📄</span>
                        <span
                            class="mt-2 text-sm text-gray-700 dark:text-gray-300"
                        >
                            Subir PDF o imagen
                        </span>
                    </label>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="btn-primary"
                            :disabled="form.processing"
                        >
                            Guardar documento
                        </button>
                    </div>
                </div>
            </form>

            <!-- DESKTOP TABLE -->
            <div
                class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg md:block dark:border-gray-700 dark:bg-sidebar"
            >
                <table class="w-full text-sm">
                    <thead
                        class="bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-300"
                    >
                        <tr>
                            <th class="px-4 py-3 text-left">Título</th>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Archivo</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="doc in documents"
                            :key="doc.id"
                            class="border-t border-gray-200 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-800"
                        >
                            <td class="px-4 py-3">
                                <p
                                    class="font-medium text-gray-800 dark:text-gray-100"
                                >
                                    {{ doc.title }}
                                </p>
                                <p
                                    v-if="doc.description"
                                    class="text-xs text-gray-500 dark:text-gray-400"
                                >
                                    {{ doc.description }}
                                </p>
                            </td>

                            <td
                                class="px-4 py-3 text-gray-500 dark:text-gray-400"
                            >
                                {{ doc.published_at ?? '—' }}
                            </td>

                            <td class="px-4 py-3">
                                <img
                                    v-if="isImage(doc.file_path)"
                                    :src="`/storage/${doc.file_path}`"
                                    class="max-h-40 rounded-lg border dark:border-gray-700"
                                />
                                <PdfViewer
                                    v-else
                                    :src="`/secure-pdf/${doc.file_path}`"
                                />
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="btn-secondary"
                                        @click="openEdit(doc)"
                                    >
                                        Editar
                                    </button>
                                    <button
                                        class="btn-danger"
                                        @click="destroy(doc)"
                                    >
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="documents.length === 0">
                            <td
                                colspan="4"
                                class="px-4 py-8 text-center text-gray-500 dark:text-gray-400"
                            >
                                No hay documentos registrados
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE CARDS -->
            <div class="space-y-4 md:hidden">
                <div
                    v-for="doc in documents"
                    :key="doc.id"
                    class="rounded-xl border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-900"
                >
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">
                        {{ doc.title }}
                    </h3>

                    <p
                        v-if="doc.description"
                        class="mt-1 text-xs text-gray-500 dark:text-gray-400"
                    >
                        {{ doc.description }}
                    </p>

                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Fecha: {{ doc.published_at ?? '—' }}
                    </p>

                    <div class="mt-3">
                        <img
                            v-if="isImage(doc.file_path)"
                            :src="`/storage/${doc.file_path}`"
                            class="rounded-lg"
                        />
                        <PdfViewer
                            v-else
                            :src="`/secure-pdf/${doc.file_path}`"
                        />
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button
                            class="btn-secondary w-full"
                            @click="openEdit(doc)"
                        >
                            Editar
                        </button>
                        <button class="btn-danger w-full" @click="destroy(doc)">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>

            <!-- EDIT MODAL -->
            <div
                v-if="editing"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
            >
                <div
                    class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-900"
                >
                    <div class="border-b px-6 py-4 dark:border-gray-700">
                        <h3
                            class="text-lg font-semibold text-gray-800 dark:text-gray-100"
                        >
                            Editar documento
                        </h3>
                    </div>

                    <div class="space-y-4 px-6 py-6">
                        <input
                            v-model="editForm.title"
                            class="input dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                        />
                        <textarea
                            v-model="editForm.description"
                            class="input dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                            rows="3"
                        />
                        <input
                            type="date"
                            v-model="editForm.published_at"
                            class="input dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                        />
                        <input
                            type="file"
                            class="input dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                            @change="
                                (e) =>
                                    (editForm.file =
                                        (e.target as HTMLInputElement)
                                            .files?.[0] ?? null)
                            "
                        />
                    </div>

                    <div
                        class="flex justify-end gap-3 border-t bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-800"
                    >
                        <button class="btn-secondary" @click="editing = null">
                            Cancelar
                        </button>

                        <button
                            class="btn-primary"
                            :disabled="editForm.processing"
                            @click="update"
                        >
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
