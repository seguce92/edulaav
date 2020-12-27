import Vue from 'vue'
import VueRouter from 'vue-router'

import Layout from '../views/Layout'
import Home from '../views/Home'

import Academic from '../views/academic/Index'

import UsersIndex from '../views/core/users/Index'
import UsersShow from '../views/core/users/Show'
import UsersCreate from '../views/core/users/Create'
import UsersEdit from '../views/core/users/Edit'

import TeachersIndex from '../views/core/teachers/Index'
import TeachersShow from '../views/core/teachers/Show'
import TeachersCreate from '../views/core/teachers/Create'
import TeachersEdit from '../views/core/teachers/Edit'

import StudentsIndex from '../views/core/students/Index'
import StudentsShow from '../views/core/students/Show'
import StudentsCreate from '../views/core/students/Create'
import StudentsEdit from '../views/core/students/Edit'

import GradesIndex from '../views/academic/grades/Index'
import GradesShow from '../views/academic/grades/Show'
import GradesCreate from '../views/academic/grades/Create'
import GradesEdit from '../views/academic/grades/Edit'

import ParallelsCreate from '../views/academic/parallels/Create'
import ParallelsEdit from '../views/academic/parallels/Edit'

import SubjectsShow from '../views/academic/subjects/Show'
import SubjectsCreate from '../views/academic/subjects/Create'
import SubjectsEdit from '../views/academic/subjects/Edit'

import Rooms from '../views/academic/rooms/Index'
import RoomsCreate from '../views/academic/rooms/Create'
import RoomsAdd from '../views/academic/rooms/Add'
import RoomsEdit from '../views/academic/rooms/Edit'
import RoomsShow from '../views/academic/rooms/Show'

import Designations from '../views/academic/designations/Index'
import DesignationsCreate from '../views/academic/designations/Create'
import DesignationsEdit from '../views/academic/designations/Edit'
import DesignationsShow from '../views/academic/designations/Show'

import Planifications from '../views/academic/planifications/Index'
import PlanificationsCreate from '../views/academic/planifications/Create'
import PlanificationsEdit from '../views/academic/planifications/Edit'
import PlanificationsShow from '../views/academic/planifications/Show'

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
            path: '/users',
            name: 'users.index',
            //component: () => import('../views/Index'),
            component: UsersIndex,
            meta: { requiresVisitor: true, title: 'Usuarios' }
        }, {
            path: '/users/create',
            name: 'users.create',
            //component: () => import('../views/Index'),
            component: UsersCreate,
            meta: { requiresVisitor: true, title: 'Usuarios' }
        }, {
            path: '/users/:id/edit',
            name: 'users.edit',
            //component: () => import('../views/Index'),
            component: UsersEdit,
            meta: { requiresVisitor: true, title: 'Usuarios' }
        }, {
            path: '/users/:id',
            name: 'users.show',
            //component: () => import('../views/Index'),
            component: UsersShow,
            meta: { requiresVisitor: true, title: 'Usuarios' }
        },

        {
            path: '/teachers',
            name: 'teachers.index',
            //component: () => import('../views/Index'),
            component: TeachersIndex,
            meta: { requiresVisitor: true, title: 'Docentes' }
        }, {
            path: '/teachers/create',
            name: 'teachers.create',
            //component: () => import('../views/Index'),
            component: TeachersCreate,
            meta: { requiresVisitor: true, title: 'Docentes' }
        }, {
            path: '/teachers/:id/edit',
            name: 'teachers.edit',
            //component: () => import('../views/Index'),
            component: TeachersEdit,
            meta: { requiresVisitor: true, title: 'Docentes' }
        }, {
            path: '/teachers/:id',
            name: 'teachers.show',
            //component: () => import('../views/Index'),
            component: TeachersShow,
            meta: { requiresVisitor: true, title: 'Docentes' }
        },

        {
            path: '/students',
            name: 'students.index',
            //component: () => import('../views/Index'),
            component: StudentsIndex,
            meta: { requiresVisitor: true, title: 'Estudiantes' }
        }, {
            path: '/students/create',
            name: 'students.create',
            //component: () => import('../views/Index'),
            component: StudentsCreate,
            meta: { requiresVisitor: true, title: 'Estudiantes' }
        }, {
            path: '/students/:id/edit',
            name: 'students.edit',
            //component: () => import('../views/Index'),
            component: StudentsEdit,
            meta: { requiresVisitor: true, title: 'Estudiantes' }
        }, {
            path: '/students/:id',
            name: 'students.show',
            //component: () => import('../views/Index'),
            component: StudentsShow,
            meta: { requiresVisitor: true, title: 'Estudiantes' }
        },


        {
            path: '/settings-academic',
            name: 'academic',
            //component: () => import('../views/Index'),
            component: Academic,
            meta: { requiresVisitor: true, title: 'Configuración Académica' }
        },


        {
            path: '/grades',
            name: 'grades.index',
            //component: () => import('../views/Index'),
            component: GradesIndex,
            meta: { requiresVisitor: true, title: 'Grados' }
        }, {
            path: '/grades/create',
            name: 'grades.create',
            //component: () => import('../views/Index'),
            component: GradesCreate,
            meta: { requiresVisitor: true, title: 'Grados' }
        }, {
            path: '/grades/:id/edit',
            name: 'grades.edit',
            //component: () => import('../views/Index'),
            component: GradesEdit,
            meta: { requiresVisitor: true, title: 'Grados' }
        }, {
            path: '/grades/:id',
            name: 'grades.show',
            //component: () => import('../views/Index'),
            component: GradesShow,
            meta: { requiresVisitor: true, title: 'Grados' }
        },

        {
            path: '/parallels/create/:id',
            name: 'parallels.create',
            //component: () => import('../views/Index'),
            component: ParallelsCreate,
            meta: { requiresVisitor: true, title: 'Paralelos' }
        }, {
            path: '/parallels/:id/edit',
            name: 'parallels.edit',
            //component: () => import('../views/Index'),
            component: ParallelsEdit,
            meta: { requiresVisitor: true, title: 'Paralelos' }
        },

        {
            path: '/subjects/create/:id',
            name: 'subjects.create',
            //component: () => import('../views/Index'),
            component: SubjectsCreate,
            meta: { requiresVisitor: true, title: 'Asignaturas' }
        }, {
            path: '/subjects/:id/edit',
            name: 'subjects.edit',
            //component: () => import('../views/Index'),
            component: SubjectsEdit,
            meta: { requiresVisitor: true, title: 'Asignatura' }
        }, {
            path: '/subjects/:id',
            name: 'subjects.show',
            //component: () => import('../views/Index'),
            component: SubjectsShow,
            meta: { requiresVisitor: true, title: 'Asignaturas' }
        },

        {
            path: '/rooms',
            name: 'rooms',
            //component: () => import('../views/Index'),
            component: Rooms,
            meta: { requiresVisitor: true, title: 'Cursos' }
        }, {
            path: '/rooms/create/:id',
            name: 'rooms.create',
            //component: () => import('../views/Index'),
            component: RoomsCreate,
            meta: { requiresVisitor: true, title: 'Cursos' }
        }, {
            path: '/rooms/students/:id',
            name: 'rooms.students',
            //component: () => import('../views/Index'),
            component: RoomsAdd,
            meta: { requiresVisitor: true, title: 'Cursos' }
        }, {
            path: '/rooms/:id/edit',
            name: 'rooms.edit',
            //component: () => import('../views/Index'),
            component: RoomsEdit,
            meta: { requiresVisitor: true, title: 'Cursos' }
        }, {
            path: '/rooms/:id',
            name: 'rooms.show',
            //component: () => import('../views/Index'),
            component: RoomsShow,
            meta: { requiresVisitor: true, title: 'Cursos' }
        },

        {
            path: '/designations',
            name: 'designations',
            //component: () => import('../views/Index'),
            component: Designations,
            meta: { requiresVisitor: true, title: 'Designaciones' }
        }, {
            path: '/designations/create/:id',
            name: 'designations.create',
            //component: () => import('../views/Index'),
            component: DesignationsCreate,
            meta: { requiresVisitor: true, title: 'Designaciones' }
        }, {
            path: '/designations/:id/edit',
            name: 'designations.edit',
            //component: () => import('../views/Index'),
            component: DesignationsEdit,
            meta: { requiresVisitor: true, title: 'Desginaciones' }
        }, {
            path: '/designations/:id',
            name: 'designations.show',
            //component: () => import('../views/Index'),
            component: DesignationsShow,
            meta: { requiresVisitor: true, title: 'Designaciones' }
        }, 
        
        {
            path: '/planifications',
            name: 'planifications',
            //component: () => import('../views/Index'),
            component: Planifications,
            meta: { requiresVisitor: true, title: 'Grados' }
        }, {
            path: '/planifications/create/:id',
            name: 'planifications.create',
            //component: () => import('../views/Index'),
            component: PlanificationsCreate,
            meta: { requiresVisitor: true, title: 'Planificaciones' }
        }, {
            path: '/planifications/:id/edit/:grade',
            name: 'planifications.edit',
            //component: () => import('../views/Index'),
            component: PlanificationsEdit,
            meta: { requiresVisitor: true, title: 'Planificaciones' }
        }, {
            path: '/planifications/:id',
            name: 'planifications.show',
            //component: () => import('../views/Index'),
            component: PlanificationsShow,
            meta: { requiresVisitor: true, title: 'Planificaciones' }
        }, 
    ]
}]

const router = new VueRouter({
    mode: 'history',
    base: '/admin',
    routes
})

export default router
