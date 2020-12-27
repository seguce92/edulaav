<template>
    <nav class="top-0 w-full z-10 md:flex-row md:flex-no-wrap md:justify-start flex items-center">
        <div class="w-full items-center flex justify-between md:flex-no-wrap flex-wrap">
            <router-link :to="{ name: getName }" class="uppercase hidden lg:inline-block font-bold text-lg font-nunito">
                G-{{ date }} - {{ getTitle }}
            </router-link>
            <div class="flex items-center">
                <span class="mr-2 font-nunito">{{ getUsername }}</span>
                <ul class="flex-col md:flex-row list-none items-center md:flex">
                    <user-dropdown-component></user-dropdown-component>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
import UserDropdownComponent from "@/components/UserDropdown.vue";
export default {
    components: {
        UserDropdownComponent
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
