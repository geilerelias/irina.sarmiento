<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';

defineProps<{
    users: {
        id: number;
        name: string;
        email: string;
        role: string;
    }[];
}>();

const page = usePage();

const updateRole = (userId: number, role: string) => {
    useForm({ role }).put(`/admin/users/${userId}/role`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout>
        <section class="mx-auto max-w-5xl px-4 py-8 md:px-6 md:py-12">
            <h1
                class="mb-8 text-2xl font-bold text-gray-800 md:text-3xl dark:text-gray-100"
            >
                Gestión de usuarios
            </h1>

            <!-- 🖥️ TABLA (Desktop) -->
            <div
                class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm md:block dark:border-gray-700 dark:bg-gray-900"
            >
                <table class="w-full text-sm">
                    <thead
                        class="bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-300"
                    >
                        <tr>
                            <th class="px-6 py-4 text-left">Nombre</th>
                            <th class="px-6 py-4 text-left">Correo</th>
                            <th class="px-6 py-4 text-left">Rol</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="user in users"
                            :key="user.id"
                            class="border-t border-gray-200 dark:border-gray-700"
                        >
                            <td
                                class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100"
                            >
                                {{ user.name }}
                            </td>

                            <td
                                class="text-truncate px-6 py-4 text-gray-600 dark:text-gray-400"
                            >
                                {{ user.email }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                    :class="{
                                        'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300':
                                            user.role === 'admin',
                                        'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300':
                                            user.role === 'editor',
                                        'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300':
                                            user.role === 'viewer',
                                    }"
                                >
                                    {{ user.role.toUpperCase() }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <select
                                    v-if="page.props.auth.can.manageUsers"
                                    :value="user.role"
                                    @change="
                                        updateRole(user.id, $event.target.value)
                                    "
                                    class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-800 focus:ring focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                                >
                                    <option value="viewer">Viewer</option>
                                    <option value="editor">Editor</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 📱 CARDS (Mobile) -->
            <div class="space-y-4 md:hidden">
                <div
                    v-for="user in users"
                    :key="user.id"
                    class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900"
                >
                    <div
                        class="mb-2 text-sm font-semibold text-gray-900 dark:text-gray-100"
                    >
                        {{ user.name }}
                    </div>

                    <div class="mb-3 text-xs text-gray-600 dark:text-gray-400">
                        {{ user.email }}
                    </div>

                    <div class="mb-3">
                        <span
                            class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                            :class="{
                                'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300':
                                    user.role === 'admin',
                                'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300':
                                    user.role === 'editor',
                                'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300':
                                    user.role === 'viewer',
                            }"
                        >
                            {{ user.role.toUpperCase() }}
                        </span>
                    </div>

                    <select
                        v-if="page.props.auth.can.manageUsers"
                        :value="user.role"
                        @change="updateRole(user.id, $event.target.value)"
                        class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:ring focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                    >
                        <option value="viewer">Viewer</option>
                        <option value="editor">Editor</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
