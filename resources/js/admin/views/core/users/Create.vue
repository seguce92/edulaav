<template>
    <div class="mt-6 px-4">
        <div class="lg:flex lg:items-center lg:justify-between max-w-6xl mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Usuarios
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
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
                    Nuevo Usuario
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Registro de nuevo usuario
                </p>
            </div>
            <div>
                <dl>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Rol <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            v-model="model.role" required autofocus>
                                            <option value="secretario">Secretario(a)</option>
                                            <option value="director">Director(a)</option>
                                            <option value="administrador">Administrador(a)</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                    <error-field :errors="set_error(errors, 'role')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo Electrónico <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="email" required v-model="model.email"
                                        placeholder="example@email.com">
                                    <error-field :errors="set_error(errors, 'email')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Cédula de Identidad <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.ci"
                                        placeholder="Cédula de Identidad">
                                    <error-field :errors="set_error(errors, 'ci')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Nombres <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.name"
                                        placeholder="Nombres">
                                    <error-field :errors="set_error(errors, 'name')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Apellidos
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.lastname"
                                        placeholder="Apellidos">
                                    <error-field :errors="set_error(errors, 'lastname')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Fecha de Nacimiento <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        id="grid-password" 
                                        type="date" v-model="model.birthday">
                                    <error-field :errors="set_error(errors, 'birthday')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Trabaja desde <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="date" v-model="model.work_from">
                                    <error-field :errors="set_error(errors, 'from')"></error-field>
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
export default {
    name: 'users-create',
    data: () => ({
        loading: false,
        errors: [],
        model: {
            role: 'secretario'
        }
    }),
    methods: {
        async store () {
            this.loading = true
            await this.$http.post('api/core/users', this.model)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.$toast.success("Usuario registrado exitosamente.")
                        this.$router.push({ name: 'users.index' })
                    }
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