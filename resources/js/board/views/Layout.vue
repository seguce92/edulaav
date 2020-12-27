<template>
    <div class="h-screen w-full flex overflow-hidden select-none">
	    <nav class="w-24 flex flex-col items-center bg-white dark:bg-gray-800 py-4">
		    <div class="flex justify-center mb-2 w-full">
                <a href="/board/home" aria-label="EDULAAV" data-balloon-pos="right">
                    <img :src="asset('android-icon-48x48.png')" class="h-8">
                </a>
		    </div>
		    <menu-sidebar />
            <div class="mt-auto flex items-center p-2 bg-primary-200 rounded-full hover:shadow-lg" :aria-label="env_name()" data-balloon-pos="right">
                <a href="/">
                    <img :src="env_logo()" alt="" class="w-8 h-8">
                </a>
            </div>
	    </nav>
        <main class="my-1 pt-2 pb-2 px-10 flex-1 bg-gray-200 dark:bg-black rounded-l-lg transition duration-500 ease-in-out overflow-y-auto">
            <navbar-component />
            <transition name="content-transition"
                enter-active-class="animated fadeIn">
                <router-view />
            </transition>
        </main>
    </div>
</template>

<script>
import MenuSidebar from './Menu.vue'
import NavbarComponent from "./Navbar.vue";
export default {
    name: 'layout',
    components: {
        NavbarComponent,
        MenuSidebar
    }
}
</script>