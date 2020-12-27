<template>
    <div>
        <a class="text-gray-600 block" href="#"
            v-on:click="toggleDropdown($event)"
            ref="btnDropdownRef">
            <div class="items-center flex">
                <span class="w-10 h-10 text-sm text-white bg-gray-300 inline-flex items-center justify-center rounded-full">
                    <img class="w-full rounded-full align-middle border-none shadow-lg"
                        :src="asset('img/team-1-800x800.jpg')"/>
                </span>
            </div>
        </a>
        <div ref="popoverDropdownRef"
            class="bg-white text-base z-50 float-left list-none text-left rounded shadow-lg mt-1"
            v-bind:class="{
                hidden: !dropdownPopoverShow,
                block: dropdownPopoverShow
            }"
            style="min-width: 12rem">
            <a href="#pablo"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-200">
                Mi Perfil
            </a>
            <div class="h-0 border border-solid border-gray-200" />
            <a @click="logout"
                class="text-sm cursor-pointer py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-200">
                Cerrar Sesión
            </a>
        </div>
    </div>
</template>
<script>
import Popper from "popper.js";

export default {
    data:() => ({
        dropdownPopoverShow: false
    }),
    methods: {
        toggleDropdown: function(event) {
            event.preventDefault();
            if (this.dropdownPopoverShow) {
                this.dropdownPopoverShow = false;
            } else {
                this.dropdownPopoverShow = true;
                new Popper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
                    placement: "bottom-end"
                });
            }
        },

        logout: function () {
            this.logoutForm()
        },
        logoutForm: function () {
            this.$http.post('/logout').then(() => {
                window.location = '/'
            })
        },
    }
};
</script>
