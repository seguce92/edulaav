<template>
    <div class="">
        <div class="w-full relative">
            <input class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly
                type="hidden" ref="filePicker" :value="value" v-on:input="$emit('input', $event.target.value)">
            <div class="flex mt-4">
                <span class="px-4 py-2 whitespace-no-wrap hidden md:block">
                    <i class="fa fa-align-justify text-lg text-white"></i>
                </span>
                <button @click="show.filemanager = true" class="px-4 py-2 bg-white flex items-center border rounded hover:bg-primary-200 mr-2 focus:outline-none active:bg-primary-500"
                    aria-label="Agregar Archivo" data-balloon-pos="right">
                    <i class="fa fa-paperclip mr-2"></i>
                    Adjuntar Archivos
                </button>
            </div>
        </div>

        <transition
            name="filemanager-transition"
            enter-active-class="animated fadeIn"
            leave-active-class="animated fadeOut">
        <div v-if="show.filemanager" class="absolute inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center font-nunito z-20">
            <div class="absolute inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="w-full shadow-lg bg-white relative min-h-filemanager rounded max-w-6xl"
                :class="show.delete || show.newFolder || show.upload ? 'overflow-y-hidden' : 'overflow-y-auto'">
                <div class="sticky top-0 bg-white z-10">
                    <div class="flex border-b py-2 px-4 justify-between">
                        <div>
                            <button @click="showPanelUpload()" class="px-2 py-1 shadow rounded bg-white hover:bg-gray-200"
                                aria-label="Subir Archivos" data-balloon-pos="right">
                                <i class="fa fa-upload"></i>
                            </button>
                            <button @click="show.newFolder = true" class="px-2 py-1 rounded bg-white hover:bg-gray-200 ml-2 shadow-inner"
                                aria-label="Nueva Carpeta" data-balloon-pos="right">
                                <i class="fa fa-folder-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button @click="show.filemanager = false">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="h-8 flex justify-between bg-gray-200 px-4 py-2">
                        <div class="flex items-center py-2">
                            <button @click="goHome()" class="px-2 py-1"
                                aria-label="Ir al Inicio" data-balloon-pos="right">
                                <i class="fa fa-home"></i>
                            </button>
                            <span class="text-sm p-1">
                                <span class="tracking-widest">/{{ title }}</span> 
                            </span>
                        </div>
                        <div class="text-sm flex items-center">
                            {{ data.folders ? data.folders.length : '0' }} Carpetas - {{ data.files ? data.files.length : '0' }} Archivos
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap overflow-x-hidden px-2">
                    <div v-if="current.length > 0" class="hover:shadow-lg cursor-pointer mx-1 my-2 px-4 py-2 relative rounded max-file bg-gray-400"
                        @click="goBack()">
                        <img :src="asset('filemanager/folder_back.png')" class="ml-auto mr-auto h-16 mt-3 mb-3">
                    </div>
                    <div class="hover:shadow-lg mx-1 my-2 relative rounded max-file filemanager-item"
                        v-for="d in data.folders" :key="d">
                        <img :src="asset('filemanager/folder.png')" class="ml-auto mr-auto h-16 cursor-pointer my-2"
                            @click="showFolder(d)">
                        <div class="tools flex justify-center shadow-inner px-2 h-6">
                            <button @click="showDelete('folder', d)" aria-label="Eliminar" data-balloon-pos="right">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                        <div class="box-name text-center truncate text-xs px-2 bg-white w-full">{{ d }}</div>
                    </div>
                    <div class="hover:shadow-lg mx-1 my-2 relative pt-2 pb-1 rounded max-file filemanager-item"
                        v-for="(f, index) in data.files" :key="index"
                        :aria-label="f.name" data-balloon-pos="right">
                        <img v-if="f.extension == 'png' || f.extension == 'jpg' || f.extension == 'gif'" :src="f.path" 
                            class="ml-auto mr-auto h-16 overflow-hidden mt-2" @click="selectFile(f.storage)">
                        <img v-else :src="asset('filemanager/'+f.extension+'.jpg')" class="ml-auto mr-auto cursor-pointer h-16 mt-2"
                            @click="selectFile(f.storage)">
                        <div class="tools flex justify-center shadow-inner px-2 h-6">
                            <button @click="showDelete('file', f.name)" aria-label="Eliminar" data-balloon-pos="right">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            <a target="_blank" :href="f.path" class="ml-2" aria-label="Descargar" data-balloon-pos="right">
                                <i class="fa fa-download"></i>
                            </a>
                        </div>
                        <div class="box-name text-center truncate text-xs px-2 bg-white w-full">{{ f.name }}</div>
                    </div>
                </div>

                <transition
                    name="filemanager-transition"
                    enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOut">
                    <!--Modal New Folder-->
                    <div v-if="show.newFolder" class="absolute inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center font-nunito z-20">
                        <div class="absolute inset-0 transition-opacity">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <div class="bg-white rounded overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="flex">
                                    <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                                        <h3 class="text-lg leading-6 font-bold text-gray-900">
                                            Nueva Carpeta
                                        </h3>
                                        <div class="mt-2 flex">
                                            <div class="w-full">
                                                <div class="mb-3 pt-0">
                                                    <input type="text" placeholder="Título de Carpeta" 
                                                        required
                                                        v-model="modelFolder.name"
                                                        autofocus
                                                        class="px-3 py-3 placeholder-gray-400 text-gray-700 relative bg-gray-200 rounded text-sm shadow outline-none focus:outline-none focus:bg-white focus:border-primary-700 w-full"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 mb-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                    <button @click="makeDirectory()" type="button" 
                                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-primary-700 text-base leading-6 font-medium text-white shadow-sm hover:bg-primary-600 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                        OK
                                    </button>
                                </span>
                                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                    <button @click="cancelDirectory()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                        Cancelar
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </transition>

                <!-- Modal Upload Files -->
                <transition
                    name="filemanager-transition"
                    enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOut">
                    <div v-if="show.upload" class="absolute inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center font-nunito z-20">
                        <div class="absolute inset-0 transition-opacity">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <div class="bg-white rounded overflow-hidden shadow-xl transform transition-all w-full min-h-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="flex">
                                    <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                                        <h3 class="text-lg leading-6 font-bold text-gray-900">
                                            Subir Archivo
                                        </h3>
                                        <div class="mt-2 flex flex-wrap">
                                            <div class="w-full mb-4">
                                                <button @click="cancelUpload()" 
                                                    class="px-4 py-2 bg-white border rounded shadow hover:bg-gray-300">Retornar a la lista</button>
                                            </div>
                                            <div class="w-full">
                                                <div class="mb-3 pt-0">
                                                    <vue-dropzone ref="myVueDropzone" id="dropzone" 
                                                    :options="dropzoneOptions" :useCustomSlot=true
                                                    v-on:vdropzone-error="failed">
                                                    <div class="dropzone-custom-content">
                                                        <h3 class="dropzone-custom-title text-lg text-blue-600 font-bold">¡Arrastra y suelta para cargar contenido!</h3>
                                                        <div class="subtitle">...o haga clic para seleccionar un archivo de su computadora</div>
                                                    </div>
                                                    </vue-dropzone>
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                <strong>Formatos aceptados: </strong>{{ dropzoneOptions.acceptedFiles }}
                                            </div>
                                            <div class="w-full">
                                                <strong>Tamaño máximo permitido: </strong>{{ dropzoneOptions.maxFilesize }} MB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>

                <!--Modal Delete File or Folder-->
                <transition
                    name="filemanager-transition"
                    enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOut">
                    <div v-if="show.delete" class="absolute inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center z-20">
                        <div class="absolute inset-0 transition-opacity">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Eliminar 
                                </h3>
                                <div class="mt-2">
                                    <p v-if="delItem.type == 'folder'" class="text-sm leading-5 text-gray-500">
                                        ¿Estás seguro de que deseas eliminar esta carpeta? Todos los archivos y carpetas que contiene serán eliminados.
                                    </p>
                                    <p v-else>
                                        ¿Estas seguro de eliminar este archivo?
                                    </p>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button @click="confirmDelete()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Eliminar
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button @click="cancelDelete()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Cancelar
                                </button>
                            </span>
                            </div>
                        </div>
                    </div>
                </transition>

                <loading v-if="loading" />
            </div>
        </div>
        </transition>
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    name: 'filemanager-add',
    components: {
        vueDropzone: vue2Dropzone
    },
    props: {
        value: {
            type: String,
        }
    },
    data: () => ({
        loading: false,
        message: '',
        path: '',
        data: [],
        back: '',
        current : '',
        show: {
            newFolder: false,
            upload: false,
            delete: false,
            filemanager: false
        },
        delItem: {
            name: null,
            type: 'folder' 
        },
        modelFolder: {},
        dropzoneOptions: {},
        localValue: ''
    }),
    created() {
        this.fetchData(this.path)
        this.dropzoneOptions = {
            url: '/api/media/filemanager/submit',
            thumbnailWidth: 150,
            maxFiles: parseInt(window.Settings.filemanager.maxFiles),
            maxFilesize: parseInt(window.Settings.filemanager.maxFilesize),
            acceptedFiles: window.Settings.filemanager.acceptedFiles,
            headers: {
                "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content,
                'v-token-api': window.Settings.service.vtoken
            }
        }
        this.localValue = this.value
    },
    computed: {
        title () {
            return this.current
        }
    },
    methods: {
        async fetchData (path) {
            this.loading = true
            let url = 'api/media/filemanager?path=' + path
            await this.$http.get(url)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        async makeFolder () {
            this.loading = true
            let model = {
                path: this.current,
                name: this.modelFolder.name
            }
            await this.$http.post('api/media/filemanager', model)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                }).finally( (response)  => {
                    this.modelFolder = {}
                    this.show.newFolder = false
                });
            this.loading = false
        },

        goHome: function () {
            this.fetchData('')
            this.current = ''
        },
        goBack: function () {
            this.current = this.current.split('/').slice(0, -1).join('/')
            this.fetchData(this.current)
        },
        showFolder: function (path) {
            this.current = this.current.length > 0 ? this.current + '/' + path : path
            this.fetchData(path)
        },
        showFile: function (path) {
            this.fetchData(path)
        },
        makeDirectory: function () {
            this.makeFolder()
        },
        cancelDirectory: function () {
            this.show.newFolder = false
            this.modelFolder = {}
        },

        /**
         * Upload methods
         */
        showPanelUpload: function () {
            this.show.upload = true
            this.dropzoneOptions.params = {
                path: this.current
            }
        },
        cancelUpload: function () {
            this.show.upload = false
            this.fetchData(this.current)
        },
        failed: function(_file, _message, xhr) {
            const elements = document.querySelectorAll('.dz-error-message span')
            const lastElement = elements[elements.length - 1]
            if (_message.includes("You can't upload files of this type."))
                _message = 'Tu no puedes subir archivos de este tipo.'
            else if (_message.includes("File is too big"))
                _message = 'El archivo es demasiado grande. Tamaño máximo permitido: ' + this.dropzoneOptions.maxFilesize +' MB'
            else
                _message = 'Error al subir el archivo'
            lastElement.textContent = _message
        },

        /**
         * Delete methods
         */
        showDelete: function (type, name) {
            this.delItem.type = type
            this.delItem.name = name
            this.show.delete = true
        },
        cancelDelete: function () {
            this.delItem.type = 'folder'
            this.delItem.name = null
            this.show.delete = false
        },
        confirmDelete: function () {
            this.deleteFolder(this.delItem.type, this.delItem.name)
            this.delItem.type = 'folder'
            this.delItem.name = null
            this.show.delete = false
        },
        async deleteFolder (type, path) {
            this.loading = true
            let model = {
                type: type,
                path: this.current,
                name: path
            }
            await this.$http.post('api/media/filemanager/delete', model)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        selectFile: function (path) {
            this.show.filemanager = false
            this.$emit('input', path)
        },

        updateValue: function () {
            this.$emit('input', this.value)
            console.log(this.$refs.filePicker.value)
        }
    }
}
</script>

<style lang="scss">
    .max-file {
        width:122px;
        max-width:122px
    }
    .min-h-filemanager {
        min-height: 600px;
        max-height: 700px;
    }
    .vue-dropzone {
        @apply border-dashed;
    }
    .filemanager-item {
        img {
            min-height: 4rem;
            max-height: 4rem;
        }
        .box-name {
            position: absolute;
            bottom: 0;
            transition: all 1s;
            @apply py-1;
        }
    }
    .filemanager-item:hover {
        .tools {
            @apply shadow-inner;
        }
        .box-name {
            bottom: 1.8rem;
            @apply border-b border-t;
        }
    }
</style>