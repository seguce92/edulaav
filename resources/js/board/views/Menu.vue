<template>
<div class="mt-2 border-t border-dashed">
    <ul class="mt-2 text-primary-600 capitalize font-nunito learn-sidebar">
        <li class="mt-3 p-2 rounded-lg">
            <router-link :to="{name:'home'}" class="flex flex-col items-center">
                <i class="fa fa-home text-xl"></i>
                <span class="text-xs mt-2">Escritorio</span>
            </router-link>
        </li>
        <li class="mt-3 p-2 rounded-lg">
            <router-link :to="{name:'rooms.index'}" class=" flex flex-col items-center">
                <i class="fa fa-tags text-xl"></i>
                <span class="text-xs mt-2">Clases</span>
            </router-link>
        </li>
        <li class="mt-3 p-2 rounded-lg">
            <a href="meetup/" class=" flex flex-col items-center">
                <i class="fa fa-calendar-alt text-xl"></i>
                <span class="text-xs mt-2">Agenda</span>
            </a>
        </li>
        <li class="mt-3 p-2 rounded-lg">
            <a href="social-media-dashboard/" class=" flex flex-col items-center">
                <i class="fa fa-bullhorn text-xl"></i>
                <span class="text-xs mt-2">Comunicados</span>
            </a>
        </li>
    </ul>
    </div>
</template>

<script>
export default {
    name: 'menu-sidebar',
    data: () => ({

    })
}
</script>

<style lang="scss">
    .learn-sidebar {
        li {
            a:hover {
                @apply text-primary-800;
            }

            .router-link-active {
                @apply text-primary-800;
                i {
                    @apply text-primary-800;
                }
            }
            .router-link-active:hover {
                @apply text-primary-800;
            }
        }
    }
</style>