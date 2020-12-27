import axios from 'axios'
import Vue from 'vue'

let token = document.head.querySelector('meta[name="csrf-token"]');

window.token = token.content
axios.defaults.headers.common = {
    'X-CSRF-TOKEN': token.content,
    'X-Requested-With': 'XMLHttpRequest',
    'v-token-api' : window.Settings.service.vtoken
};


axios.defaults.baseURL = window.Settings.service.api

axios.interceptors.response.use(
    response => {
        if (response.headers.authorization) {
            setToken(response.headers.authorization);
            response.data.token = response.headers.authorization;
        }
        return response;
    },
    error => {
        let errors;
        if (error && error.response) {
            if (error.response.status === 401) {
                //toast.error("Lo siento no tienes acceso a esta opcion. Necesitas Iniciar sesion");
                localStorage.removeItem('isLoggedIn')
                window.location = '/login'
            }

            if (error.response.data && error.response.data.message && error.response.data.message == 'Unauthenticated.') {
                //toast.error("Lo siento no tienes acceso a esta opcion. Necesitas Iniciar sesion");
                localStorage.removeItem('isLoggedIn')
                window.location = '/login'
            }

            if (error.response.data && error.response.data.errors) {
                errors = error.response.data,errors;
            } else if (error.response.data && error.response.data.error) {
                errors = error.response.data.error;
            }
        }

        let data = {
            'error': error,
            'errors': typeof errors != 'undefined' ? errors.errors : null,
            'message': typeof errors != 'undefined' ? errors.message : ''
        }
        return Promise.reject(data);
    },
);

export default {
    install () {
        Vue.prototype.$http = axios
    }
};