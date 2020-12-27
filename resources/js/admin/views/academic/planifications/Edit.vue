<template>
    <div class="mt-6 px-4">
        <div class="lg:flex lg:items-center lg:justify-between max-w-6xl mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Editar Documento
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="block shadow-sm rounded-md">
                    <router-link :to="{ name: 'planifications.show',params:{id:$route.params.grade} }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-arrow-left mr-3"></i>
                        Atras
                    </router-link>
                </span>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-6xl mx-auto">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Editar Documento
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Actualizar información de Documento
                </p>
            </div>
            <div>
                <dl>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Título <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.title" autofocus>
                                    <error-field :errors="set_error(errors, 'title')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Archivo
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <filemanager v-model="model.file_name" label="Archivo"></filemanager>
                                    <error-field :errors="set_error(errors, 'title')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Contenido
                        </dt>
                        <dd v-if="markdown" class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <markdown-editor class="w-full" v-model="model.content" :options="options" :height="'200px'" />
                                    <error-field :errors="set_error(errors, 'content')"></error-field>
                                </div>
                            </div>
                        </dd>
                        <dd v-else class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <textarea-autosize
                                        placeholder="Contenido..."
                                        class="px-3 py-3 text-gray-700 relative bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:shadow-none focus:border-b w-full"
                                        ref="myTextarea"
                                        v-model="model.content"
                                        :min-height="150"
                                        :max-height="1024" />
                                    <error-field :errors="set_error(errors, 'content')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                </dl>
                <dl>
                    <div class="px-4 py-5 sm:px-6 flex md:justify-end">
                        <button @click="store" class="text-white cursor-pointer inline-flex items-center px-4 py-2 bg-primary-800 border border-gray-300 text-sm leading-5 font-medium rounded-md hover:text-white hover:bg-primary-700 focus:outline-none transition duration-150 ease-in-out">
                            <i class="fa fa-save mr-3"></i>
                            Enviar
                        </button>
                    </div>
                </dl>
            </div>
            <loading v-if="loading" />
        </div>
    </div>
</template>

<script>
import MarkdownEditor from '@/components/MarkdownEditor'
import Filemanager from '@/components/Filemanager/Index.vue'
export default {
    name: 'planifications-create',
    components: {
        MarkdownEditor,
        Filemanager
    },
    data: () => ({
        loading: false,
        errors: [],
        model: {},
        data: [],
        markdown: false,
        options: {
            hideModeSwitch: true,
        },
    }),
    watch: {
        '$route.params.id': function (id) {
            this.fetchData(id)
        }
    },
    created() {
        this.markdown = window.Settings.ui.markdown
        this.fetchData(this.$route.params.id)
    },
    methods: {
        async fetchData (id) {
            this.loading = true
            await this.$http.get('api/academic/documents/' + id)
                .then((response) => {
                    this.model = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
        async store () {
            this.loading = true
            await this.$http.put('api/academic/documents', this.model)
                .then((response) => {
                    this.$toast.success("Documento registrado exitosamente.")
                    this.$router.push({ name: 'planifications.show',params:{id:this.$route.params.grade} })
                }).catch((response) => {
                    this.message = response.message
                    this.errors = response.errors != null ? response.errors : {} 
                    this.$toast.error("Corrija los errores e intentalo nuevamente. Gracias.")
                });
            this.loading = false
        },
    }
}
</script>