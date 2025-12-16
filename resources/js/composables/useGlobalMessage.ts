import Swal from 'sweetalert2';
import { ref } from 'vue';

/**
 * Tipos de mensaje admitidos
 */
export type MessageType = 'success' | 'error' | 'info' | 'warning';

/**
 * Interfaz para los mensajes de tipo Toast o Global Message
 */
export interface GlobalMessageOptions {
    message: string;
    type?: MessageType;
    duration?: number;
}

/**
 * Interfaz para los cuadros de confirmación
 */
export interface ConfirmActionOptions {
    title: string;
    text?: string;
    confirmButtonText?: string;
    cancelButtonText?: string;
    icon?: MessageType;
}

const globalMessage = ref<string | null>(null);
const messageType = ref<MessageType>('info');
const isVisible = ref(false);

export function useGlobalMessage() {
    /**
     * Muestra un mensaje global (toast)
     */
    const showGlobalMessage = ({
        message,
        type = 'info',
        duration = 4000,
    }: GlobalMessageOptions) => {
        globalMessage.value = message;
        messageType.value = type;
        isVisible.value = true;

        if (Swal) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                background: '#fff',
                color: '#333',
                showConfirmButton: false,
                timer: duration,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-xl shadow-lg',
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                },
            });
        } else {
            console.warn('SweetAlert2 no detectado, usando fallback visual.');
            setTimeout(() => {
                isVisible.value = false;
                globalMessage.value = null;
            }, duration);
        }
    };

    /**
     * Cuadro de confirmación con botones
     * Devuelve true si el usuario confirma la acción
     */
    const showConfirmMessage = async ({
        title,
        text = '',
        confirmButtonText = 'Confirmar',
        cancelButtonText = 'Cancelar',
        icon = 'warning',
    }: ConfirmActionOptions): Promise<boolean> => {
        if (!Swal) {
            console.warn(
                'SweetAlert2 no detectado. confirmAction devolverá false.',
            );
            return false;
        }

        const result = await Swal.fire({
            title,
            text,
            icon,
            showCancelButton: true,
            confirmButtonText,
            cancelButtonText,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            reverseButtons: true,
            focusCancel: true,
        });

        return result.isConfirmed;
    };


    return {
        globalMessage,
        messageType,
        isVisible,
        showGlobalMessage,
        showConfirmMessage,
    };
}
