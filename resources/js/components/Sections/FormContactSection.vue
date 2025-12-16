<script setup lang="ts">
import { Card, CardContent, CardTitle } from '@/components/ui/card';
import { useGlobalMessage } from '@/composables/useGlobalMessage';
import axios from 'axios';
import { ref } from 'vue';

const { showGlobalMessage } = useGlobalMessage();

interface ContactForm {
    name: string;
    lastname: string;
    email: string;
    phone: string;
    subject: string;
    message: string;
    terms: boolean;
}

const form = ref<ContactForm>({
    name: '',
    lastname: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    terms: false,
});

const loading = ref(false);
const showTerms = ref(false);

const submit = async () => {
    if (!form.value.terms) {
        showGlobalMessage({
            message: 'Debes aceptar los términos y condiciones.',
            type: 'warning',
        });
        return;
    }

    loading.value = true;

    try {
        await axios.post('/contact', form.value);

        showGlobalMessage({
            message: '¡Mensaje enviado correctamente! Te contactaremos pronto.',
            type: 'success',
        });

        form.value = {
            name: '',
            lastname: '',
            email: '',
            phone: '',
            subject: '',
            message: '',
            terms: false,
        };
    } catch (error: any) {
        if (error.response?.status === 422) {
            showGlobalMessage({
                message: 'Por favor completa los campos correctamente.',
                type: 'error',
            });
        } else {
            showGlobalMessage({
                message: 'Error al enviar el mensaje. Intenta nuevamente.',
                type: 'error',
            });
        }
    } finally {
        loading.value = false;
    }
};

const testFormData = {
    name: 'Elias',
    lastname: 'Radillo',
    email: 'geilerelias@gmail.com',
    phone: '3106947004',
    subject: 'Información adicional',
    message: 'Quiero conocer respuestas',
    terms: true,
};

const sendTestData = async () => {
    try {
        const response = await axios.post('/contact', testFormData);
        showGlobalMessage({
            message: '✅ Envío de prueba exitoso. Revisa tu correo.',
            type: 'success',
        });
        console.log('Respuesta del servidor:', response);
    } catch (error) {
        console.error('Error en el envío:', error);
        showGlobalMessage({
            message: '❌ Error al enviar el mensaje de prueba.',
            type: 'error',
        });
    }
};
</script>

<template>
    <section>
        <Card class="mx-auto max-w-2xl rounded-2xl p-6 shadow-lg">
            <CardTitle class="px-5">
                <h3 class="text-2xl font-semibold text-gray-800">
                    Envíanos un Mensaje
                </h3>
            </CardTitle>
            <CardContent>
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Nombre / Apellido -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <input
                            type="text"
                            placeholder="Nombre"
                            v-model="form.name"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 placeholder-gray-400 transition-all focus:border-orinoco-dark focus:ring-1 focus:ring-orinoco-primary focus:outline-none"
                        />
                        <input
                            type="text"
                            placeholder="Apellido"
                            v-model="form.lastname"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 placeholder-gray-400 transition-all focus:border-orinoco-dark focus:ring-1 focus:ring-orinoco-primary focus:outline-none"
                        />
                    </div>

                    <!-- Email / Teléfono -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <input
                            type="email"
                            placeholder="Correo electrónico"
                            v-model="form.email"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 placeholder-gray-400 transition-all focus:border-orinoco-dark focus:ring-1 focus:ring-orinoco-primary focus:outline-none"
                        />
                        <input
                            type="tel"
                            placeholder="Teléfono o WhatsApp"
                            v-model="form.phone"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 placeholder-gray-400 transition-all focus:border-orinoco-dark focus:ring-1 focus:ring-orinoco-primary focus:outline-none"
                        />
                    </div>

                    <!-- Asunto -->
                    <input
                        type="text"
                        placeholder="Asunto o motivo del contacto"
                        v-model="form.subject"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 placeholder-gray-400 transition-all focus:border-orinoco-dark focus:ring-1 focus:ring-orinoco-primary focus:outline-none"
                    />

                    <!-- Mensaje -->
                    <textarea
                        placeholder="Escribe tu mensaje aquí..."
                        v-model="form.message"
                        rows="5"
                        required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 placeholder-gray-400 transition-all focus:border-orinoco-dark focus:ring-1 focus:ring-orinoco-primary focus:outline-none"
                    ></textarea>

                    <!-- Términos -->
                    <label class="flex items-center text-sm text-gray-600">
                        <input
                            type="checkbox"
                            v-model="form.terms"
                            class="mr-2"
                            required
                        />
                        Acepto los

                        <button
                            type="button"
                            @click="showTerms = true"
                            class="ml-1 font-semibold text-[#024031] hover:underline"
                        >
                            Términos y Condiciones
                        </button>.
                    </label>

                    <!-- Botón -->
                    <button
                        type="submit"
                        :disabled="loading"
                        class="hover:bg-orinoco-darker w-full transform rounded-xl bg-orinoco-primary py-3 font-semibold text-white shadow-md transition-transform hover:scale-[1.02] disabled:opacity-60"
                    >
                        {{ loading ? 'Enviando...' : 'Enviar Mensaje' }}
                    </button>

                    <!--                <button
                    type="button"
                    @click="sendTestData"
                    class="w-full mt-4 rounded-xl bg-blue-600 py-3 font-semibold text-white hover:bg-blue-700"
                >
                    Enviar datos de prueba
                </button>-->
                </form>
            </CardContent>
        </Card>

        <!-- MODAL TÉRMINOS -->
        <transition name="fade">
            <div
                v-if="showTerms"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm"
            >
                <div
                    class="relative w-full max-w-5xl h-[90vh] bg-white rounded-2xl overflow-hidden shadow-xl flex flex-col"
                >
                    <div
                        class="flex items-center justify-between bg-orinoco-primary text-white px-6 py-4"
                    >
                        <h3 class="text-xl font-semibold">Términos y Condiciones</h3>
                        <button
                            @click="showTerms = false"
                            class="text-white hover:text-gray-200 transition"
                        >
                            ✕
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6 text-gray-700 text-justify space-y-4">
                        <h4 class="text-[#024031] font-semibold text-lg">
                            1. Aceptación de los Términos
                        </h4>
                        <p>
                            Al acceder, navegar o utilizar este sitio web, usted reconoce que ha leído, comprendido y acepta
                            cumplir con los presentes Términos y Condiciones. Si no está de acuerdo con alguna de las
                            disposiciones aquí contenidas, le recomendamos abstenerse de utilizar el sitio o de enviar
                            información a través de los formularios de contacto.
                        </p>

                        <h4 class="text-[#024031] font-semibold text-lg">
                            2. Objeto del Sitio
                        </h4>
                        <p>
                            Este sitio web tiene como propósito brindar información sobre los servicios, productos y actividades
                            de nuestra organización, así como permitir el contacto directo con el equipo responsable mediante
                            formularios electrónicos, correos y otros canales disponibles.
                        </p>

                        <h4 class="text-[#024031] font-semibold text-lg">
                            3. Responsabilidad del Usuario
                        </h4>
                        <p>
                            El usuario se compromete a proporcionar información veraz, completa y actualizada al diligenciar los
                            formularios de contacto. No se permitirá el uso del sitio con fines ilícitos, fraudulentos o que
                            afecten los derechos de terceros o el correcto funcionamiento del sistema.
                        </p>

                        <h4 class="text-[#024031] font-semibold text-lg">
                            4. Uso y Tratamiento de la Información (Habeas Data)
                        </h4>
                        <p>
                            En cumplimiento de la Ley 1581 de 2012 y el Decreto 1377 de 2013 sobre Protección de Datos
                            Personales, informamos que los datos personales suministrados a través de este sitio serán
                            incorporados en una base de datos bajo la responsabilidad de nuestra entidad.
                        </p>
                        <p>
                            La finalidad del tratamiento de los datos será la gestión administrativa, comercial y de contacto
                            con los usuarios, incluyendo la atención de solicitudes, el envío de información relacionada con
                            productos o servicios, y la mejora de la experiencia del usuario.
                        </p>
                        <p>
                            El titular de los datos tiene derecho a conocer, actualizar, rectificar o suprimir la información,
                            así como a revocar la autorización otorgada para su tratamiento. Para ejercer estos derechos podrá
                            comunicarse al correo:
                            <a
                                href="mailto:contacto@ecorinocosas.com"
                                class="text-[#69a936] underline"
                            >contacto@ecorinocosas.com</a
                            >.
                        </p>

                        <h4 class="text-[#024031] font-semibold text-lg">
                            5. Propiedad Intelectual
                        </h4>
                        <p>
                            Todos los contenidos, logotipos, marcas, textos, gráficos, imágenes, videos, código fuente y
                            demás elementos presentes en este sitio web son propiedad exclusiva de la organización o de sus
                            respectivos autores y están protegidos por las leyes de propiedad intelectual. Queda prohibida su
                            reproducción, distribución o modificación sin autorización expresa y por escrito.
                        </p>

                        <h4 class="text-[#024031] font-semibold text-lg">
                            6. Limitación de Responsabilidad
                        </h4>
                        <p>
                            No garantizamos la disponibilidad continua ni la ausencia de errores en el funcionamiento del sitio.
                            Tampoco nos hacemos responsables por daños derivados del uso o imposibilidad de uso del mismo,
                            incluyendo pérdida de datos o daños indirectos, incidentales o consecuenciales.
                        </p>

                        <h4 class="text-[#024031] font-semibold text-lg">
                            7. Enlaces a Sitios Externos
                        </h4>
                        <p>
                            Este sitio puede contener enlaces a sitios web de terceros. No somos responsables del contenido,
                            políticas o prácticas de privacidad de dichos sitios, por lo que el acceso a ellos es bajo
                            responsabilidad del usuario.
                        </p>

                        <h4 class="text-[#024031] font-semibold text-lg">
                            8. Modificaciones
                        </h4>
                        <p>
                            Nos reservamos el derecho de actualizar, modificar o eliminar total o parcialmente estos Términos y
                            Condiciones en cualquier momento, sin previo aviso. Las versiones actualizadas estarán disponibles
                            en esta misma página.
                        </p>

                        <h4 class="text-[#024031] font-semibold text-lg">
                            9. Legislación Aplicable
                        </h4>
                        <p>
                            Los presentes Términos y Condiciones se rigen por las leyes de la República de Colombia. Cualquier
                            controversia derivada de su interpretación o ejecución será resuelta por los tribunales competentes
                            de acuerdo con la legislación vigente.
                        </p>

                        <p class="mt-6 italic text-sm text-gray-600">
                            Última actualización: {{ new Date().toLocaleDateString('es-CO') }}
                        </p>
                    </div>

                    <div class="p-4 border-t text-right">
                        <button
                            @click="showTerms = false"
                            class="px-6 py-2 bg-orinoco-primary text-white rounded-full hover:bg-[#69a936] transition"
                        >
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </transition>

    </section>
</template>
