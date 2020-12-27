<template>
<div class="mt-6 px-4 relative">
        <div class="lg:flex lg:items-center lg:justify-between container mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate uppercase">
                    {{ data.grade }}
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <div class="flex items-center mr-2 text-gray-700">Gestión</div>
                <div class="relative">
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        v-model="year" @change="onChange($event)">
                        <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-5xl mx-auto bg-white px-4 pt-4 pb-2 rounded shadow">
            <div class="flex justify-between">
                <div class="px-3 font-bold">
                    Documentos
                </div>
                <div class="flex">
                    <span class="block shadow-sm rounded-md mr-3">
                        <router-link :to="{ name: 'planifications.create', params: { id: $route.params.id } }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                            <i class="fa fa-plus mr-3"></i>
                            Nuevo
                        </router-link>
                    </span>
                    <span class="block shadow-sm rounded-md">
                        <router-link :to="{ name: 'planifications' }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                            <i class="fa fa-arrow-left mr-3"></i>
                            Atras
                        </router-link>
                    </span>
                </div>
            </div>
            <div class="relative bg-white mt-6">
                <div v-for="(row, index) in data.documents" :key="index"
                    class="p-3 flex items-start space-x-4 rounded-lg hover:bg-gray-50 transition ease-in-out duration-150 mb-2 relative cursor-pointer"
                    @click="row.show = !row.show">
                    <i v-if="row.extension == 'txt'" class="far fa-file-alt flex-shrink-0 text-xl text-primary-800 mt-1"></i>
                    <i v-else-if="row.extension == 'pdf'" class="far fa-file-pdf flex-shrink-0 text-xl text-red-700 mt-1"></i>
                    <i v-else-if="row.extension == 'zip' || row.extension == 'rar'" class="far fa-file-archive flex-shrink-0 text-xl text-primary-800 mt-1"></i>
                    <i v-else-if="row.extension == 'doc' || row.extension == 'docx'" class="far fa-file-word flex-shrink-0 text-xl text-blue-700 mt-1"></i>
                    <i v-else-if="row.extension == 'xls' || row.extension == 'xlsx'" class="far fa-file-excel flex-shrink-0 text-xl text-green-700 mt-1"></i>
                    <i v-else-if="row.extension == 'pptx' || row.extension == 'ppt'" class="far fa-file-powerpoint flex-shrink-0 text-xl text-orange-700 mt-1"></i>
                    <i v-else-if="row.extension == 'mp4' || row.extension == 'avi' || row.extension == 'flv' || row.extension == 'webm'" class="far fa-file-video flex-shrink-0 text-xl text-blue-800 mt-1"></i>
                    <i v-else class="fa fa-align-center flex-shrink-0 text-xl text-primary-800 mt-1"></i>
                    <div class="space-y-1 w-full overflow-hidden">
                        <p class="text-base leading-6 font-medium text-gray-900 hover:underline cursor-pointer">
                            {{ row.title }}
                        </p>
                        <div v-if="row.show" class="w-full pt-1">
                            <a :href="asset(row.file_name)" target="_blank" class="text-blue-500 hover:underline text-xs">
                                <i class="fa fa-download"></i> Descargar Archivo</a>
                            <div class="w-full markdown-body pt-4 pb-2 text-gray-600 transition ease-in-out duration-150" v-html="row.content"></div>
                        </div>
                        <p v-else class="text-sm leading-5 text-gray-500 truncate transition ease-in-out duration-150">
                            {{ row.content }}
                        </p>
                        <span class="flex absolute top-0 right-0 mr-3 mt-2 text-gray-500">
                            <router-link :to="{name:'planifications.edit',params:{id:row.id,grade:$route.params.id}}" class="flex items-center justify-center w-8 h-8 hover:text-gray-900 rounded-full hover:bg-gray-300">
                                <i class="fa fa-pencil-alt text-sm"></i>
                            </router-link>
                            <button @click="deleteRow(row.id)" class="flex items-center justify-center w-8 h-8 hover:text-gray-900 rounded-full  hover:bg-gray-300">
                                <i class="fa fa-times text-lg"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <loading v-if="loading" />

        <!--Delete modal-->
        <div v-if="showDelete" class="absolute bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
            <div class="fixed inset-0 transition-opacity">
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
                        <p class="text-sm leading-5 text-gray-500">
                            ¿Estás seguro de que deseas eliminar este Documento? 
                            Esta acción no se puede deshacer.
                        </p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button @click="confirm()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Eliminar
                    </button>
                </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button @click="cancel()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Cancelar
                    </button>
                </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import marked from 'marked'
export default {
    name: 'planifications.index',
    data: () => ({
        year: new Date().getFullYear(),
        years: [],
        loading: false,
        data: [],
        model: {},
        showDelete: false,
        delete: null
    }),
    created(){
        this.createdYears()
        this.fetchData()
    },
    mounted() {
        if (localStorage.year) {
            this.year = localStorage.year;
        }
    },
    watch: {
        year(year) {
            localStorage.year = year;
        }
    },
    methods: {
        parse(text) {
            return text != null ? marked(text) : marked('')
        },
        createdYears: function (year) {
            for ( var i = this.year - 15; i < this.year + 3; i++) {
                this.years.push(i);
            }
        },
        async fetchData () {
            this.loading = true
            await this.$http.get('api/academic/documents?year='+this.year+'&grade_id='+this.$route.params.id)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
        showDocuments: function (id) {
            this.$router.push({name:'planifications.show',params:{id:id}})  
        },
        onChange(event) {
            this.fetchData()
        },

        deleteRow: function (id) {
            this.delete = id
            this.showDelete = true
        },
        confirm: function () {
            this.deleteDocument(thid.delete)
            this.showDelete = false
        },
        cancel: function () {
            this.delete = null
            this.showDelete = false
        },
        async deleteDocument (id) {
            this.loading = true
            await this.$http.delete('api/academic/documents/' + id)
                .then((response) => {
                    this.$toast.success('Documento eliminado exitosamente.')
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
    }
}
</script>