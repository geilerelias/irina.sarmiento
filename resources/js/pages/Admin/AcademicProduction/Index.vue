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
        <div class="mx-auto max-w-6xl space-y-10 px-6 py-8">
            <!-- HEADER -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-orinoco-dark">
                        Producción Académica
                    </h1>
                    <p class="text-orinoco-gray text-sm">
                        Gestión de documentos — {{ categoryText }}
                    </p>
                </div>

                <span
                    class="rounded-full bg-orinoco-accent/20 px-4 py-1 text-sm font-medium text-orinoco-accent capitalize"
                >
                    {{ categoryText }}
                </span>
            </div>

            <!-- CREATE FORM -->
            <form
                @submit.prevent="submit"
                class="border-orinoco-border rounded-2xl border bg-white shadow-lg"
            >
                <div class="gradient-orinoco h-1 w-full rounded-t-2xl"></div>

                <div class="space-y-6 p-8">
                    <h2 class="text-xl font-semibold text-orinoco-dark">
                        Nuevo documento
                    </h2>

                    <input
                        v-model="form.title"
                        class="input"
                        placeholder="Título"
                        required
                    />

                    <textarea
                        v-model="form.description"
                        class="input"
                        rows="3"
                        placeholder="Descripción"
                    />

                    <input
                        type="date"
                        v-model="form.published_at"
                        class="input"
                    />
                    <label
                        class="border-orinoco-border flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed p-6 text-center transition hover:border-orinoco-primary hover:bg-orinoco-light"
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
                        <span class="mt-2 text-sm text-orinoco-dark">
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

            <!-- TABLE -->
            <div
                class="border-orinoco-border overflow-hidden rounded-2xl border bg-white shadow-lg"
            >
                <table class="w-full text-sm">
                    <thead class="bg-orinoco-light">
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
                            class="border-t hover:bg-orinoco-light/40"
                        >
                            <td class="px-4 py-3">
                                <p class="font-medium text-orinoco-dark">
                                    {{ doc.title }}
                                </p>
                                <p
                                    v-if="doc.description"
                                    class="text-orinoco-gray text-xs"
                                >
                                    {{ doc.description }}
                                </p>
                            </td>

                            <td class="text-orinoco-gray px-4 py-3">
                                {{ doc.published_at ?? '—' }}
                            </td>

                            <td class="px-4 py-3">
                                <template v-if="isImage(doc.file_path)">
                                    <img
                                        :src="`/storage/${doc.file_path}`"
                                        class="border-orinoco-border max-h-48 rounded-xl border"
                                    />
                                </template>

                                <template v-else>
                                    <PdfViewer
                                        :src="`/secure-pdf/${doc.file_path}`"
                                    />
                                </template>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button
                                        @click="openEdit(doc)"
                                        class="btn-secondary"
                                    >
                                        Editar
                                    </button>

                                    <button
                                        @click="destroy(doc)"
                                        class="btn-danger"
                                    >
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="documents.length === 0">
                            <td
                                colspan="4"
                                class="text-orinoco-gray px-4 py-8 text-center"
                            >
                                No hay documentos registrados
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- EDIT MODAL -->
            <div
                v-if="editing"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            >
                <div
                    class="border-orinoco-border w-full max-w-lg rounded-2xl border bg-white shadow-xl"
                >
                    <div class="border-b px-6 py-4">
                        <h3 class="text-lg font-semibold text-orinoco-dark">
                            Editar documento
                        </h3>
                    </div>

                    <div class="space-y-4 px-6 py-6">
                        <input v-model="editForm.title" class="input" />
                        <textarea
                            v-model="editForm.description"
                            class="input"
                            rows="3"
                        />
                        <input
                            type="date"
                            v-model="editForm.published_at"
                            class="input"
                        />
                        <input
                            type="file"
                            class="input"
                            @change="
                                (e) =>
                                    (editForm.file =
                                        (e.target as HTMLInputElement)
                                            .files?.[0] ?? null)
                            "
                        />
                    </div>

                    <div
                        class="flex justify-end gap-3 border-t bg-orinoco-light px-6 py-4"
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
