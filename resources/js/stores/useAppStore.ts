import { defineStore } from 'pinia';

export const useAppStore = defineStore('app', {
    state: () => ({
        scrolled: false,
        mobileMenuOpen: false,
        loading: false,
        message: '',
        messageType: 'success' as string
    }),
    actions: {
        setScrolled(scrolled: boolean) {
            this.scrolled = scrolled;
        },
        toggleMobileMenu() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
        },
        setLoading(value: boolean) {
            this.loading = value;
        },
        showMessage(message: string, type: string = 'success') {
            this.message = message;
            this.messageType = type;
        },
        clearMessage() {
            this.message = '';
        }
    }
});