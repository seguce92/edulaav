<template>
    <div class="px-4 py-8 max-w-6xl mx-auto relative">
        <div class="lg:flex lg:items-center lg:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Grados
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <router-link :to="{ name: 'grades.create' }" class="btn-small-outline md:ml-3">
                    <i class="fa fa-plus mr-1"></i>
                    Nuevo Grado
                </router-link>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Detalle
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Paralelos
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr v-for="(row, index) in data" :key="index">
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div @click="showUrl(row.id)" class="rounded-full cursor-pointer bg-primary-600 hover:bg-primary-800 w-12 h-12 text-white uppercase py-3 text-center">
                                                <span>{{ row.title.substr(0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm leading-5 font-medium text-gray-900">{{ row.code }}</div>
                                            <div class="text-sm leading-5 text-gray-500">{{ row.title }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-900">{{ row.user.role }}</div>
                                    <div class="text-sm leading-5 text-gray-500">{{ row.user.full_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500">{{ row.count_parallel }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                    <router-link :to="{ name: 'grades.show', params: {id:row.id}}" aria-label="Ver" data-balloon-pos="left" class="inline-block mr-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                                        <i class="fa fa-eye"></i>
                                    </router-link>
                                    <router-link :to="{ name: 'grades.edit', params: {id:row.id}}" aria-label="Editar" data-balloon-pos="left" class="inline-block text-gray-500 hover:text-gray-800 cursor-pointer">
                                        <i class="fa fa-edit"></i>
                                    </router-link>
                                    <a href="#" aria-label="Eliminar" data-balloon-pos="left" class="inline-block ml-2 text-gray-500 hover:text-red-700 cursor-pointer">
                                        <i class="fa fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <loading v-if="loading" />
    </div>
</template>

<script>
export default {
    name: 'grades.index',
    data: () => ({
        loading: false,
        data: []
    }),
    created () {
        this.fetchData()
    },
    methods: {
        showUrl: function (id) {
            this.$router.push({ name: 'grades.show', params: {id:id} })
        },
        async fetchData () {
            this.loading = true
            await this.$http.get('api/academic/grades')
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
    }
}
</script>