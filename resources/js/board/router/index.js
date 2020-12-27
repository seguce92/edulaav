import Vue from 'vue'
import VueRouter from 'vue-router'

import Layout from '../views/Layout'
import Home from '../views/Home'

import RoomsIndex from '../views/rooms/Index'
import RoomsShow from '../views/rooms/Show'

import RoomTask from '../views/rooms/partial/Task'
import RoomStudent from '../views/rooms/partial/Student'

import VideoRoom from '../views/rooms/partial/VideoRoom'

Vue.use(VueRouter)

const routes = [{
    path: '/',
    //component: () => import('../views/Layout'),
    component: Layout,
    meta: { requiresAuth: true },
    children: [
        {
            path: '/home',
            name: 'home',
            //component: () => import('../views/Index'),
            component: Home,
            meta: { requiresVisitor: true, title: 'Escritorio' }
        },

        {
            path: '/rooms',
            name: 'rooms.index',
            //component: () => import('../views/Index'),
            component: RoomsIndex,
            meta: { requiresVisitor: true, title: 'Clases' }
        }, {
            path: '/rooms/:id',
            name: 'rooms.show',
            //component: () => import('../views/Index'),
            component: RoomsShow,
            meta: { requiresVisitor: true, title: 'Clases' }
        }, {
            path: '/rooms/:id/tasks',
            name: 'rooms.task',
            //component: () => import('../views/Index'),
            component: RoomTask,
            meta: { requiresVisitor: true, title: 'Tareas' }
        }, {
            path: '/rooms/:id/students',
            name: 'rooms.student',
            //component: () => import('../views/Index'),
            component: RoomStudent,
            meta: { requiresVisitor: true, title: 'Estudiantes' }
        },

        {
            path: '/rooms/:id/video-room',
            name: 'rooms.video',
            //component: () => import('../views/Index'),
            component: VideoRoom,
            meta: { requiresVisitor: true, title: 'Video Conferencia' }
        },
    ]
}]

const router = new VueRouter({
    mode: 'history',
    base: '/board',
    routes
})

export default router
