<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="w-full md:w-1/2 flex flex-wrap justify-between md:justify-start">
                <div class="relative inline-flex w-1/5 md:w-auto">
                    <select @change="changePerpage($event)" :value="rows" class="block appearance-none w-full mr-1 bg-gray-100 border text-gray-700 py-2 px-3 pr-6 rounded leading-tight focus:outline-none focus:bg-white">
                        <option v-for="row in rows_limit" :key="row" :value="row">{{ row }}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
                <div class="relative inline-flex w-4/5 md:w-auto" :class="searching ? '' : 'hidden'">
                    <input type="text" placeholder="Buscar" v-model="search" 
                        class="bg-gray-100 text-sm text-gray-800 transition border focus:outline-none w-full md:max-w-xs rounded py-2 px-2 pl-10 appearance-none leading-normal"
                        @keydown.enter="searchData">
                    <div class="absolute search-icon top-0 mt-3 ml-4">
                        <svg class="w-4 h-4 fill-current pointer-events-none text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7a23.9 23.9 0 0033.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex justify-between md:justify-end lg:mt-0 lg:ml-4 overflow-x-auto pt-2 md:pt-0">
                <slot name="tools"></slot>
            </div>
        </div>
        <div class="flex flex-col relative">
            <div v-if="loading" class="absolute rounded mt-3 bg-loading inset-0 z-20 flex flex-col items-center justify-center">
                <square-spinner
                    :animation-duration="1000"
                    :size="65"
                    :color="'#D53F8C'"
                    class="align-middle"
                />
                <div class="mt-6 text-pink-700 font-nunito bg-white px-4 py-1 rounded-full shadow-lg">Procesando Información, Espere por favor</div>
            </div>
            <div class="pt-2 overflow-x-auto relative">
                <div class="table sm:rounded-t">
                    <table>
                        <thead>
                            <tr>
                                <th v-for="(col, index) in cols" :key="index">{{ col.value }}</th>
                                <th v-if="action"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, key) in data" :key="key">
                                <td v-for="col in cols" :key="col.name">{{ getValue(row, col.name) | truncate }}</td>
                                <td v-if="action" class="text-right">
                                    <slot name="action" :row="row"></slot>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white px-4 py-2 flex items-center justify-between border-gray-200 sm:px-6 sm:rounded-b">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a @click="prevPage" 
                        :class="pagination.prev_page_url != null ? 'cursor-pointer hover:bg-gray-200' : 'cursor-not-allowed'"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded text-gray-700 bg-white focus:outline-none transition ease-in-out duration-150">
                        Anterior
                    </a>
                    <p class="text-sm leading-5 text-gray-700 sm:hidden p-2">
                        <span class="font-medium">{{ pagination.from }}</span>
                        al
                        <span class="font-medium">{{ pagination.to }}</span>
                        de
                        <span class="font-medium">{{ pagination.total }}</span>
                    </p>
                    <a @click="nextPage"
                        :class="pagination.next_page_url != null ? 'cursor-pointer hover:bg-gray-200' : 'cursor-not-allowed'" 
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded text-gray-700 bg-white focus:outline-none transition ease-in-out duration-150">
                        Siguiente
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm leading-5 text-gray-700">
                            Mostrando
                            <span class="font-medium">{{ pagination.from }}</span>
                            al
                            <span class="font-medium">{{ pagination.to }}</span>
                            de
                            <span class="font-medium">{{ pagination.total }}</span>
                            resultados
                        </p>
                    </div>
                    <div class="flex items-center">
                        <a @click="prevPage" 
                            :class="pagination.prev_page_url != null ? 'cursor-pointer text-gray-700 hover:bg-gray-200' : 'cursor-not-allowed text-gray-400'"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        
                        <a v-for="page in pagesNumber" :key="page"
                            @click="makeUrl(page)"
                            :class="pagination.current_page == page ? 'cursor-not-allowed bg-gray-200 text-gray-400 shadow-inner' : 'cursor-pointer text-gray-700 hover:bg-gray-200'"
                            class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 focus:z-10 transition ease-in-out duration-150">
                            {{ page }}</a>

                        <a @click="nextPage"
                            :class="pagination.next_page_url != null ? 'cursor-pointer text-gray-700 hover:bg-gray-200' : 'cursor-not-allowed text-gray-400'" 
                            rel="next" 
                            class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium focus:z-10 focus:outline-none transition ease-in-out duration-150">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SquareSpinner from './SquareSpinner'

export default {
    name: 'data-table',
    components: {
        SquareSpinner
    },
    props: {
        api: {
            type: String
        },
        action: {
            type: Boolean,
            default: true
        },
        cols: {
            type: Array,
            default: () => []
        },
        searching: {
            type: Boolean,
            default: false
        },
        rows: {
            type: Number,
            default: 8
        }
    },
    data: () => ({
        rows_limit: [8, 15, 25, 50, 100],
        search: '',
        data: [],
        pagination: {},
        max_pages: 6,
        pages: [],
        offset: 2,
        loading: false,
        perPage: 8
    }),
    created(){
        this.perPage = this.rows
        this.fetchData(this.api + '?perPage=' + this.perPage)
        this.$parent.$on('updateDataTable', this.refreshData);
    },
    computed: {
        pagesNumber() {
            if (!this.pagination.to) {
                return [];
            }
            let from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            let to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            let pagesArray = [];
            for (let page = from; page <= to; page++) {
                pagesArray.push(page);
            }
            return pagesArray;
        }
    },
    methods: {
        async fetchData(url) {
            this.loading = true
            await this.$http.get(url)
                .then((response) => {
                    this.data = response.data.data
                    this.updatePagination(response.data)
                }).catch((response) => {
                    this.$toast.error("Error de carga de datos")
                });
            this.loading = false
        },

        updateUrl: function (url) {
            if ( url != null) {
                this.fetchData(url)
            }
        },

        updatePagination: function (data) {
            this.pagination = {
                current_page: data.current_page,
                first_page_url: data.first_page_url,
                from: data.from,
                last_page: data.last_page,
                last_page_url: data.last_page_url,
                next_page_url: data.next_page_url,
                path: data.path,
                per_page: data.per_page,
                prev_page_url: data.prev_page_url,
                to: data.to,
                total: data.total
            }
        },

        nextPage: function () {
            let page = 0
            if ( this.pagination.current_page + 1 <= this.pagination.last_page ) {
                page = this.pagination.current_page + 1
                this.makeUrl(page)
            }
        },

        prevPage: function () {
            let page = 0
            if ( this.pagination.current_page > 1 ) {
                page = this.pagination.current_page - 1
                this.makeUrl(page)
            }
        },

        makeUrl: function ( page, x = false ) {
            if ( this.pagination.current_page != page || x) {
                let url = '';
                if ( this.api.includes('?') )
                    url = this.api + '&perPage=' + this.perPage + '&page=' + page + '&q=' + this.search
                else
                    url = this.api + '?perPage=' + this.perPage + '&page=' + page + '&q=' + this.search
                this.updateUrl(url)
            }
        },

        searchData: function () {
            this.makeUrl(this.pagination.current_page, true)
        },

        refreshData: function (){
            this.makeUrl(this.pagination.current_page, true)
        },

        changePerpage: function (event) {
            this.perPage = event.target.value
            this.rows = event.target.value
            this.makeUrl(1, true)
        },

        getValue: function (row, name) {
            if ( typeof row == 'undefined' || typeof name == 'undefined' || row == null || name == null )
                return ''
            if ( name.includes('.') == false )
                return row[name]
            let values = name.split(".")
            let value = row
            values.forEach(element => {
                value = value[element]
            });
            return (value != null && typeof value != 'undefined' && value.length > 0) ? value : '-'
        }
    }
}
</script>