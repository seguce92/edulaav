<template>
    <div class="mt-6 px-4">
        <div class="lg:flex lg:items-center lg:justify-between max-w-6xl mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Cursos
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="block shadow-sm rounded-md">
                    <router-link :to="{ name: 'rooms.show', params:{id:$route.params.id}}" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-arrow-left mr-3"></i>
                        Atras
                    </router-link>
                </span>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-6xl mx-auto">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Agregar Estudiantes a Curso
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Registro de nuevo Estudiantes a Curso
                </p>
            </div>
            <div>
                <dl>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Estudiantes
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <multiselect v-model="values" :options="data" :multiple="true" 
                                        :close-on-select="false" :clear-on-select="false"
                                        :preserve-search="true"
                                        :searchable="true"
                                        :custom-label="nameWithAll"
                                        placeholder="Buscar Estudiantes" label="name" track-by="name"
                                        select-label="Seleccione un Profesor"
                                        selectLabel="Presione Enter para Seleccionar"
                                        selectedLabel="Seleccionado"
                                        deselectLabel="Presione Enter para Remover">
                                        <template slot="option" slot-scope="props">
                                            <div class="mb-1">
                                                <span class="font-bold">CI:</span> <span class="font-light">{{ props.option.ci }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span class="font-bold">RUDE:</span> <span class="font-light">{{ props.option.ci }}</span>
                                            </div>
                                            <div class="option__desc">
                                                <span class="font-bold">NOMBRES:</span> <span class="font-light">{{ props.option.name }}</span>
                                            </div>
                                        </template>
                                        <template slot="selection" slot-scope="{ values, search, isOpen }">
                                            <span class="multiselect__single">
                                                {{ values.length }} Estudiantes Seleccionados
                                            </span>
                                        </template>
                                    </multiselect>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">
                            Estudiantes seleccionados
                        </h3>
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-primary-700 uppercase tracking-wider">
                                        Nombres y Apellidos
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-primary-700 uppercase tracking-wider">
                                        C.I.
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-primary-700 uppercase tracking-wider">
                                        RUDE
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr v-for="(row, index) in values" :key="index">
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm leading-5 font-medium text-gray-900">{{ row.name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900">{{ row.ci }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900">{{ row.rude }}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </dl>
                <dl>
                    <div class="px-4 py-5 sm:px-6 flex md:justify-end">
                        <button v-if="values.length > 0" @click="submit" class="text-white cursor-pointer inline-flex items-center px-4 py-2 bg-primary-800 border border-gray-300 text-sm leading-5 font-medium rounded-md hover:text-white hover:bg-primary-700 focus:outline-none transition duration-150 ease-in-out">
                            <i class="fa fa-save mr-3"></i>
                            Registrar Estudiantes
                        </button>
                    </div>
                </dl>
            </div>
        </div>
        <loading v-if="loading" />
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    name: 'rooms-students',
    components: {
        Multiselect
    },
    data: () => ({
        loading: false,
        data: [],
        values: [],
    }),
    mounted() {
        if (localStorage.year) {
            this.year = localStorage.year
        }
    },
    created() {
        this.fetchData()
    },
    methods: {
        async fetchData () {
            this.loading = true
            await this.$http.get('api/academic/rooms/get-students/' + this.$route.params.id)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
        submit: function () {
            let data = [];
            this.values.forEach(function (item) {
                data.push(item.id)
            })
            this.store(data)
        },
        async store (data) {
            this.loading = true
            let mod = {
                year: localStorage.year ? localStorage.year : new Date().getFullYear(),
                room_id: this.$route.params.id,
                students: data
            }
            await this.$http.post('api/academic/rooms/students/store', mod)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.$toast.success("Curso registrado exitosamente.")
                        this.$router.push({name:'rooms.show',params:{id:this.$route.params.id}})
                    } else if(response.status == 205) {
                        this.$toast.warning("Lo siento no se pudo registrar la información, Ya existe un registro con la misma información.")
                    }
                }).catch((response) => {
                    this.message = response.message
                    this.errors = response.errors != null ? response.errors : {} 
                    this.$toast.error("Corrija los errores e intentalo nuevamente. Gracias.")
                });
            this.loading = false
        },
        nameWithAll ({ name, ci, rude }) {
            return `${name} — [${ci}] - [${rude}]`
        }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>