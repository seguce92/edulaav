<template>
    <div class="mt-6 px-4">
        <div class="lg:flex lg:items-center lg:justify-between max-w-6xl mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Estudiantes
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="block shadow-sm rounded-md mr-3">
                    <router-link :to="{ name: 'students.edit', params: { id: model.id } }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-pencil-alt mr-3"></i>
                        Editar
                    </router-link>
                </span>
                <span class="block shadow-sm rounded-md">
                    <router-link :to="{ name: 'students.index' }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-arrow-left mr-3"></i>
                        Atras
                    </router-link>
                </span>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-6xl mx-auto">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Información de Estudiante
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Ver información detallada de Estudiante
                </p>
            </div>
            <div>
                <dl>
                    <div class="w-full px-4 mt-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN DEL ESTUDIANTE</h4>
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
                            {{ model.information.ci }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            RUDE
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.rude }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Nombres
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2 capitalize">
                            {{ model.name }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Apellidos
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2 capitalize">
                            {{ model.lastname }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Fecha de Nacimiento
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.birthday_date }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Lugar de Nacimiento
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.site ? model.information.site : '---' }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Telf-Cel
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.phone ? model.information.phone : '---' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Dirección
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.adress ? model.information.adress : '---' }}
                        </dd>
                    </div>

                    <div class="w-full px-4 mt-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN COMPLEMENTARIA</h4>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Talla(m.)
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.size }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Seguro Médico
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.medic ? model.information.medic : '---' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Grupo Sanguineo
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.blood_type }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Genero
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.gender == 'M' ? 'Masculino' : 'Femenino' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            U.E. de Procedencia
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.procendent ? model.information.procedent : '---' }}
                        </dd>
                    </div>

                    <div class="w-full px-4 mt-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN DEL PADRE</h4>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Nombre Completo del Padre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.father_name ? model.information.father_name : '---' }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Ocupación del Padre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.father_occupation ? model.information.father_occupation : '---' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo electrónico del Padre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.father_email ? model.information.father_email : '---' }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Telf-Cel del Padre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.father_phone ? model.information.father_phone : '---' }}
                        </dd>
                    </div>

                    <div class="w-full px-4 mt-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN DE LA MADRE</h4>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Nombre completo de la Madre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.mother_name ? model.information.mother_name : '---' }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Ocupación de la Madre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.mother_occupation ? model.information.mother_occupation : '---' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo electrónico de la Madre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.mother_email ? model.information.mother_email : '---' }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Telf-Cel de la Madre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.mother_phone ? model.information.mother_phone : '---' }}
                        </dd>
                    </div>

                    <div class="w-full px-4 mt-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN DEL TUTOR</h4>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo electrónico del Tutor
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.tutor_email ? model.information.tutor_email : '---' }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Telf-Cel del Tutor
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ model.information.tutor_phone ? model.information.tutor_phone : '---' }}
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
    name: 'students-show',
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
            await this.$http.get('api/core/students/' + id)
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