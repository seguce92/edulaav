<template>
    <div class="mt-6 px-4 relative">
        <div class="lg:flex lg:items-center lg:justify-between container mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Cursos
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <div class="flex items-center mr-2 text-gray-700">Gestión</div>
                <div class="relative">
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        v-model="year" @change="onChange($event)">
                        <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mx-auto">
            <div v-for="(row, index) in data" :key="index">
                <div class="flex h-10 justify-between my-4 items-center border-b border-primary-400">
                    <h4 class="font-bold uppercase">{{ row.title }} <span class="text-primary-600 ml-2">{{ row.code }}</span></h4>
                    <div>
                        <span class="font-nunito">({{ row.total }})</span>
                        <router-link :to="{name:'rooms.create',params:{id:row.id}}" class="btn-small-outline md:ml-3" 
                            aria-label="Nueva Designación" data-balloon-pos="left">
                            <i class="fa fa-plus"></i>
                        </router-link>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <article v-for="(des, i) in row.rooms" :key="i"
                        class="bg-white rounded border hover:border-r-4 hover:border-primary-700 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="h-3 bg-primary-700 rounded-t"></div>
                        <div class="flex flex-col px-4 py-3 font-nunito">
                            <h3 class="font-bold text-lg relative items-center">
                                <a class="cursor-pointer hover:underline uppercase" @click="showRoom(des.id)">{{ des.group }}</a>
                                <i v-if="env_delete()" @click="deleteRow(des.id)"
                                    class="fa fa-times cursor-pointer absolute right-0 top-0 text-sm text-primary-600 hover:text-primary-900"></i>
                            </h3>
                            <div class="flex justify-between">
                                <h4 class="text-xs text-gray-800 uppercase font-bold tracking-tighter">
                                    <i class="fas fa-bezier-curve mr-2"></i>
                                    Designaciones {{ des.designations }}</h4>
                                <h4 class="text-xs text-gray-800 uppercase font-bold tracking-tighter">
                                    <i class="fas fa-users mr-2"></i>
                                    Estudiantes {{ des.students }}</h4>
                            </div>
                            <div class="flex items-center py-2 text-gray-800">
                                <i class="fa fa-user text-sm mr-3"></i>
                                <span class="text-sm font-nunito tracking-tighter">{{ des.adviser ? des.adviser : 'Sin Asesor' }}</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>

        <div v-if="showDelete" class="absolute bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
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
                        Eliminar 
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm leading-5 text-gray-500">
                            ¿Estás seguro de que deseas realizar esta acción? Todos sus datos serán eliminados permanentemente. Esta acción no se puede deshacer.
                        </p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button @click="confirm()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Eliminar
                    </button>
                </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button @click="cancel()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Cancelar
                    </button>
                </span>
                </div>
            </div>
        </div>
        <loading v-if="loading" />
    </div>
</template>

<script>
export default {
    name: 'designations',
    data: () => ({
        year: new Date().getFullYear(),
        years: [],
        data: [],
        showDelete: false,
        delete: null,
        loading: false
    }),
    created() {
        this.createdYears()
        this.fetchData()
    },
    mounted() {
        if (localStorage.year) {
            this.year = localStorage.year;
        }
    },
    watch: {
        year(year) {
            localStorage.year = year;
        }
    },
    methods: {
        createdYears: function (year) {
            for ( var i = this.year - 15; i < this.year + 3; i++) {
                this.years.push(i);
            }
        },
        async fetchData () {
            this.loading = true
            let model = {
                year: this.year
            }
            await this.$http.post('api/academic/rooms/index', model)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        deleteRow: function (id) {
            this.delete = id
            this.showDelete = true
        },
        confirm: function () {
            this.deleteData(this.delete)
            this.showDelete = false
            this.delete = null
        },
        cancel: function () {
            this.showDelete = false
        },
        async deleteData (id) {
            this.loading = true
            await this.$http.delete('api/academic/rooms/' + id)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.$toast.success("Curso eliminado exitosamente.")
                        this.fetchData()
                    }
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },

        onChange(event) {
            this.fetchData()
        },

        showRoom: function (id) {
            this.$router.push({name: 'rooms.show',params:{id:id} })
        }
    }
}
</script>