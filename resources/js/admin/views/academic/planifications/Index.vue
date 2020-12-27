<template>
<div class="mt-6 px-4 relative">
        <div class="lg:flex lg:items-center lg:justify-between container mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Grados
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 row-gap-8 col-gap-4">
                <article v-for="(row, i) in data" :key="i"
                    class="bg-white rounded border hover:border-r-4 hover:border-primary-700 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:shadow-lg cursor-pointer"
                    @click="showDocuments(row.id)">
                    <div class="h-3 bg-primary-700 rounded-t"></div>
                    <div class="flex flex-col px-4 py-3 font-nunito">
                        <h3 class="font-bold text-lg relative items-center">
                            <a class="cursor-pointer hover:underline uppercase">{{ row.title }}</a>
                        </h3>
                        <h4 class="text-xs text-gray-800 uppercase font-bold tracking-tighter">{{ row.code }}</h4>
                        <div class="flex items-center py-2 text-gray-800">
                            <i class="fa fa-file text-sm mr-2"></i>
                            <span class="text-sm font-nunito tracking-tighter">{{ row.documents }}</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <loading v-if="loading" />
    </div>
</template>

<script>
import Filemanager from '@/components/Filemanager/Index.vue'
export default {
    name: 'planifications.index',
    components: {
        Filemanager
    },
    data: () => ({
        year: new Date().getFullYear(),
        years: [],
        loading: false,
        data: [],
        model: {}
    }),
    created(){
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
            await this.$http.get('api/academic/documents/get-grades?year='+this.year)
                .then((response) => {
                    this.data = response.data.data
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
        showDocuments: function (id) {
            this.$router.push({name:'planifications.show',params:{id:id}})  
        },
        onChange(event) {
            this.fetchData()
        },
        submit: function () {
            console.log(this.model)
        }
    }
}
</script>