// resources/js/composables/useDarkMode.ts
import { ref, watch } from 'vue'

const dark = ref(localStorage.theme === 'dark')

watch(dark, value => {
    document.documentElement.classList.toggle('dark', value)
    localStorage.theme = value ? 'dark' : 'light'
})

export function useDarkMode() {
    return { dark }
}
