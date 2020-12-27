window.Vue = require('vue');

/*import Permission from './mixins/Permission';
Vue.mixin(Permission);*/

import http from '@/utils/http'
Vue.use(http)

import toast from '@/utils/toast'
Vue.use(toast)

import App from './learn/views/App'
import router from './learn/router'

import TextareaAutosize from 'vue-textarea-autosize'
Vue.use(TextareaAutosize)

Vue.component('loading', require('@/components/Loading.vue').default);
Vue.component('error-field', require('@/components/ErrorField.vue').default);

require('@/mixins/path')

require('@/filters/index')

Vue.config.productionTip = false

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')

