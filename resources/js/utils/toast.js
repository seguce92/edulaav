import 'izitoast/dist/css/iziToast.min.css'
import iZtoast from 'izitoast'
import Vue from 'vue'

const toast = {
    error: (message = "Lo siento se produjo un error al ejecutar la petición. Vuelva a intentarlo.", title = 'ERROR') => {
        return iZtoast.error({
            title: title,
            message: message,
            icon: '',
            backgroundColor: '#b93a42',
            titleColor: '#F7FAFC',
            messageColor: '#EDF2F7',
            timeout: 5000,
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight',
            position: 'bottomRight'
        });
    },
    success: (message = 'Exito al ejecutar petición', title = 'EXCELENTE!') => {
        return iZtoast.success({
            title: title,
            message: message,
            icon: '',
            backgroundColor: '#38A169',
            titleColor: '#F7FAFC',
            messageColor: '#EDF2F7',
            timeout: 5000,
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight',
            position: 'bottomRight'
        });
    },
    info: (message, title = 'INFORMACIÓN') => {
        return iZtoast.info({
            title: title,
            message: message,
            icon: '',
            backgroundColor: '#2B6CB0',
            titleColor: '#F7FAFC',
            messageColor: '#EDF2F7',
            timeout: 5000,
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight',
            position: 'bottomRight'
        });
    },
    warning: (message, title = 'Alerta') => {
        return iZtoast.warning({
            title: title,
            message: message,
            icon: '',
            backgroundColor: '#D69E2E',
            titleColor: '#F7FAFC',
            messageColor: '#EDF2F7',
            timeout: 5000,
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight',
            position: 'bottomRight'
        });
    }
};

export default {
    install () {
        Vue.prototype.$toast = toast
    }
};