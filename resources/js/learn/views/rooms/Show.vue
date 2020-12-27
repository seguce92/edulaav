<template>
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-center font-nunito border-b">
            <ul class="border-b flex shadow">
                <router-link :to="{name:'rooms.show',params:{id:$route.params.id}}" 
                    class="px-6 lg:px-10 cursor-pointer py-3 bg-white text-primary-700 border-b-4 border-primary-900 hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform rounded-tl-md">
                    Acerca de
                </router-link>
                <router-link :to="{name:'rooms.task',params:{id:$route.params.id}}" 
                    class="text-primary-500 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform">
                    Tareas
                </router-link>
                <router-link :to="{name:'rooms.student',params:{id:$route.params.id}}" 
                    class="text-primary-500 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform rounded-tr-md">
                    Estudiantes
                </router-link>
            </ul>
        </div>
        <div class="mt-4">
            <div class="h-56 pattern-1 rounded-md container mx-auto px-6 py-4 shadow-lg relative">
                <span class="text-primary-100 text-base lg:text-xl xl:text-3xl font-serif tracking-wide font-bold bg-primary-700 px-2">
                    {{ data.subject }}
                </span>
                <div>
                    <span class="text-white uppercase bg-primary-700 px-2">{{ data.room }}</span>
                </div>
                <div>
                    <span class="text-primary-200 font-nunito bg-primary-700 px-2">{{ data.teacher }}</span>
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
    name: 'rooms.show',
    components: {

    },
    data: () => ({
        loading: false,
        data: {},
        videoroom: false
    }),
    created() {
        this.fetchRoom(this.$route.params.id);
        this.videoroom = window.Settings.ui.videoroom
    },
    methods: {
        async fetchRoom (id) {
            this.loading = true
            await this.$http.get('api/learn/rooms/' + id)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        }
    }
}
</script>