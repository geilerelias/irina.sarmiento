// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

// Translations provided by Vuetify
import { es } from 'vuetify/locale'

//icons
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader


const vuetify = createVuetify({
    locale: {
        locale: 'es',
        messages: { es }, // Usa el locale español incluido por Vuetify
    },
    components,
    directives,
    icons: {
        defaultSet: 'mdi', // This is already the default value - only for display purposes
    },
    theme: {
        defaultTheme: 'light',
        themes: {
            light: {
                dark: false,
                colors: {
                    background: '#f8f7f7',             // gris claro suave para fondo general
                    surface: '#FFFFFF',
                    'surface-bright': '#FFFFFF',
                    'surface-light': '#F5F5F5',
                    'surface-variant': '#E0E0E0',
                    'on-surface-variant': '#EEEEEE',

                    primary: '#272727',
                    'primary-darken-1': '#1b1b1b',
                    'primary-lighten-1': '#3d3d3d',

                    secondary: '#9e9e9e',
                    'secondary-darken-1': '#7b7b7b',
                    'secondary-lighten-1': '#bdbdbd',

                    accent: '#212121',
                    error: '#f44336',
                    warning: '#ff9800',
                    info: '#1e88e5',
                    success: '#4caf50',
                },
            },

            dark: {
                dark: true,
                colors: {
                    background: '#121212',             // fondo gris oscuro
                    surface: '#1E1E1E',
                    'surface-bright': '#2C2C2C',
                    'surface-light': '#2E2E2E',
                    'surface-variant': '#424242',
                    'on-surface-variant': '#757575',

                    primary: '#272727',
                    'primary-darken-1': '#1b1b1b',
                    'primary-lighten-1': '#3d3d3d',

                    secondary: '#9e9e9e',
                    'secondary-darken-1': '#7b7b7b',
                    'secondary-lighten-1': '#bdbdbd',

                    accent: '#bdbdbd',
                    error: '#ef9a9a',
                    warning: '#ffb74d',
                    info: '#90caf9',
                    success: '#81c784',
                },
            }
        },
        typography: {
            fontFamily: 'Montserrat, sans-serif', // Configura Montserrat como fuente predeterminada
        },
    },
});

export default vuetify;







