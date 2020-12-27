<template>
    <div class="mt-6 px-4">
        <div class="lg:flex lg:items-center lg:justify-between max-w-6xl mx-auto mb-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold leading-7 text-primary-900 sm:leading-9 sm:truncate">
                    Estudiantes
                </h2>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="block shadow-sm rounded-md">
                    <router-link :to="{ name: 'students.index' }" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fa fa-arrow-left mr-3"></i>
                        Atras
                    </router-link>
                </span>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-6xl mx-auto">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Nuevo Estudiante
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Registro de nuevo Estudiante
                </p>
            </div>
            <div>
                <dl>
                    <div class="w-full px-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN DE CUENTA</h4>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo Electrónico <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="email" required v-model="model.email" autofocus
                                        placeholder="example@email.com">
                                    <error-field :errors="set_error(errors, 'email')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Cédula de Identidad <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.ci"
                                        placeholder="Cédula de Identidad">
                                    <error-field :errors="set_error(errors, 'ci')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            RUDE <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.rude"
                                        placeholder="RUDE">
                                    <error-field :errors="set_error(errors, 'rude')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Nombres <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.name"
                                        placeholder="Nombres">
                                    <error-field :errors="set_error(errors, 'name')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Apellidos
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.lastname"
                                        placeholder="Apellidos">
                                    <error-field :errors="set_error(errors, 'lastname')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Fecha de Nacimiento <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="date" v-model="model.birthday">
                                    <error-field :errors="set_error(errors, 'birthday')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Lugar de Nacimiento <span aria-label="Lugar de Nacimiento. Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" v-model="model.site">
                                    <error-field :errors="set_error(errors, 'site')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Número Tel-Cel <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.phone"
                                        placeholder="+591 123456789">
                                    <error-field :errors="set_error(errors, 'phone')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Dirección
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.adress"
                                        placeholder="Dirección">
                                    <error-field :errors="set_error(errors, 'address')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="w-full px-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN COMPLEMENTARIA DEL ESTUDIANTE</h4>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Talla(m.) <span aria-label="Talla en metros. Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.size"
                                        placeholder="Tall en Metros Ej: 0.45">
                                    <error-field :errors="set_error(errors, 'size')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Seguro Médico
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.medic"
                                        placeholder="Dirección">
                                    <error-field :errors="set_error(errors, 'medic')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Grupo Sanguineo <span aria-label="Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            v-model="model.blood_type" required>
                                            <option value="ORH+" selected>O RH+</option>
                                            <option value="ORH-">O RH-</option>
                                            <option value="ARH+">A RH+</option>
                                            <option value="ARH-">A RH-</option>
                                            <option value="BRH+">B RH+</option>
                                            <option value="BRH-">B RH-</option>
                                            <option value="ABRH+">AB RH+</option>
                                            <option value="ABRH-">AB RH-</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                    <error-field :errors="set_error(errors, 'blood_type')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Genero <span aria-label="Genero. Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            v-model="model.gender" required>
                                            <option value="M" selected>Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                    <error-field :errors="set_error(errors, 'gender')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            U.E. de Procedencia
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" v-model="model.precendent"
                                        placeholder="U.E. de Procedencia">
                                    <error-field :errors="set_error(errors, 'precendent')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="w-full px-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN DEL PADRE</h4>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Nombre Completo del Padre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" v-model="model.father_name"
                                        placeholder="Nombre completo del Padre">
                                    <error-field :errors="set_error(errors, 'father_name')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Ocupación del Padre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" v-model="model.father_occupation"
                                        placeholder="Ocupación del Padre">
                                    <error-field :errors="set_error(errors, 'father_occupation')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo electrónico Padre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="email" v-model="model.parent_mother"
                                        placeholder="email@email.com">
                                    <error-field :errors="set_error(errors, 'father_email')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Telf-Cel del Padre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" v-model="model.father_phone"
                                        placeholder="591 75******">
                                    <error-field :errors="set_error(errors, 'father_phone')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>

                    <div class="w-full px-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN DE LA MADRE</h4>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Nombre completo de la Madre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" v-model="model.mother_name"
                                        placeholder="Nombre completo de la Madre">
                                    <error-field :errors="set_error(errors, 'mother_name')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Ocupación de la Madre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" v-model="model.mother_occupation"
                                        placeholder="Ocupación de la Madre">
                                    <error-field :errors="set_error(errors, 'mother_occupation')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo electrónico de la Madre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="email" v-model="model.mother_email"
                                        placeholder="email@email.com">
                                    <error-field :errors="set_error(errors, 'mother_email')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Telf-Cel de la Madre
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" v-model="model.mother_phone"
                                        placeholder="591 75******">
                                    <error-field :errors="set_error(errors, 'mother_phone')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    
                    <div class="w-full px-4">
                        <h4 class="font-bold text-lg text-center border-b">INFORMACIÓN DEL TUTOR</h4>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Telf-Cel del Tutor <span aria-label="Telf.-Cel del Tutor. Este campo es requerido" data-balloon-pos="right"><i class="fa fa-asterisk text-xss"></i></span>
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="text" required v-model="model.tutor_phone"
                                        placeholder="591 75******">
                                    <error-field :errors="set_error(errors, 'tutor_phone')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Correo electrónico del Tutor
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3">
                                    <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                                        type="email" v-model="model.tutor_email"
                                        placeholder="tutor@mail.com">
                                    <error-field :errors="set_error(errors, 'tutor_email')"></error-field>
                                </div>
                            </div>
                        </dd>
                    </div>
                </dl>
                <dl>
                    <div class="px-4 py-5 sm:px-6 flex md:justify-end">
                        <button @click="store" class="text-white cursor-pointer inline-flex items-center px-4 py-2 bg-primary-800 border border-gray-300 text-sm leading-5 font-medium rounded-md hover:text-white hover:bg-primary-700 focus:outline-none transition duration-150 ease-in-out">
                            <i class="fa fa-save mr-3"></i>
                            Registrar
                        </button>
                    </div>
                </dl>
            </div>
            <loading v-if="loading" />
        </div>
    </div>
</template>

<script>
export default {
    name: 'students-create',
    data: () => ({
        loading: false,
        errors: [],
        model: {
            gender: 'M',
            blood_type: 'ORH+'
        }
    }),
    methods: {
        async store () {
            this.loading = true
            await this.$http.post('api/core/students', this.model)
                .then((response) => {
                    if ( response.status == 201 ) {
                        this.$toast.success("Estudiante registrado exitosamente.")
                        this.$router.push({ name: 'students.index' })
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