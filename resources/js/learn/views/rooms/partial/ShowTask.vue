<template>
    <div class="max-w-6xl mx-auto relative">
        <router-link :to="{name:'rooms.task',params:{id:$route.params.designation}}"
            class="absolute top-0 px-4 py-1 bg-white shadow rounded mt-2">
            <i class="fa fa-arrow-left"></i>
        </router-link>
        <div class="flex justify-center font-nunito border-b">
            <ul class="border-b flex shadow-lg">
                <router-link :to="{name:'rooms.task.show',params:{designation:$route.params.designation,id:$route.params.id}}"
                    class="text-primary-700 border-b-4 border-primary-900 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform rounded-tl-md">
                    {{ data.type == 'task' ?  'Instrucciones de la Tarea' : 'Información' }}
                </router-link>
                <router-link v-if="data.type == 'task'" :to="{name:'rooms.task.review',params:{designation:$route.params.id,id:$route.params.id}}"
                    class="px-6 lg:px-10 text-primary-500 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform">
                    Tareas de los Estudiantes
                </router-link>
            </ul>
        </div>
        <div class="mt-4 font-nunito bg-white shadow-lg rounded-lg px-4">
            <div class="pt-6">
                <h1 class="text-xl md:text-2xl font-bold text-primary-800 mb-1">{{ data.title }}</h1>
                <p class="text-sm text-primary-500 mb-1">{{ data.teacher }} . {{ data.created_at }}</p>
                <div v-if="data.type == 'task'" class="flex justify-between text-sm pb-2">
                    <span>{{ data.points }} Puntos</span>
                    <span>Fecha de Entrega {{ data.date }} {{ data.time }}</span>
                </div>
                <div v-html="parse" class="markdown-body mt-2 text-primary-700 border-t border-primary-500 pt-2 font-nunito"></div>
            </div>
            <div class="flex mt-4 pb-4">
                <div class="relative w-full">
                    <a v-for="(row, index) in data.array_files" :key="index"
                        :href="asset(row.path)" target="_blank"
                        class="p-3 flex items-start space-x-4 border rounded-lg hover:bg-gray-200 transition ease-in-out duration-150 mb-2 relative cursor-pointer">
                        <i v-if="row.extension == 'txt'" class="far fa-file-alt flex-shrink-0 icon-file text-primary-800 mt-1"></i>
                        <i v-else-if="row.extension == 'pdf'" class="far fa-file-pdf flex-shrink-0 icon-file text-red-700 mt-1"></i>
                        <i v-else-if="row.extension == 'zip' || row.extension == 'rar'" class="far fa-file-archive flex-shrink-0 icon-file text-primary-800 mt-1"></i>
                        <i v-else-if="row.extension == 'doc' || row.extension == 'docx'" class="far fa-file-word flex-shrink-0 icon-file text-blue-700 mt-1"></i>
                        <i v-else-if="row.extension == 'xls' || row.extension == 'xlsx'" class="far fa-file-excel flex-shrink-0 icon-file text-green-700 mt-1"></i>
                        <i v-else-if="row.extension == 'pptx' || row.extension == 'ppt'" class="far fa-file-powerpoint flex-shrink-0 icon-file text-orange-700 mt-1"></i>
                        <i v-else-if="row.extension == 'mp4' || row.extension == 'avi' || row.extension == 'flv' || row.extension == 'webm'" class="far fa-file-video flex-shrink-0 icon-file text-blue-800 mt-1"></i>
                        <i v-else-if="row.extension == 'jpg' || row.extension == 'png' || row.extension == 'gif' || row.extension == 'bmp'" class="far fa-file-image flex-shrink-0 icon-file text-blue-900 mt-1"></i>
                        <i v-else class="fa fa-align-center flex-shrink-0 icon-file text-primary-800 mt-1"></i>
                        <div class="space-y-1 w-full overflow-hidden">
                            <p class="text-base leading-6 font-medium text-gray-900 cursor-pointer">
                                {{ row.name }}
                            </p>
                            <p class="text-sm leading-5 text-gray-500 truncate transition ease-in-out duration-150 uppercase">
                                {{ row.extension }}
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <loading v-if="loading" />
    </div>
</template>

<script>
import marked from 'marked'
export default {
    name: 'rooms.show.task',
    components: {
    },
    data: () => ({
        loading: false,
        data: {},
    }),
    created() {
        this.fetchData(this.$route.params.id)
    },
    computed: {
        parse() {
            return this.data.content != null ? marked(this.data.content) : marked('')
        }
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
    .icon-file {
        font-size: 2.5rem;
    }
</style>