<template>
    <div class="my-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <article v-for="(row, i) in data" :key="i"
                @click="showRoom(row.id)"
                class="bg-white rounded-lg border transition duration-500 ease-in-out transform hover:-translate-y-1 hover:shadow-lg cursor-pointer">
                <div class="flex flex-1 px-4 py-4 font-nunito">
                    <div class="flex flex-col rounded-lg w-10 h-10 bg-primary-300 justify-center items-center mr-2 uppercase font-bold hover:shadow cursor-pointer">
                        {{ row.parallel }}
                    </div>
                    <div class="flex-1 pl-1">
                        <span class="text-primary-700 font-bold">{{ row.title }}</span>
                        <div class="text-gray-600 text-xs tracking-tighter font-semibold uppercase">{{ row.room }}</div>
                        <div class="text-gray-600 text-xs">{{ row.students }} Estudiantes</div>
                    </div>
                </div>
            </article>
        </div>
        <loading v-if="loading" />
    </div>
</template>

<script>
export default {
    name: 'rooms-index',
    components: {

    },
    data: () => ({
        loading: false,
        data: []
    }),
    created() {
        this.fetchData()
    },
    methods: {
        showRoom: function (id) {
            this.$router.push({name:'rooms.show',params:{id:id}})
        },
        async fetchData () {
            this.loading = true
            await this.$http.get('api/learn/rooms',)
                .then((response) => {
                    this.data = response.data.data
                    console.log(response.data.data)
                }).catch((response) => {
                    this.$toast.error()
                });
            this.loading = false
        },
    }
}
</script>