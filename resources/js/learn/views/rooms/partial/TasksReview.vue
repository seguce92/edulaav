<template>
    <div class="relative">
        <router-link :to="{name:'rooms.task',params:{id:$route.params.designation}}"
            class="absolute top-0 px-4 py-1 bg-white shadow rounded mt-2">
            <i class="fa fa-arrow-left"></i>
        </router-link>
        <div class="max-w-6xl mx-auto flex justify-center font-nunito border-b relative">
            <ul class="border-b flex shadow-lg">
                <router-link :to="{name:'rooms.task.show',params:{designation:$route.params.designation,id:$route.params.id}}"
                    class="text-primary-500 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform rounded-tl-md">
                    Instrucciones de la Tarea
                </router-link>
                <router-link  :to="{name:'rooms.task.review',params:{designation:$route.params.id,id:$route.params.id}}"
                    class="px-6 lg:px-10 text-primary-700 border-b-4 border-primary-900 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform">
                    Tareas de los Estudiantes
                </router-link>
            </ul>
        </div>
        <div class="mt-4 font-nunito bg-white h-56 shadow-lg rounded-lg flex min-h-pant">
            <div class="w-full md:w-1/3 h-56 border-r min-h-pant overflow-y-auto">
                <ul>
                    <li class="py-3 whitespace-no-wrap border-b border-gray-400 px-4 flex items-center sticky top-0 bg-white rounded-tl-lg">
                        <span class="w-10 h-10 flex items-center justify-center bg-primary-700 text-white rounded-full mr-2">
                            <i class="fa fa-users"></i>
                        </span>
                        <span class="font-bold">Estudiantes</span>
                    </li>
                    <li v-for="(row, index) in students" :key="index" 
                        class="py-2 whitespace-no-wrap border-b border-gray-400 hover:bg-gray-200 px-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" 
                                    :src="asset('storage/profiles/default.png')"
                                    alt="Nombre de estudiante">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm leading-5 font-medium text-gray-900">
                                    {{index}}Nombres y apellidos de estudiante
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    email@gmail.com
                                </div>
                            </div>
                            <div class="flex justify-end pl-3">
                                <input type="number" min="0" max="100" value="0" class="h-10 w-16 border-b focus:border-primary-700 text-center">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="w-full md:2/4 min-h-pant px-4 py-3 overflow-y-auto">
                <h3 class="font-bold text-lg mt-2">{{ data.title }}</h3>
                <div class="flex mt-2">
                    <div class="flex flex-col justify-center mr-3">
                        <span class="text-lg">0</span>
                        <span class="text-xs">Asignados</span>
                    </div>
                    <div class="flex flex-col justify-center mr-3">
                        <span class="text-lg">0</span>
                        <span class="text-xs">Entregados</span>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="text-lg">0</span>
                        <span class="text-xs">Calificados</span>
                    </div>                    
                </div>
            </div>
        </div>
        <loading v-if="loading" />
    </div>
</template>

<script>
export default {
    name: 'rooms.show.task',
    components: {
    },
    data: () => ({
        loading: false,
        model: {
            point: 0
        },
        students: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
        data: {}
    }),
    created() {
        this.fetchData(this.$route.params.id)
    },
    methods: {
        async fetchData (id) {
            this.loading = true
            await this.$http.get('api/lms/tasks/' + id)
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

<style>
.min-h-pant {
    min-height: calc(100vh - 150px);
    max-height: calc(100vh - 150px);
}
</style>