<template>
    <div>
        <sidebar-component></sidebar-component>
        <div class="relative md:ml-sidebar bg-gray-200 flex flex-col min-h-screen">
            <navbar-component></navbar-component>
            
            <main class="flex-grow">
                <transition name="content-transition"
                    enter-active-class="animated fadeIn">
                    <router-view />
                </transition>
            </main>

            <footer class="w-full block py-3 bg-white mt-8">
                <div class="container mx-auto px-4">
                    <div class="flex flex-wrap items-center md:justify-between justify-center font-nunito">
                        <div class="px-4 text-center md:text-left">
                            <div class="text-xs text-gray-600 py-1">
                                Derechos Reservados © {{ date }}
                                <a href="https://sergiocruzes.com" class="text-gray-600 hover:text-gray-800 text-sm font-semibold py-1">
                                    edulaav
                                </a>
                            </div>
                        </div>
                        <div class="px-4">
                            <ul class="flex flex-wrap list-none md:justify-end  justify-center">
                                <li>
                                    <a href="https://edulaav.ulaav.com/blog"
                                        class="text-gray-700 hover:text-gray-900 text-sm font-semibold block py-1 px-3">
                                        Blog
                                    </a>
                                </li>
                                <li>
                                    <a href="https://edulaav.ulaav.com/license"
                                        class="text-gray-700 hover:text-gray-900 text-sm font-semibold block py-1 px-3">
                                        Licencia
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
<script>
import NavbarComponent from "@/components/Navbar.vue";
import SidebarComponent from "@/components/Sidebar.vue";
export default {
    name: "layout",
    components: {
        NavbarComponent,
        SidebarComponent,
    },
    data() {
        return {
            date: new Date().getFullYear()
        }
    }
};
</script>