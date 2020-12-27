<template>
    <nav class="z-50 md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-no-wrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-sidebar z-10 md:py-4 px-4">
        <div class="md:flex-col md:items-stretch md:min-h-full md:flex-no-wrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
            <button class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                type="button" v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')">
                    <i class="fas fa-bars"></i>
            </button>
            <a class="flex items-center md:pb-2 text-gray-900 mr-0 uppercase font-bold p-4 px-3"
                href="/">
                <img :src="asset('android-icon-48x48.png')" class="h-8 mr-3"> 
                <span class="text-lg">Edulaav</span>
            </a>
            <!-- User -->
            <ul class="md:hidden items-center flex flex-wrap list-none">
                <li class="inline-block relative">
                    <notification-dropdown-component></notification-dropdown-component>
                </li>
                <li class="inline-block relative">
                    <user-dropdown-component></user-dropdown-component>
                </li>
            </ul>
            
            <div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
                v-bind:class="collapseShow">
                <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-gray-300">
                    <div class="flex flex-wrap">
                        <div class="w-6/12">
                            <a class="md:block text-left md:pb-2 text-gray-700 mr-0 inline-block whitespace-no-wrap text-sm uppercase font-bold p-4 px-0"
                                href="/">
                                Edulaav
                            </a>
                        </div>
                        <div class="w-6/12 flex justify-end">
                            <button type="button"
                                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                                v-on:click="toggleCollapseShow('hidden')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <ul class="md:flex-col md:min-w-full flex flex-col list-none sidebar">
                    <li>
                        <router-link :to="{ name: 'home' }">
                            <i class="fas fa-tv opacity-75 text-sm"></i>
                            <span>Escritorio</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'users.index' }">
                            <i class="fas fa-users text-sm"></i>
                            Usuarios
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'teachers.index' }">
                            <i class="fas fa-id-card-alt text-sm"></i>
                            <span>Docentes</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'students.index' }">
                            <i class="fas fa-user-friends text-sm"></i>
                            <span>Estudiantes</span>
                        </router-link>
                    </li>
                    <li>
                        <hr class="mx-4 my-2">
                    </li>
                    <li>
                        <router-link :to="{ name: 'rooms' }">
                            <i class="fas fa-kaaba text-sm"></i>
                            <span>Cursos</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'designations' }">
                            <i class="fas fa-bezier-curve text-sm"></i>
                            <span>Designaciones</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'planifications' }">
                            <i class="fas fa-bookmark text-sm"></i>
                            <span>Material de Apoyo</span>
                        </router-link>
                    </li>
                    <li>
                        <hr class="mx-4 my-2">
                    </li>
                    <li>
                        <router-link :to="{ name: 'academic' }">
                            <i class="fas fa-cog text-sm"></i>
                            <span>Configuración Académica</span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
import NotificationDropdownComponent from "./NotificationDropdown.vue";
import UserDropdownComponent from "./UserDropdown.vue";
export default {
    data: () => ({
        collapseShow: "hidden"
    }),
    methods: {
        toggleCollapseShow: function(classes) {
            this.collapseShow = classes;
        }
    },
    components: {
        NotificationDropdownComponent,
        UserDropdownComponent
    }
};
</script>