<template>
    <div>
        <div class="flex justify-center font-nunito border-b">
            <ul class="border-b flex">
                <router-link :to="{name:'rooms.show',params:{id:$route.params.id}}" 
                    class="text-primary-500 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform rounded-tl-md">
                    Acerca de
                </router-link>
                <router-link :to="{name:'rooms.task',params:{id:$route.params.id}}" 
                    class="text-primary-500 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform">
                    Tareas
                </router-link>
                <router-link :to="{name:'rooms.student',params:{id:$route.params.id}}" 
                    class="text-primary-700 border-b-4 border-primary-900 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform rounded-tr-md">
                    Estudiantes
                </router-link>
            </ul>
        </div>
        <div class="mt-4">
            <div class="rounded-md max-w-6xl mx-auto">
                <div class="flex flex-col">
                    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Apellidos y Nombres
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            CI
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            RUDE
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(row, index) in data" :key="index" 
                                        class="hover:bg-primary-100">
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-400">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" 
                                                        :src="row.avatar"
                                                        :alt="row.email">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                                        {{ row.lastname }} {{ row.name }}
                                                    </div>
                                                    <div class="text-sm leading-5 text-gray-500">
                                                        {{ row.email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-400">
                                            <div class="text-sm leading-5 text-gray-900">{{ row.ci }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-400">
                                            <div class="text-sm leading-5 text-gray-900">{{ row.rude }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-400 text-sm leading-5 font-medium">
                                            <a v-if="row.is_birthday" :aria-label="row.name + ' está de Cumpleaños!'" data-balloon-pos="left">
                                                <i class="fa fa-birthday-cake text-primary-700"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <loading v-if="loading" />

        <router-link v-if="videoroom" :to="{name:'rooms.video', params:{id:$route.params.id}}"
            class="rounded-full h-16 w-16 bg-primary-800 text-white px-2 py-2 absolute bottom-0 right-0 mr-5 mb-5 flex items-center justify-center hover:bg-primary-700"
            title="INICIAR VIDEO CONFERENCIA">
            <i class="fa fa-video text-2xl"></i>
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'rooms.student',
    components: {

    },
    data: () => ({
        loading: false,
        data: [],
        videoroom: false
    }),
    created() {
        this.fetchData(this.$route.params.id)
        this.videoroom = window.Settings.ui.videoroom
    },
    methods: {
        async fetchData (id) {
            this.loading = true
            await this.$http.get('api/learn/rooms/lists/students?room=' + id)
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