<template>
    <div class="px-4 py-8 max-w-6xl mx-auto">
        <data-table api="api/core/users" :cols="cols" :action="true" :searching="true">
            <template slot="tools">
                <router-link :to="{ name: 'users.create' }" class="btn-small-outline md:ml-3">
                    <i class="fa fa-plus mr-1"></i>
                    Nuevo Usuario
                </router-link>
            </template>
            <template v-slot:action="slotProps">
                <router-link :to="{name:'users.show',params:{id:slotProps.row.id}}" aria-label="Ver" data-balloon-pos="left" class="inline-block mr-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <i class="fa fa-eye"></i>
                </router-link>
                <router-link :to="{namee:'users.edit', params:{id:slotProps.row.id}}" aria-label="Editar" data-balloon-pos="left" class="inline-block text-gray-500 hover:text-gray-800 cursor-pointer">
                    <i class="fa fa-edit"></i>
                </router-link>
                <a v-if="slotProps.row.is_active" @click="disableUser(slotProps.row.id)" aria-label="Dar de baja" data-balloon-pos="left" class="inline-block ml-2 text-gray-500 hover:text-red-700 cursor-pointer">
                    <i class="fa fa-times"></i>
                </a>
                <a v-else @click="enableUser(slotProps.row.id)" aria-label="Activar Usuario" data-balloon-pos="left" class="inline-block ml-2 text-gray-500 hover:text-red-700 cursor-pointer">
                    <i class="fa fa-check"></i>
                </a>
            </template>
        </data-table>
    </div>
</template>

<script>
import DataTable from '@/components/DataTable'

export default {
    name: 'users.index',
    components: {
        DataTable
    },
    data: () => ({
        cols: [],
        data: false
    }),
    created () {
        this.cols = [
            { name: 'id', value: 'id' },
            { name: 'full_name', value: 'Nombres' },
            { name: 'email', value: 'Correo Electrónico' },
            { name: 'role', value: 'Rol' },
            { name: 'created_at_date', value: 'registrado' }
        ]
    },
    methods: {
        async enableUser (id) {
            this.loading = true
            let model = {
                id: id,
                status: true
            }
            await this.$http.post('api/core/users/status/'+id, model)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.$toast.success("Usuario habilitado exitosamente.")
                        this.$emit('updateDataTable')
                    }
                }).catch((response) => {
                    this.message = response.message
                    this.errors = response.errors != null ? response.errors : {} 
                    this.$toast.error("Corrija los errores e intentalo nuevamente. Gracias.")
                });
            this.loading = false
        },
        async disableUser (id) {
            this.loading = true
            let model = {
                id: id,
                status: false
            }
            await this.$http.post('api/core/users/status/'+id, this.model)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.$toast.success("Usuario dado de baja exitosamente.")
                        this.$emit('updateDataTable')
                    }
                }).catch((response) => {
                    this.message = response.message
                    this.errors = response.errors != null ? response.errors : {} 
                    this.$toast.error("Corrija los errores e intentalo nuevamente. Gracias.")
                });
            this.loading = false
        },
    }
}
</script>