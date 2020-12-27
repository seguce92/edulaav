<template>
    <div class="mt-6 px-4">
        <div class="lg:flex lg:items-center lg:justify-between max-w-6xl mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Usuarios
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="block shadow-sm rounded-md mr-3">
                    <router-link :to="{ name: 'users.edit', params: { id: model.id } }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-pencil-alt mr-3"></i>
                        Editar
                    </router-link>
                </span>
                <span class="block shadow-sm rounded-md">
                    <router-link :to="{ name: 'users.index' }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-arrow-left mr-3"></i>
                        Atras
                    </router-link>
                </span>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-6xl mx-auto">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Información de Usuario
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Ver información detallada de Usuario
                </p>
            </div>
            <div>
                <dl>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Rol
                        </dt>
                        <dd v-if="model.role == 'administrador'" class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            Administrador
                        </dd>
                        <dd v-else-if="model.roe == 'secretario'" class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            Secretario(a)
                        </dd>
                        <dd v-else class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            Director(a)
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo Electrónico
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.email }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Cédula de Identidad
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.ci }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Nombres
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2 capitalize">
                            {{ model.name }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Apellidos
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2 capitalize">
                            {{ model.lastname }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Fecha de Nacimiento
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.birthday }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Trabaja desde
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.work_from }}
                        </dd>
                    </div>
                </dl>
            </div>
            <loading v-if="loading" />
        </div>
    </div>
</template>

<script>
export default {
    name: 'users-show',
    data: () => ({
        loading: false,
        errors: [],
        model: {}
    }),
    watch: {
        '$route.params.id': function (id) {
            this.fetchData(id)
        }
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    methods: {
        async fetchData (id) {
            this.loading = true
            await this.$http.get('api/core/users/' + id)
                .then((response) => {
                    this.model = response.data.data
                    this.model.ci = response.data.data.information.ci
                    this.model.birthday = response.data.data.information.birthday_date
                    this.model.work_from = response.data.data.information.work_from_date
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
    }
}
</script>