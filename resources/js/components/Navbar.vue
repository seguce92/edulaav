<template>
    <nav class="top-0 w-full z-10 bg-navbar md:flex-row md:flex-no-wrap md:justify-start flex items-center p-4">
        <div class="w-full items-center flex justify-between md:flex-no-wrap flex-wrap px-4">
            <router-link :to="{ name: getName }" class="text-white text-sm uppercase hidden lg:inline-block font-semibold">
                G-{{ date }} - {{ getTitle }}
            </router-link>
            <div class="flex items-center">
                <notification-dropdown />
                <span class="text-white text-sm mr-2">{{ getUsername }}</span>
                <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
                    <user-dropdown-component></user-dropdown-component>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
import UserDropdownComponent from "./UserDropdown.vue";
import NotificationDropdown from "./NotificationDropdown"
export default {
    components: {
        UserDropdownComponent,
        NotificationDropdown
    },
    data: () => ({
        date: new Date().getFullYear()
    }),
    computed: {
        getTitle: function () {
            return this.$route.meta.title
        },
        getUsername: function () {
            return window.User.name
        },
        getName: function () {
            return this.$route.name
        }
    }
};
</script>
