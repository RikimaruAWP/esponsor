<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-white dark:bg-[#0B0F19] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 selection:bg-indigo-500 selection:text-white relative overflow-hidden">
        
        <!-- Background Effects -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute top-[-20%] left-[-10%] w-[40rem] h-[40rem] bg-indigo-500/20 rounded-full blur-[150px]"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[30rem] h-[30rem] bg-pink-500/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative z-10 w-full mb-8 flex flex-col items-center">
            <Link href="/" class="flex flex-col items-center gap-4 group">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-xl shadow-indigo-500/20 transform group-hover:rotate-12 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-2xl font-black tracking-tight text-gray-900 dark:text-white group-hover:text-indigo-500 dark:group-hover:text-indigo-400 transition-colors">eSponsor<span class="text-indigo-500">Clone</span></span>
            </Link>
        </div>

        <div
            class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-white dark:bg-gray-900/80 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-3xl border border-gray-200 dark:border-white/10"
        >
            <slot />
        </div>
    </div>
</template>
