<script setup>
import { Head } from '@inertiajs/vue3';
import SupportModal from '@/Components/SupportModal.vue';

const props = defineProps({
    creator: Object,
});
</script>

<template>
    <Head :title="creator.name" />

    <!-- Animated Gradient Background -->
    <div class="min-h-screen bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 flex flex-col items-center pt-20 pb-8 px-4 sm:px-6 relative overflow-hidden">
        
        <!-- Decorative shapes backing the content -->
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-white/30 to-transparent dark:from-white/5 pointer-events-none"></div>

        <div class="w-full max-w-lg z-10 space-y-8 flex-grow">
            
            <!-- Perfil Header -->
            <div class="text-center">
                <!-- Avatar Wrapper with ring -->
                <div class="relative inline-block mb-6 group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-pink-500 to-indigo-500 rounded-full blur opacity-40 group-hover:opacity-75 transition duration-500"></div>
                    <img 
                        v-if="creator.avatar_url" 
                        :src="creator.avatar_url" 
                        alt="Avatar" 
                        class="relative w-36 h-36 mx-auto rounded-full object-cover shadow-2xl border-[3px] border-white dark:border-gray-800 transition-transform duration-300 group-hover:scale-105"
                    >
                    <div v-else class="relative w-36 h-36 mx-auto rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-2xl border-[3px] border-white dark:border-gray-800 transition-transform duration-300 group-hover:scale-105">
                        <span class="text-5xl text-white font-black drop-shadow-md">{{ creator.name.charAt(0).toUpperCase() }}</span>
                    </div>
                </div>

                <h1 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 tracking-tight">
                    {{ creator.name }}
                </h1>
                <p class="mt-2 text-indigo-600 dark:text-indigo-400 font-semibold text-lg tracking-wide">@{{ creator.slug }}</p>
                <p v-if="creator.bio" class="mt-4 text-gray-700 dark:text-gray-300 leading-relaxed text-center px-4">{{ creator.bio }}</p>
            </div>

            <!-- Boton de Apoyo (Modal) -->
            <div class="mt-8">
                <SupportModal :creator="creator" />
            </div>

            <!-- Links (Linktree Style) -->
            <div class="mt-8 space-y-4">
                <a 
                    v-for="link in creator.links" 
                    :key="link.id" 
                    :href="link.url" 
                    target="_blank" 
                    class="group relative block w-full py-4 px-6 text-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-md hover:bg-white dark:hover:bg-gray-700 text-gray-900 dark:text-white font-bold rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-white/40 dark:border-gray-700/50 overflow-hidden"
                >
                    <span class="relative z-10">{{ link.title }}</span>
                    <div class="absolute inset-0 h-full w-0 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-white/5 dark:to-white/5 transition-all duration-300 ease-out group-hover:w-full"></div>
                </a>

                <div v-if="!creator.links || creator.links.length === 0" class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No hay enlaces disponibles aún 👀</p>
                </div>
            </div>

        </div>
        
        <div class="mt-auto pt-16 text-center text-sm text-gray-500 dark:text-gray-500 pb-4 z-10 flex items-center gap-1 justify-center">
            Powered by 
            <a href="/" class="font-bold text-gray-800 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">eSponsor</a>
        </div>
    </div>
</template>
