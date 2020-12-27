<template>
    <div class="mt-10 md:mt-24 px-4">
        <div class="max-w-6xl mx-auto mb-4">
            <div class="px-4 md:px-10 w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <router-link :to="{ name: 'grades.index' }"
                    class="w-full bg-gray-100 rounded-lg text-center px-4 py-8 cursor-pointer hover:shadow text-gray-600 hover:text-gray-900">
                    <i class="fa fa-tags text-5xl"></i>
                    <p class="mt-4 text-sm">
                        Grados
                    </p>
                </router-link>

                <div class="w-full bg-gray-100 rounded-lg text-center px-4 py-8 cursor-pointer hover:shadow text-gray-600 hover:text-gray-900">
                    <i class="fa fa-list-alt text-5xl"></i>
                    <p class="mt-4 text-sm">
                        Calificaciones
                    </p>
                </div>

                <div class="w-full bg-gray-100 rounded-lg text-center px-4 py-8 cursor-pointer hover:shadow text-gray-600 hover:text-gray-900">
                    <i class="fa fa-cogs text-5xl"></i>
                    <p class="mt-4 text-sm">
                        Configuraciones
                    </p>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'settings-academic',
    data: () => ({
        rows: [1, 2, 3, 4, 5, 6, 7, 8, 9]
    })
}
</script>