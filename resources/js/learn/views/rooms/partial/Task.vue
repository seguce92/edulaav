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

        <new-task v-model="show.task" :id="id.task" ref="taskComponent" @keydown.esc="onToggleModalTask" />
        <new-material v-model="show.material" :id="id.material" ref="materialComponent" @keydown.esc="onToggleModalMaterial" />

        <div v-if="show.topic" class="absolute bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center font-nunito">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex">
                        <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">
                                {{ topicStore ? 'Nuevo tema' : 'Editar Tema' }}
                            </h3>
                            <div class="mt-2 flex">
                                <div class="w-full">
                                    <div class="mb-3 pt-0">
                                        <input type="text" placeholder="Título de Tema" 
                                            required
                                            v-model="model.title"
                                            autofocus
                                            class="px-3 py-3 placeholder-gray-400 text-gray-700 relative bg-gray-200 rounded text-sm shadow outline-none focus:outline-none focus:bg-white focus:border-primary-700 w-full"/>
                                    </div>
                                    <error-field :errors="set_error(errors, 'title')"></error-field>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 mb-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button @click="confirmTopic()" type="button" 
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-primary-700 text-base leading-6 font-medium text-white shadow-sm hover:bg-primary-600 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            {{ topicStore ? 'Registrar' : 'Actualizar' }}
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button @click="cancelTopic()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancelar
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div v-if="show.topicDelete" class="absolute bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center font-nunito">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Eliminar Tema
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm leading-5 text-gray-500">
                                    ¿Estás seguro de eliminar este Tema? Todos sus datos serán eliminados permanentemente. Esta acción no se puede deshacer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button @click="confirmTopicDelete()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Eliminar
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button @click="cancelTopicDelete()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancelar
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div v-if="show.taskDelete" class="absolute bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center font-nunito">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Eliminar {{ taskType == 'task' ? 'Tarea' : 'Material' }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm leading-5 text-gray-500">
                                    ¿Estás seguro de eliminar esta {{ taskType == 'task' ? 'Tarea' : 'Material' }}? Todos sus datos serán eliminados permanentemente. Esta acción no se puede deshacer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button @click="confirmTaskDelete()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Eliminar
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button @click="cancelTaskDelete()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancelar
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Popper from "popper.js"
import NewTask from './NewTask'
import NewMaterial from './NewMaterial'
export default {
    name: 'rooms.task',
    components: {
        NewTask,
        NewMaterial
    },
    data: () => ({
        loading: false,
        dropdownPopoverShow: false,
        data: [],
        show: {
            task: false,
            material: false,
            topic: false,
            topicDelete: false,
            taskDelete: false
        },
        errors: [],
        model: {},
        topicStore: true,
        topicId: null,
        taskId: null,
        taskType: 'task',
        videoroom: false,
        id: {
            task: null,
            material: null
        }
    }),
    created() {
        this.fetchData()
        this.$root.$on('updateListTask', this.fetchData);
        this.initialize()  
        this.videoroom = window.Settings.ui.videoroom
    },
    methods: {
        initialize: function () {
            this.model = {
                designation_id: this.$route.params.id,
                title: ''
            }
        },
        toggleDropdown: function(event) {
            event.preventDefault();
            if (this.dropdownPopoverShow) {
                this.dropdownPopoverShow = false;
            } else {
                this.dropdownPopoverShow = true;
                new Popper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
                    placement: "bottom-start"
                });
            }
        },

        onToggleModalTask () {
            this.show.task = !this.show.task
            this.dropdownPopoverShow = false
        },

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

        onToggleModalMaterial () {
            this.show.material = !this.show.material
            this.dropdownPopoverShow = false
        },

        onToggleModalTopic () {
            this.show.topic = !this.show.topic
            this.dropdownPopoverShow = false
            this.initialize()
        },

        cancelTopic: function () {
            this.show.topic = false
            this.topicStore = true
            this.initialize()
        },
        confirmTopic: function () {
            this.show.topic = false
            if (this.topicStore)
                this.storeTopic()
            else
                this.updateTopic()
        },

        async storeTopic () {
            this.loading = true
            await this.$http.post('api/lms/topics', this.model)
                .then((response) => {
                    this.fetchData()
                    this.topicStore = true
                    this.initialize()
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        editTopic: function (id) {
            this.onToggleModalTopic()
            this.topicStore = false
            this.fetchTopic(id)
        },

        async fetchTopic (id) {
            this.loading = true
            await this.$http.get('api/lms/topics/' + id)
                .then((response) => {
                    this.model = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        async updateTopic () {
            this.loading = true
            await this.$http.put('api/lms/topics/' + this.model.id, this.model)
                .then((response) => {
                    this.fetchData()
                    this.topicStore = true
                    this.initialize()
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        deleteRowTopic: function (id) {
            this.show.topicDelete = true
            this.topicId = id
        },
        cancelTopicDelete: function () {
            this.show.topicDelete = false
            this.topicId = null
        },
        confirmTopicDelete: function () {
            this.show.topicDelete = false
            this.deleteTopic()
        },

        async deleteTopic () {
            this.loading = true
            await this.$http.delete('api/lms/topics/' + this.topicId)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.fetchData()
                        this.$toast.success('Tema eliminado exitosamente.')
                    } else {
                        this.$toast.warning('Lo siento no se puede eliminar, el tema tiene información dependiente.')
                    }
                    this.topicId = null
                    
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        /**
         * Edit sections
         */
        editTask: function (id, type) {
            if ( type == 'task' ) {
                this.id.task = id
                this.onToggleModalTask()
            } else {
                this.id.material = id
                this.onToggleModalMaterial()
            }

            this.$emit('fetchTask', id)
        },
        deleteRowTask: function (id, type) {
            this.show.taskDelete = true
            this.taskType = type
            this.taskId = id
        },
        cancelTaskDelete: function () {
            this.show.taskDelete = false
            this.taskType = 'task'
            this.taskId = null
        },
        confirmTaskDelete: function () {
            this.show.taskDelete = false
            this.deleteTask()
        },
        async deleteTask () {
            this.loading = true
            await this.$http.delete('api/lms/tasks/' + this.taskId)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.fetchData()
                        if ( this.taskType == 'task' )
                            this.$toast.success('Tarea eliminado exitosamente.')
                        else
                            this.$toast.success('Material eliminado exitosamente.')
                    } else {
                        if ( this.taskType == 'task' )
                            this.$toast.warning('Lo siento no se puede eliminar la tarea, tiene información dependiente.')
                        else
                            this.$toast.warning('Lo siento no se puede eliminar el material, tiene información dependiente.')
                    }
                    this.taskId = null
                    this.taskType = 'task'
                    
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