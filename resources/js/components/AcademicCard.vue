<template>
  <Link
    :href="route"
    class="group relative overflow-hidden rounded-2xl bg-white shadow-lg transition hover:-translate-y-2 hover:shadow-2xl"
  >
    <!-- Fondo degradado -->
    <div
      class="absolute inset-0 bg-gradient-to-br opacity-90"
      :class="gradient"
    ></div>

    <!-- Contenido -->
    <div class="relative z-10 p-8 text-white">
      <component
        :is="icon"
        class="mb-6 h-10 w-10"
      />
       

      <h3 class="mb-3 text-2xl font-semibold">
        {{ title }}
      </h3>

      <p class="text-sm text-white/90">
        {{ description }}
      </p>

      <span
        class="mt-6 inline-block text-sm font-semibold underline underline-offset-4"
      >
        Ver mas →
      </span>
    </div>
  </Link>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import * as Icons from "lucide-vue-next";

interface Props {
  title: string;
  description: string;
  route: string;
  gradient: string;
  icon: keyof typeof Icons;
}

const props = defineProps<Props>();

</script>
