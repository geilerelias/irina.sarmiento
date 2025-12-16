<script setup lang="ts">
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { urlIsActive } from '@/lib/utils';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

import { ChevronDown } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    items: NavItem[];
}>();

const page = usePage();

/**
 * Guarda el estado expandido por item (key = title)
 */
const expanded = ref<Record<string, boolean>>({});

/**
 * Auto-expande si algún hijo está activo
 */
const isExpanded = (item: NavItem) => {
    if (expanded.value[item.title] !== undefined) {
        return expanded.value[item.title];
    }

    return (
        item.children?.some((child) => urlIsActive(child.href, page.url)) ??
        false
    );
};

const toggle = (item: NavItem) => {
    expanded.value[item.title] = !isExpanded(item);
};
</script>

<!-- <template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="urlIsActive(item.href, page.url)"
                    :tooltip="item.title"
                >
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template> -->

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>

        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <!-- ITEM SIN HIJOS -->
                <SidebarMenuButton
                    v-if="!item.children"
                    as-child
                    :is-active="urlIsActive(item.href, page.url)"
                    :tooltip="item.title"
                >
                    <Link :href="item.href">
                        <component v-if="item.icon" :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>

                <!-- ITEM CON HIJOS -->
                <div v-else class="space-y-1">
                    <!-- Padre -->
                    <SidebarMenuButton
                        @click="toggle(item)"
                        :tooltip="item.title"
                    >
                        <component v-if="item.icon" :is="item.icon" />
                        <span>{{ item.title }}</span>

                        <!-- Chevron -->
                        <ChevronDown
                            class="ml-auto h-4 w-4 transition-transform"
                            :class="{
                                'rotate-180': isExpanded(item),
                            }"
                        />
                    </SidebarMenuButton>

                    <!-- Hijos -->
                    <transition
                        enter-active-class="transition-all duration-200 ease-out"
                        leave-active-class="transition-all duration-150 ease-in"
                        enter-from-class="opacity-0 max-h-0"
                        enter-to-class="opacity-100 max-h-96"
                        leave-from-class="opacity-100 max-h-96"
                        leave-to-class="opacity-0 max-h-0"
                    >
                        <div
                            v-show="isExpanded(item)"
                            class="ml-6 space-y-1 overflow-hidden"
                        >
                            <SidebarMenuItem
                                v-for="child in item.children"
                                :key="child.title"
                            >
                                <SidebarMenuButton
                                    as-child
                                    :is-active="
                                        urlIsActive(child.href, page.url)
                                    "
                                    :tooltip="child.title"
                                >
                                    <Link :href="child.href">
                                        <component
                                            v-if="child.icon"
                                            :is="child.icon"
                                            class="h-4 w-4"
                                        />
                                        <span>{{ child.title }}</span>
                                    </Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </div>
                    </transition>
                </div>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
