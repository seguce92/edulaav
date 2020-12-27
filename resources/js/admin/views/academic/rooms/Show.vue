<template>
    <div class="mt-6 px-4 relative">
        <div class="lg:flex lg:items-center lg:justify-between max-w-6xl mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Cursos
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="block shadow-sm rounded-md mr-3">
                    <router-link :to="{ name: 'rooms.edit', params: { id: $route.params.id } }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-pencil-alt mr-3"></i>
                        Editar
                    </router-link>
                </span>
                <span class="block shadow-sm rounded-md">
                    <router-link :to="{ name: 'rooms' }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-arrow-left mr-3"></i>
                        Atras
                    </router-link>
                </span>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-6xl mx-auto">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Información de Curso
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Ver información detallada de Curso
                </p>
            </div>
            <div>
                <dl>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Curso
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2 uppercase">
                            {{ model.title }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Asesor
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2 capitalize">
                            {{ model.adviser ? model.adviser.full_name : 'Sin Asesor' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="py-8 max-w-6xl mx-auto">
            <h4 class="font-bold text-lg py-2">Estudiantes</h4>
            <data-table :api="'api/academic/rooms/students/' + this.$route.params.id" :cols="cols" :action="true" :searching="true">
                <template slot="tools">
                    <router-link :to="{name:'rooms.students',params:{id:this.$route.params.id}}" class="btn-small-outline md:ml-3">
                        <i class="fa fa-plus mr-1"></i>
                        Agregar Estudiantes
                    </router-link>
                </template>
                <template v-slot:action="slotProps">
                    <a @click="deleteRow(slotProps.row.id)" aria-label="Eliminar" data-balloon-pos="left" class="inline-block ml-2 text-gray-500 hover:text-red-700 cursor-pointer">
                        <i class="fa fa-trash-alt"></i>
                    </a>
                </template>
            </data-table>
        </div>

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
                        Eliminar Estudiante
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm leading-5 text-gray-500">
                            ¿Estás seguro de que deseas eliminar este Estudiante del Curso? Todos sus datos serán eliminados permanentemente. Esta acción no se puede deshacer.
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
        <loading v-if="loading" />
    </div>
</template>

<script>
import DataTable from '@/components/DataTable'
export default {
    name: 'rooms-show',
    components: {
        DataTable
    },
    data: () => ({
        loading: false,
        model: {},
        cols: [],
        data: false,
        showDelete: false,
        delete: null
    }),
    watch: {
        '$route.params.id': function (id) {
            this.fetchData(id)
        }
    },
    created() {
        this.fetchData(this.$route.params.id)
        this.cols = [
            { name: 'id', value: 'id' },
            { name: 'student.information.ci', value: 'C.I.' },
            { name: 'student.information.rude', value: 'RUDE' },
            { name: 'student.full_name', value: 'Nombres' },
            { name: 'student.email', value: 'Correo Electrónico' },
            { name: 'created_at_human', value: 'registrado' }
        ]
    },
    methods: {
        async fetchData (id) {
            this.loading = true
            await this.$http.get('api/academic/rooms/' + id)
                .then((response) => {
                    this.model = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        deleteRow: function (id) {
            this.delete = id
            this.showDelete = true
        },
        confirm: function () {
            this.deleteData(this.delete)
            this.showDelete = false
            this.delete = null
        },
        cancel: function () {
            this.showDelete = false
        },
        async deleteData (id) {
            this.loading = true
            await this.$http.delete('api/academic/rooms/students/delete/' + id)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.$toast.success("Estudiante eliminado exitosamente.")
                        this.$emit('updateDataTable')
                    }
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
    }
}
</script>