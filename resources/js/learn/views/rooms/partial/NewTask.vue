<template>
    <transition @keydown.esc="toggleModal"
        name="login-transition"
        enter-active-class="animated zoomIn"
        leave-active-class="animated zoomOut">
        <div @keydown.esc="toggleModal" v-if="value" :class="value ? '' : 'opacity-0 pointer-events-none'" class="modal fixed inset-0 w-full h-screen flex items-center justify-center z-9999 font-nunito">
            <div @keydown.esc="toggleModal" class="bg-modal-overlay absolute w-full h-full bg-video"></div>
            <div class="modal-container bg-white fixed w-full h-full z-50 overflow-y-auto ">
                <div class="py-2 px-4 border-b border-primary-500 flex items-center sticky top-0 z-50 bg-white">
                    <button @click="toggleModal"
                        class="w-10 h-10 hover:bg-primary-200 flex justify-center items-center rounded-full p-2">
                        <i class="fa fa-times text-lg"></i>
                    </button> <span class="text-lg ml-3 font-bold">Tarea</span>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-4/5 px-4 py-4 md:min-h-modal md:max-h-modal overflow-y-auto ">
                        <div class="flex mb-3">
                            <span class="px-4 py-2 whitespace-no-wrap hidden md:block">
                                <i class="fa fa-align-left text-lg text-primary-800"></i>
                            </span>
                            <input type="text" 
                                v-model="model.title" required
                                class="px-3 py-3 text-gray-700 relative bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:shadow-none focus:border-b w-full"
                                placeholder="Título"/>
                        </div>
                        <div v-if="markdown" class="flex">
                            <span class="px-4 py-2 whitespace-no-wrap hidden md:block">
                                <i class="fa fa-align-justify text-lg text-primary-800"></i>
                            </span>

                            <markdown-editor class="w-full" v-model="model.content" :options="options" :height="'512px'" />
                        </div>
                        <div v-else class="flex">
                            <span class="px-4 py-2 whitespace-no-wrap hidden md:block">
                                <i class="fa fa-align-justify text-lg text-primary-800"></i>
                            </span>
                            <textarea-autosize
                                placeholder="Descripción..."
                                class="px-3 py-3 text-gray-700 relative bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:shadow-none focus:border-b w-full"
                                ref="myTextarea"
                                v-model="model.content"
                                :min-height="150"
                                :max-height="1024" />
                        </div>
                        <filemanager-add v-model="fileName" @input="updateValue($event)"></filemanager-add>
                        <div class="flex mt-4">
                            <span class="px-4 py-2 whitespace-no-wrap hidden md:block">
                                <i class="fa fa-align-justify text-lg text-white"></i>
                            </span>
                            <div class="relative w-full">
                                <a v-for="(row, index) in model.array_files" :key="index"
                                    :href="asset(row.path)" target="_blank"
                                    class="p-3 flex items-start space-x-4 border rounded-lg hover:bg-gray-200 transition ease-in-out duration-150 mb-2 relative cursor-pointer">
                                    <i v-if="row.extension == 'txt'" class="far fa-file-alt flex-shrink-0 icon-file text-primary-800 mt-1"></i>
                                    <i v-else-if="row.extension == 'pdf'" class="far fa-file-pdf flex-shrink-0 icon-file text-red-700 mt-1"></i>
                                    <i v-else-if="row.extension == 'zip' || row.extension == 'rar'" class="far fa-file-archive flex-shrink-0 icon-file text-primary-800 mt-1"></i>
                                    <i v-else-if="row.extension == 'doc' || row.extension == 'docx'" class="far fa-file-word flex-shrink-0 icon-file text-blue-700 mt-1"></i>
                                    <i v-else-if="row.extension == 'xls' || row.extension == 'xlsx'" class="far fa-file-excel flex-shrink-0 icon-file text-green-700 mt-1"></i>
                                    <i v-else-if="row.extension == 'pptx' || row.extension == 'ppt'" class="far fa-file-powerpoint flex-shrink-0 icon-file text-orange-700 mt-1"></i>
                                    <i v-else-if="row.extension == 'mp4' || row.extension == 'avi' || row.extension == 'flv' || row.extension == 'webm'" class="far fa-file-video flex-shrink-0 icon-file text-blue-800 mt-1"></i>
                                    <i v-else-if="row.extension == 'jpg' || row.extension == 'png' || row.extension == 'gif' || row.extension == 'bmp'" class="far fa-file-image flex-shrink-0 icon-file text-blue-900 mt-1"></i>
                                    <i v-else class="fa fa-align-center flex-shrink-0 icon-file text-primary-800 mt-1"></i>
                                    <div class="space-y-1 w-full overflow-hidden">
                                        <p class="text-base leading-6 font-medium text-gray-900 cursor-pointer">
                                            {{ row.name }}
                                        </p>
                                        <p class="text-sm leading-5 text-gray-500 truncate transition ease-in-out duration-150 uppercase">
                                            {{ row.extension }}
                                        </p>
                                        <span class="flex absolute top-0 right-0 mr-3 mt-2 text-gray-500">
                                            <button @click="deleteFile(row)" class="flex items-center justify-center w-8 h-8 hover:text-gray-900 rounded-full  hover:bg-gray-300">
                                                <i class="fa fa-times text-lg"></i>
                                            </button>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/5 md:border-l md:border-primary-500">
                        <div class="px-4 py-1">
                            <label class="text-sm leading-5 font-medium text-gray-600">
                                Tema
                            </label>
                            <div class="w-full">
                                <div class="relative">
                                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        v-model="model.topic_id" required>
                                        <option v-for="(row, index) in data" :key="index" :value="row.id">{{ row.title }}</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                                <error-field :errors="set_error(errors, 'topic_id')"></error-field>
                            </div>
                        </div>
                        <div class="px-4 py-1">
                            <label class="text-sm leading-5 font-medium text-gray-600">
                                Puntos
                            </label>
                            <div class="w-full">
                                <div class="mb-3 pt-0">
                                    <input type="number" placeholder="100" 
                                        min="0" max="100" required
                                        v-model="model.points"
                                        class="px-3 py-3 placeholder-gray-400 text-gray-700 relative bg-gray-200 rounded text-sm shadow outline-none focus:outline-none focus:bg-white focus:border-gray-500 w-full"/>
                                </div>
                                <error-field :errors="set_error(errors, 'points')"></error-field>
                            </div>
                        </div>
                        <div class="px-4 py-1">
                            <label class="text-sm leading-5 font-medium text-gray-600">
                                <span>Fecha: {{ model.date == null || model.date == '' ? 'Sin Limite de Tiempo' : model.date }}</span>
                            </label>
                            <div class="w-full">
                                <div class="relative">
                                    <div class="mb-3 pt-0">
                                        <input type="date" placeholder="Sin limite de Tiempo" 
                                            v-model="model.date"
                                            class="px-3 py-3 placeholder-gray-400 text-gray-700 relative bg-gray-200 rounded text-sm shadow outline-none focus:outline-none focus:bg-white focus:border-gray-500 w-full"/>
                                    </div>
                                </div>
                                <error-field :errors="set_error(errors, 'date')"></error-field>
                            </div>
                        </div>
                        <div v-if="model.date != null && model.date != ''" class="px-4 py-1">
                            <label class="text-sm leading-5 font-medium text-gray-600">
                                Hora
                            </label>
                            <div class="w-full">
                                <div class="mb-3 pt-0">
                                    <input type="time" placeholder="00:00:00" 
                                        v-model="model.time" required
                                        class="px-3 py-3 placeholder-gray-400 text-gray-700 relative bg-gray-200 rounded text-sm shadow outline-none focus:outline-none focus:bg-white focus:border-gray-500 w-full"/>
                                </div>
                                <error-field :errors="set_error(errors, 'date')"></error-field>
                            </div>
                        </div>
                        <div class="px-4 py-1">
                            <div class="w-full">
                                <button @click="storeData()" class="px-6 py-2 bg-primary-800 hover:bg-primary-700 text-white rounded flex items-center">
                                    <i class="fa fa-share mr-3"></i>
                                    Publicar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
import MarkdownEditor from '@/components/MarkdownEditor'
import FilemanagerAdd from '@/components/Filemanager/Add.vue'
export default {
    name: 'new-task',
    components: {
        MarkdownEditor,
        FilemanagerAdd
    },
    props: {
        value: {
            type: Boolean
        },
        id: {
            type: String,
            default: null
        }
    },
    data: () => ({
        loading: false,
        errors: [],
        message: '',
        model: {},
        data: [],
        html: null,
        options: {
            hideModeSwitch: true,
        },
        markdown: false,
        fileName: '',
    }),
    created() {
        this.fetchData(this.$route.params.id)
        this.initialize()
        this.markdown = window.Settings.ui.markdown
        this.$parent.$on('fetchTask', this.fetchTask);
    },
    methods: {
        toggleModal: function() {
            this.$emit('input', !this.value);
        },

        initialize: function () {
            this.model = {
                designation_id: this.$route.params.id,
                points: 100,
                date: null,
                time: null,
                title: '',
                content: null,
                type: 'task',
                array_files: []
            }
        },

        async fetchData (id) {
            this.loading = true
            await this.$http.get('api/lms/topics/list/' + id)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        async store () {
            this.loading = true
            await this.$http.post('api/lms/tasks', this.model)
                .then((response) => {
                    this.$toast.success("Tarea registrada exitosamente.")
                    this.initialize()
                    this.$root.$emit('updateListTask');
                    this.toggleModal()
                }).catch((response) => {
                    this.message = response.message
                    this.errors = response.errors != null ? response.errors : {} 
                    this.$toast.error("Corrija los errores e intentalo nuevamente. Gracias.")
                });
            this.loading = false
        },

        storeData: function () {
            if ( this.id != null)
                this.update(this.id)
            else
                this.store()
        },
        getExtension: function (str) {
            return str.split('.').pop();
        },
        getName: function (pattern, str) {
            let l = str.replace('.'+pattern, '')
            return l.split('/').pop()
        },
        addFile: function (file) {
            let extension = this.getExtension(file);
            this.model.array_files.push({
                id: this.getUniqueID(),
                name: this.getName(extension, file),
                extension: extension,
                path: file
            })
        },
        deleteFile: function (file) {
            this.model.array_files = this.model.array_files.filter(function (value) {
                return value.id != file.id
            })
        },
        updateValue: function (e) {
            this.addFile(e)
            this.fileName = ''
        },
        getUniqueID: function (){
            return Date.now() +  (Math.random()*100000).toFixed()
        },

        /**
         * Section edit
         */

        async fetchTask (id) {
            this.loading = true
            await this.$http.get('api/lms/tasks/' + id)
                .then((response) => {
                    this.model = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        async update (id) {
            this.loading = true
            await this.$http.put('api/lms/tasks/'+id, this.model)
                .then((response) => {
                    this.$toast.success("Tarea actualizada exitosamente.")
                    this.initialize()
                    this.$root.$emit('updateListTask');
                    this.toggleModal()
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

<style scoped>
    .modal {
        transition: opacity .25s ease;
    }
    .modal.active {
        overflow-x: hidden;
        overflow-y: visible !important;
    }
    .opacity-95 {
        opacity: 1;
    }

    .input {
        transition: border 0.2s ease-in-out;
        min-width: 150px
    }

    .label {
        transition: all 0.2s ease-out;
        top: 0.4rem;
      	left: 0;
    }
    .icon-file {
        font-size: 2.5rem;
    }
    .z-100 {
        z-index: 100
    }
</style>
