window.Vue = require('vue');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import Permission from './mixins/Permission';
Vue.mixin(Permission);

import http from '@/utils/http'
Vue.use(http)

import toast from '@/utils/toast'
Vue.use(toast)

require('@/mixins/path')

require('@/filters/index')

Vue.config.productionTip = false

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')

