<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    creator: Object,
    metrics: Object,
    supports: Object,
});

// Formulario para editar el Perfil de Creador
const profileForm = useForm({
    name: props.creator?.name || '',
    slug: props.creator?.slug || '',
    bio: props.creator?.bio || '',
    avatar_image: null,
});

const updateProfile = () => {
    // Cuando hay archivos (imágenes) involucrados, Inertia requiere enviar via POST
    // y usar _method para spoofing y forzar FormData.
    profileForm.transform((data) => ({
        ...data,
        _method: 'put',
    })).post(route('creator.update'), {
        preserveScroll: true,
        forceFormData: true,
    });
};

const handleImageUpload = (e) => {
    profileForm.avatar_image = e.target.files[0];
};

// Formulario para añadir un nuevo Enlace (Linktree)
const linkForm = useForm({
    title: '',
    url: '',
});

const addLink = () => {
    linkForm.post(route('links.store'), {
        preserveScroll: true,
        onSuccess: () => linkForm.reset(),
    });
};

// Formulario reactivo para eliminar un Link
const deleteForm = useForm({});
const deleteLink = (id) => {
    if (confirm('Are you sure you want to delete this link?')) {
        deleteForm.delete(route('links.destroy', id), {
            preserveScroll: true,
        });
    }
};

import { ref, watch } from 'vue';

const showToast = ref(false);
const toastMessage = ref('');

// Mostrar Toast cuando guardamos el perfil
watch(() => profileForm.recentlySuccessful, (isSuccess) => {
    if (isSuccess) {
        toastMessage.value = '¡Perfil actualizado con éxito!';
        showToast.value = true;
        setTimeout(() => showToast.value = false, 3000);
    }
});

// Mostrar Toast cuando añadimos enlace
watch(() => linkForm.recentlySuccessful, (isSuccess) => {
    if (isSuccess) {
        toastMessage.value = 'Enlace agregado a tu Linktree';
        showToast.value = true;
        setTimeout(() => showToast.value = false, 3000);
    }
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-10 bg-[#f8fafc] dark:bg-[#0b0f19] min-h-[calc(100vh-65px)]">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <!-- Header del Panel -->
                <div class="px-4 sm:px-0 mb-4 flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">¡Bienvenido, {{ creator?.name || 'Creador' }}!</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gestiona tu perfil, tus enlaces y visualiza a tus seguidores.</p>
                    </div>
                    <a :href="'/@' + creator?.slug" target="_blank" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-800 text-sm font-semibold text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm">
                        Ver perfil público actual
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>

                <!-- Tarjetas de Métricas (Dashboard Analytics) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 px-4 sm:px-0">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10 dark:opacity-5 text-indigo-500">
                            <svg class="w-24 h-24 transform translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.65 0 1.12-1 1.95-2.8 1.95-1.97 0-2.87-.99-2.92-2.34h-2.2c.07 2.32 1.5 3.75 3.62 4.21V21h3v-2.13c1.86-.37 3.51-1.6 3.51-3.6 0-2.82-2.31-3.54-4.71-4.2x"></path></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Total Recaudado</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">${{ parseFloat(metrics?.totalGained || 0).toFixed(2) }}</h3>
                        <p class="mt-2 text-sm text-green-600 dark:text-green-500 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            Histórico de ingresos
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10 dark:opacity-5 text-gray-600">
                            <svg class="w-24 h-24 transform translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Total de Apoyos</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ metrics?.totalSupports || 0 }}</h3>
                        <p class="mt-2 text-sm text-indigo-600 dark:text-indigo-400 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Donantes únicos
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10 dark:opacity-5 text-emerald-500">
                            <svg class="w-24 h-24 transform translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Promedio donado</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">${{ parseFloat(metrics?.averageSupport || 0).toFixed(2) }}</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Por cada aporte
                        </p>
                    </div>
                </div>

                <!-- AÑADIR ITEMS-START AL CONTENEDOR GRID PARA EVITAR ESTIRAMIENTO (BUG FIX) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                    <!-- Columna Izquierda (Perfil) -->
                    <div class="md:col-span-1 space-y-6">
                        <!-- SECCIÓN 1: Perfil de Creador -->
                        <div class="p-6 bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl">
                            <!-- Decoración superior (Linea sutil) -->
                            <div class="w-8 h-1 bg-indigo-500 rounded-full mb-4"></div>
                            
                            <section>
                                <header>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Perfil del Creador
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Actualiza tu información pública y avatar.
                                    </p>
                                </header>

                                <form @submit.prevent="updateProfile" class="mt-6 space-y-5">
                                    <div>
                                        <InputLabel for="name" value="Nombre Completo" class="font-semibold text-gray-700 dark:text-gray-300" />
                                        <TextInput id="name" type="text" maxlength="50" placeholder="Ej: Jane Doe" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-white dark:bg-gray-900 shadow-sm" v-model="profileForm.name" required />
                                    </div>

                                    <div>
                                        <InputLabel for="slug" value="Slug Público (url)" class="font-semibold text-gray-700 dark:text-gray-300" />
                                        <div class="flex items-center mt-1 bg-white dark:bg-gray-900 rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden focus-within:ring-1 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all shadow-sm">
                                            <span class="text-gray-500 dark:text-gray-400 px-3 text-sm font-medium border-r border-gray-300 dark:border-gray-700 select-none bg-gray-50 dark:bg-gray-800 h-full flex items-center">esponsor.com/@</span>
                                            <input id="slug" type="text" maxlength="30" pattern="[a-zA-Z0-9\-]+" title="Letras, números y guiones. Sin espacios." class="border-0 bg-transparent block w-full focus:ring-0 sm:text-sm py-2 px-3 dark:text-white" v-model="profileForm.slug" required placeholder="tu-usuario" />
                                        </div>
                                    </div>

                                    <div>
                                        <InputLabel for="avatar_image" value="Imagen de Avatar" class="font-semibold" />
                                        <div class="mt-3 flex items-center gap-4">
                                            <div class="relative shrink-0 w-16 h-16 rounded-full ring-2 ring-indigo-100 p-0.5">
                                                <img v-if="creator?.avatar_url" :src="creator.avatar_url" alt="Current Avatar" class="w-full h-full rounded-full object-cover">
                                                <div v-else class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center text-gray-400"><svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg></div>
                                            </div>
                                            <input id="avatar_image" type="file" accept="image/*" @change="handleImageUpload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-indigo-400 dark:hover:file:bg-gray-600 transition cursor-pointer" />
                                        </div>
                                        <InputError class="mt-2" :message="profileForm.errors.avatar_image" />
                                    </div>

                                    <div>
                                        <InputLabel for="bio" value="Biografía Corta" class="font-semibold text-gray-700 dark:text-gray-300" />
                                        <textarea id="bio" maxlength="255" class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm transition-all" v-model="profileForm.bio" rows="4" placeholder="Cuéntale a tus seguidores sobre ti..."></textarea>
                                    </div>

                                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-end">
                                        <PrimaryButton :disabled="profileForm.processing" class="rounded-lg">Guardar Cambios</PrimaryButton>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>

                    <!-- Columna Derecha (Links y Supports) -->
                    <div class="md:col-span-2 space-y-6">
                        
                        <!-- SECCIÓN 2: Gestor de Enlaces -->
                        <div class="p-6 bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl">
                            <section>
                                <header class="mb-6 flex justify-between items-center">
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                            Mis Enlaces
                                        </h2>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gestiona los enlaces que aparecen en tu página pública.</p>
                                    </div>
                                    <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2.5 py-0.5 rounded-full dark:bg-indigo-900 dark:text-indigo-300">{{ creator?.links?.length || 0 }} Enlaces</span>
                                </header>

                                <!-- Formulario para agregar -->
                                <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
                                    <form @submit.prevent="addLink" class="flex flex-col sm:flex-row gap-4 items-end">
                                        <div class="flex-1 w-full">
                                            <InputLabel for="title" value="Plataforma / Título" class="font-semibold text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide" />
                                            <TextInput id="title" type="text" maxlength="50" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 focus:ring-indigo-500 shadow-sm bg-white dark:bg-gray-900" placeholder="Ej: Mi canal de YouTube" v-model="linkForm.title" required />
                                        </div>
                                        <div class="flex-1 w-full">
                                            <InputLabel for="url" value="URL de Destino (https://...)" class="font-semibold text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide" />
                                            <TextInput id="url" type="url" maxlength="255" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 focus:ring-indigo-500 shadow-sm bg-white dark:bg-gray-900" placeholder="https://youtube.com/..." v-model="linkForm.url" required />
                                        </div>
                                        <PrimaryButton :disabled="linkForm.processing" class="w-full sm:w-auto rounded-lg py-2 shadow-sm text-sm">Añadir Enlace</PrimaryButton>
                                    </form>
                                </div>

                                <!-- Lista de Enlaces Guardados -->
                                <div v-if="creator?.links?.length > 0" class="space-y-3">
                                    <TransitionGroup name="list" tag="div" class="space-y-3">
                                        <div v-for="link in creator.links" :key="link.id" class="group flex items-center justify-between p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-700 transition-all">
                                            <div class="flex items-center gap-4 overflow-hidden">
                                                <div class="cursor-move text-gray-400 opacity-50"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg></div>
                                                <div class="truncate">
                                                    <h4 class="font-bold text-gray-900 dark:text-gray-100 truncate">{{ link.title }}</h4>
                                                    <a :href="link.url" target="_blank" class="text-sm text-gray-500 hover:text-indigo-600 truncate inline-block max-w-[200px] sm:max-w-xs">{{ link.url }}</a>
                                                </div>
                                            </div>
                                            <button @click="deleteLink(link.id)" class="text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 p-2 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500" title="Delete link">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </TransitionGroup>
                                </div>
                                <div v-else class="text-center py-10 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Aún no hay enlaces. ¡Añade tu primer enlace arriba!</p>
                                </div>
                            </section>
                        </div>

                        <!-- SECCIÓN 3: Tabla de Apoyos recibidos -->
                        <div class="p-6 bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl">
                            <section>
                                <header class="mb-6 flex justify-between items-center">
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                            <span class="text-2xl">💖</span>
                                            Apoyos Recibidos
                                        </h2>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mira quién está apoyando tu contenido.</p>
                                    </div>
                                    <!-- Ya no necesitamos el total pequeño porque tenemos la tarjeta grande -->
                                </header>

                                <div v-if="supports?.data?.length > 0" class="flex flex-col">
                                    <div class="overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700 rounded-xl mb-4">
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                                                <thead class="bg-gray-50/50 dark:bg-gray-800">
                                                    <tr class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                                                        <th scope="col" class="px-6 py-4">Seguidor</th>
                                                        <th scope="col" class="px-6 py-4">Mensaje</th>
                                                        <th scope="col" class="px-6 py-4 text-right">Monto</th>
                                                        <th scope="col" class="px-6 py-4">Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                                    <tr v-for="support in supports.data" :key="support.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-200 to-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xs">{{ support.supporter_name.charAt(0) }}</div>
                                                                <span class="font-bold text-gray-900 dark:text-white">{{ support.supporter_name }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 min-w-[200px]">
                                                            <div class="text-gray-600 dark:text-gray-300 italic">"{{ support.message || '¡Envió una propina!' }}"</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                                                ${{ parseFloat(support.amount).toFixed(2) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400 text-xs font-medium">
                                                            {{ new Date(support.created_at).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' }) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <!-- Controles de Paginación -->
                                    <div class="mt-4 pt-4 flex items-center justify-between border-t border-gray-200 dark:border-gray-700">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Mostrando <span class="font-bold text-gray-900 dark:text-white">{{ supports.from || 0 }}</span> a <span class="font-bold text-gray-900 dark:text-white">{{ supports.to || 0 }}</span> de <span class="font-bold text-gray-900 dark:text-white">{{ supports.total }}</span> resultados
                                        </div>
                                        <div class="flex gap-2">
                                            <Link v-if="supports.prev_page_url" :href="supports.prev_page_url" class="px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                Anterior
                                            </Link>
                                            <span v-else class="px-3 py-1.5 text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg cursor-not-allowed">Anterior</span>
                                            
                                            <Link v-if="supports.next_page_url" :href="supports.next_page_url" class="px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                Siguiente
                                            </Link>
                                            <span v-else class="px-3 py-1.5 text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg cursor-not-allowed">Siguiente</span>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="text-center py-10 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50/50 dark:bg-gray-800/50">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <h3 class="text-base font-medium text-gray-900 dark:text-gray-100 mb-1">Aún no hay apoyos</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Comparte tu perfil público para empezar a recibir donaciones.</p>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Notificación Flotante Estilo "Toast" -->
        <Transition
            enter-active-class="transform ease-out duration-300 transition"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showToast" class="fixed bottom-4 right-4 z-50 flex items-center p-4 space-x-3 w-fit text-gray-500 bg-white rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 dark:text-gray-300 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                </div>
                <div class="ml-3 text-sm font-semibold text-gray-900 dark:text-white mr-2">{{ toastMessage }}</div>
                <button @click="showToast = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
                    <span class="sr-only">Cerrar</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </Transition>
    </AuthenticatedLayout>
</template>
