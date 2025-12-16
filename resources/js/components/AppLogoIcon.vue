<script setup lang="ts">
import { computed } from "vue";
import type { HTMLAttributes } from "vue";
import { Link } from "@inertiajs/vue3";
import { home } from "@/routes";

import logo_con_letras_primario from "@/../images/logo/logo.png";
import logo_con_letras_blanco from "@/../images/logo/logo.png";
import logo_sin_letras_primario from "@/../images/logo/logo.png";
import logo_sin_letras_blanco from "@/../images/logo/logo.png";

defineOptions({
  inheritAttrs: false,
});

interface Props {
  /** Mostrar logo con letras (true) o solo isotipo (false) */
  withLetter?: boolean;
  /** Usar versión blanca (true) o primario (false) */
  white?: boolean;
  /** Clases adicionales */
  className?: HTMLAttributes["class"];
}

const props = withDefaults(defineProps<Props>(), {
  withLetter: true,
  white: false,
});

const logoSrc = computed(() => {
  const { withLetter, white } = props;

  if (withLetter && !white) return logo_con_letras_primario;
  if (withLetter && white) return logo_con_letras_blanco;
  if (!withLetter && !white) return logo_sin_letras_primario;
  if (!withLetter && white) return logo_sin_letras_blanco;

  // Fallback de seguridad
  return logo_con_letras_primario;
});
</script>

<template>
  <Link :href="home()" class="inline-block focus:outline-none" aria-label="Ir al inicio">
    <img
      :src="logoSrc"
      :class="className"
      v-bind="$attrs"
      alt="Logo E.C Orinoco S.A.S."
      class="cursor-pointer transition-transform duration-300 hover:scale-105"
    />
  </Link>
</template>
