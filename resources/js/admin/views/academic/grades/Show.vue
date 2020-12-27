<template>
    <div class="mt-6 px-4 relative">
        <div class="lg:flex lg:items-center lg:justify-between max-w-6xl mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Grados
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="block shadow-sm rounded-md mr-3">
                    <router-link :to="{ name: 'grades.edit', params: { id: model.id } }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-pencil-alt mr-3"></i>
                        Editar
                    </router-link>
                </span>
                <span class="block shadow-sm rounded-md">
                    <router-link :to="{ name: 'grades.index' }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-arrow-left mr-3"></i>
                        Atras
                    </router-link>
                </span>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-6xl mx-auto">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Información de Grado
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Ver información detallada de Grado
                </p>
            </div>
            <div>
                <dl>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Código
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.code }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Título / Descripción
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.title }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Registrado por
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.user ? model.user.full_name : '' }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Registrado
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.created_at_human }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="max-w-6xl mx-auto mt-8">
            <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                Paralelos ({{ model.count_parallel }})
            </h2>
            <data-table :api="'api/academic/parallels?grade=' + $route.params.id" :cols="cols" :action="true" :searching="true">
                <template slot="tools">
                    <router-link :to="{name:'parallels.create',params:{id:model.id}}" class="btn-small-outline md:ml-3">
                        <i class="fa fa-plus mr-1"></i>
                        Nuevo Paralelo
                    </router-link>
                </template>
                <template v-slot:action="slotProps">
                    <router-link :to="{name:'parallels.edit',params:{id:slotProps.row.id}}" aria-label="Editar" data-balloon-pos="left" class="inline-block text-gray-500 hover:text-gray-800 cursor-pointer">
                        <i class="fa fa-edit"></i>
                    </router-link>
                    <a aria-label="Eliminar" data-balloon-pos="left" class="inline-block ml-2 text-gray-500 hover:text-red-700 cursor-pointer">
                        <i class="fa fa-trash-alt"></i>
                    </a>
                </template>
            </data-table>
        </div>

        <div class="max-w-6xl mx-auto mt-8">
            <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                Asignaturas ({{ model.count_subject }})
            </h2>
            <data-table :api="'api/academic/subjects?grade=' + $route.params.id" :cols="cols2" :action="true" :searching="true">
                <template slot="tools">
                    <router-link :to="{name:'subjects.create',params:{id:model.id}}" class="btn-small-outline md:ml-3">
                        <i class="fa fa-plus mr-1"></i>
                        Nueva Asignatura
                    </router-link>
                </template>
                <template v-slot:action="slotProps">
                    <router-link :to="{name:'subjects.edit',params:{id:slotProps.row.id}}" aria-label="Editar" data-balloon-pos="left" class="inline-block text-gray-500 hover:text-gray-800 cursor-pointer">
                        <i class="fa fa-edit"></i>
                    </router-link>
                    <a aria-label="Eliminar" data-balloon-pos="left" class="inline-block ml-2 text-gray-500 hover:text-red-700 cursor-pointer">
                        <i class="fa fa-trash-alt"></i>
                    </a>
                </template>
            </data-table>
        </div>
        <loading v-if="loading" />
    </div>
</template>

<script>
import DataTable from '@/components/DataTable'
export default {
    name: 'grades-show',
    components: {
        DataTable
    },
    data: () => ({
        loading: false,
        errors: [],
        model: {},
        cols: [],
        cols2: []
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
            { name: 'code', value: 'Código' },
            { name: 'title', value: 'Paralelo' },
            { name: 'status', value: 'Estado' },
            { name: 'created_at_human', value: 'registrado' }
        ]
        this.cols2 = [
            { name: 'id', value: 'id' },
            { name: 'code', value: 'Código' },
            { name: 'title', value: 'Asignatura' },
            { name: 'status', value: 'Estado' },
            { name: 'created_at_human', value: 'registrado' }
        ]
    },
    methods: {
        async fetchData (id) {
            this.loading = true
            await this.$http.get('api/academic/grades/' + id)
                .then((response) => {
                    this.model = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
    }
}
</script>