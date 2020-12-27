<template>
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-center font-nunito border-b">
            <ul class="border-b flex shadow-lg">
                <router-link :to="{name:'rooms.show',params:{id:$route.params.id}}" 
                    class="text-primary-500 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform rounded-tl-md">
                    Acerca de
                </router-link>
                <router-link :to="{name:'rooms.task',params:{id:$route.params.id}}" 
                    class="px-6 lg:px-10 text-primary-700 border-b-4 border-primary-900 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform">
                    Tareas
                </router-link>
                <router-link :to="{name:'rooms.student',params:{id:$route.params.id}}" 
                    class="text-primary-500 px-6 lg:px-10 cursor-pointer py-3 bg-white hover:bg-primary-100 hover:text-primary-700 transition duration-500 ease-in-out transform rounded-tr-md">
                    Estudiantes
                </router-link>
            </ul>
        </div>
        <div class="mt-4">
            <div class="font-nunito">
                <button class="bg-primary-800 hover:bg-primary-700 text-white px-6 py-2 rounded-full shadow-md focus:outline-none"
                    v-on:click="toggleDropdown($event)" ref="btnDropdownRef">
                    <i class="fa fa-plus mr-2"></i> Nuevo
                </button>
                <div ref="popoverDropdownRef"
                    class="bg-white text-base z-50 float-left list-none text-left rounded shadow-lg mt-1 py-1"
                    v-bind:class="{
                        hidden: !dropdownPopoverShow,
                        block: dropdownPopoverShow
                    }"
                    style="min-width:15rem">
                    <a @click="onToggleModalTopic()"
                        class="cursor-pointer py-3 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-200">
                        <i class="fa fa-list-alt w-6"></i>
                        Tema
                    </a>
                    <div class="h-0 border-b border-solid border-primary-500" />
                    <a @click="onToggleModalMaterial()"
                        class="cursor-pointer py-3 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-200">
                        <i class="far fa-file w-6"></i> Material
                    </a>
                    <a @click="onToggleModalTask()"
                        class="cursor-pointer py-3 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-200">
                        <i class="fa fa-file-alt w-6"></i> Tarea
                    </a>
                </div>
                <article v-for="(row, index) in data" :key="index" 
                    class="bg-white rounded-md mt-4 pt-2 shadow-lg mb-4">
                    <h2 class="flex text-primary-800 border-b border-primary-700 px-4 pb-2 font-bold text-xl justify-between">
                        <span>{{ row.title }}</span>
                        <div class="relative inline-block text-left">
                            <div class="dropdown">
                                <button class="w-10 h-10 ml-2 rounded-full text-primary-800 hover:bg-primary-200 focus:outline-none active:bg-primary-400">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu absolute hidden right-0 w-24 rounded-md shadow-lg bg-white z-50">
                                    <div class="rounded-md bg-white shadow-xs">
                                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                            <a @click="editTopic(row.id)" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 cursor-pointer" role="menuitem">
                                                Editar</a>
                                            <a v-if="row.tasks.length == 0" @click="deleteRowTopic(row.id)" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 cursor-pointer" role="menuitem">
                                                Eliminar</a>
                                            <a v-else class="block px-4 py-2 text-sm leading-5 text-gray-400 focus:outline-none focus:bg-gray-100 focus:text-gray-900 cursor-pointer" role="menuitem">
                                                Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </h2>
                    <div class="font-nunito">
                        <div v-for="(task, i) in row.tasks" :key="i" 
                            class="flex px-4 py-3 cursor-pointer items-center border-b item-task">
                            <a class="w-10 h-10 bg-primary-700 rounded-full items-center flex justify-center mr-2 text-white" :aria-label="task.type == 'task' ? 'Tarea' : 'Material'" data-balloon-pos="right">
                                <i v-if="task.type == 'task'" class="far fa-file-alt"></i>
                                <i v-else class="far fa-file"></i>
                            </a>
                            <div class="flex w-full justify-between items-center">
                                <div class="truncate">{{ task.title }}
                                    <h4>
                                        <router-link :to="{name:'rooms.task.show',params:{designation:$route.params.id,id:task.id}}"
                                            class="text-sm hover:underline hover:text-blue-500">
                                            {{ task.type == 'task' ? 'Ver Tarea' : 'Ver Material' }}
                                        </router-link>
                                    </h4>
                                </div>
                                <div>
                                    <span v-if="task.date != null" class="text-xs text-gray-500">Fecha de Entrega {{ task.date }} {{ task.time ? task.time : '' }}</span>
                                    <span v-else class="text-xs text-gray-500">Publicado {{ task.created }}</span>
                                    <div class="relative inline-block text-left">
                                        <div class="dropdown z-50">
                                            <button class="button-task">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu absolute hidden right-0 w-24 rounded-md shadow-lg z-50">
                                                <div class="rounded-md bg-white shadow-xs">
                                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                        <a @click="editTask(task.id, task.type)" 
                                                            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 cursor-pointer" role="menuitem">
                                                            Editar</a>
                                                        <a @click="deleteRowTask(task.id, task.type)" 
                                                            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem">
                                                            Eliminar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
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
    name: 'rooms.task',
    components: {
    },
    data: () => ({
        loading: false,
        data: [],
        errors: [],
    }),
    created() {
        this.fetchData()
        this.videoroom = window.Settings.ui.videoroom
    },
    methods: {
        async fetchData () {
            this.loading = true
            let id = this.$route.params.id
            await this.$http.get('api/lms/topics/index/' + id)
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

<style lang="scss">
    .item-task {
        .button-task {
            @apply w-10 h-10 ml-2 rounded-full text-white;
        }
        .button-task:hover {
            @apply bg-primary-200 shadow-lg;
        }
        .button-task:focus {
            @apply outline-none;
        }
        .button-task:active {
            @apply bg-primary-400 shadow-lg outline-none;
        }
        h5 {
            @apply text-sm tracking-tight;
        }
        date {
            @apply tracking-tight;
        }
    }
    .item-task:hover {
        @apply shadow-lg;
        .button-task {
            @apply visible text-primary-800;
        }
    }
</style>