<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="eSponsor Clone - Financia tu pasión" />
    <div class="min-h-screen bg-white dark:bg-[#0B0F19] text-gray-900 dark:text-gray-100 font-sans antialiased overflow-x-hidden selection:bg-indigo-500 selection:text-white">
        
        <!-- Background Effects -->
        <div class="fixed inset-0 z-0 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[30rem] h-[30rem] bg-pink-500/10 rounded-full blur-[150px]"></div>
        </div>

        <!-- Navbar -->
        <header class="relative z-50 w-full border-b border-gray-200/50 dark:border-white/10 bg-white/70 dark:bg-[#0B0F19]/70 backdrop-blur-lg sticky top-0">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-pink-500 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-xl font-black tracking-tight">eSponsor<span class="text-indigo-500 font-bold">Clone</span></span>
                </div>
                
                <nav v-if="canLogin" class="flex items-center gap-4">
                    <template v-if="$page.props.auth.user">
                        <Link :href="route('dashboard')" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            Ir a tu Panel
                        </Link>
                        <Link :href="route('dashboard')" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all">
                            Gestionar Creador
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="hidden sm:block text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white transition-colors">
                            Iniciar Sesión
                        </Link>
                        <Link v-if="canRegister" :href="route('register')" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 hover:shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                            Crear cuenta gratis
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <main class="relative z-10 w-full">
            <!-- Hero Section -->
            <section class="max-w-7xl mx-auto px-6 pt-20 pb-32 sm:pt-32 sm:pb-40 flex flex-col lg:flex-row items-center gap-16">
                
                <div class="flex-1 text-center lg:text-left animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-3 py-1 mb-8 rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-300 ring-1 ring-inset ring-indigo-200 dark:ring-indigo-500/20 text-sm font-semibold">
                        <span class="flex h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        La nueva era para Creadores
                    </div>
                    
                    <h1 class="text-5xl sm:text-6xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-br from-gray-900 via-gray-800 to-gray-500 dark:from-white dark:via-gray-100 dark:to-gray-400 tracking-tight leading-[1.1] mb-6">
                        Monetiza tu <br />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500">
                            comunidad
                        </span> hoy.
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                        Una plataforma todo-en-uno que te permite recibir donaciones simbólicas de tus seguidores. Sin costos ocultos, sin suscripciones complicadas. Solo tú y tu audiencia.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <Link v-if="!$page.props.auth.user" :href="route('register')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white dark:bg-white text-gray-900 font-extrabold text-lg hover:bg-gray-100 dark:hover:bg-gray-200 shadow-xl shadow-gray-200/50 dark:shadow-white/10 transition-all flex items-center justify-center gap-2">
                            Empieza en 2 minutos
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </Link>
                        <a href="#demo" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gray-100 dark:bg-white/5 text-gray-900 dark:text-white font-bold text-lg hover:bg-gray-200 dark:hover:bg-white/10 ring-1 ring-inset ring-gray-200 dark:ring-white/10 transition-colors flex items-center justify-center gap-2">
                            Conoce cómo funciona
                        </a>
                    </div>

                    <!-- Trust indicators -->
                    <div class="mt-12 pt-8 border-t border-gray-200 dark:border-white/10 flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white dark:border-[#0B0F19]" src="https://i.pravatar.cc/100?img=1" alt="User 1" />
                            <img class="w-10 h-10 rounded-full border-2 border-white dark:border-[#0B0F19]" src="https://i.pravatar.cc/100?img=2" alt="User 2" />
                            <img class="w-10 h-10 rounded-full border-2 border-white dark:border-[#0B0F19]" src="https://i.pravatar.cc/100?img=3" alt="User 3" />
                            <div class="w-10 h-10 rounded-full border-2 border-white dark:border-[#0B0F19] bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs font-bold text-gray-600 dark:text-gray-300">+2k</div>
                        </div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            Creadores ya están usando eSponsor<br class="hidden sm:block"> para impulsar su carrera.
                        </p>
                    </div>
                </div>

                <!-- Hero Visual (Linktree Mockup) -->
                <div class="flex-1 w-full max-w-sm lg:max-w-md relative animate-fade-in-up" style="animation-delay: 0.2s;">
                    <!-- Decorative elements around phone -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 dark:opacity-30 animate-blob"></div>
                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-pink-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 dark:opacity-30 animate-blob animation-delay-2000"></div>
                    
                    <!-- Phone Frame -->
                    <div class="relative bg-white dark:bg-gray-900 border-[8px] border-gray-200 dark:border-gray-800 rounded-[2.5rem] shadow-2xl overflow-hidden aspect-[9/19] w-full">
                        <!-- Dynamic Island Notch -->
                        <div class="absolute top-0 inset-x-0 h-7 flex justify-center z-20">
                            <div class="w-32 h-6 bg-gray-200 dark:bg-gray-800 rounded-b-3xl"></div>
                        </div>

                        <!-- Mockup Inner Content -->
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-100 to-pink-50 dark:from-gray-800 dark:to-indigo-950/30 flex flex-col items-center pt-16 px-6">
                            <!-- Avatar -->
                            <div class="w-24 h-24 rounded-full border-[4px] border-white dark:border-gray-800 shadow-lg overflow-hidden shrink-0">
                                <img src="https://i.pravatar.cc/150?img=12" class="w-full h-full object-cover" />
                            </div>
                            <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Alex Developer</h3>
                            <p class="mt-1 text-sm text-indigo-600 dark:text-indigo-400 font-semibold">@alexdev</p>
                            
                            <!-- Mockup Links -->
                            <div class="w-full mt-8 space-y-3">
                                <div class="w-full h-12 bg-white/60 dark:bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center font-bold text-sm text-gray-800 dark:text-gray-200 border border-white/50 dark:border-white/5 shadow-sm">Mi Canal de YouTube</div>
                                <div class="w-full h-12 bg-white/60 dark:bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center font-bold text-sm text-gray-800 dark:text-gray-200 border border-white/50 dark:border-white/5 shadow-sm">Sígueme en Twitter</div>
                                
                                <!-- Support Button -->
                                <div class="w-full h-14 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl flex items-center justify-center font-black text-sm text-white shadow-lg mt-6">
                                    💖 Apoyar a Alex
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Grid -->
            <section id="demo" class="max-w-7xl mx-auto px-6 py-24 sm:py-32 border-t border-gray-200/50 dark:border-white/5 relative">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight">Todo lo que necesitas, en un solo lugar.</h2>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Implementación de lado a lado con Vue 3 e Inertia JS.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white dark:bg-[#111827]/50 rounded-3xl p-8 border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Stack Tecnológico Sólido</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">Construido utilizando Laravel 11 para la seguridad en backend, y Vue 3 Composition API para una experiencia de usuario sin recargas tipo SPA.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-white dark:bg-[#111827]/50 rounded-3xl p-8 border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-pink-100 dark:bg-pink-900/50 text-pink-600 dark:text-pink-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Privacidad y Seguridad</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">Peticiones seguras con protección CSRF de base, Middlewares de autenticación de Laravel y validación de Datos Request nativos en el servidor.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white dark:bg-[#111827]/50 rounded-3xl p-8 border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Almacenamiento Nativo</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">No tienes que usar avatares de URLs de internet. Saca provecho del módulo de Storage de Laravel para guardar, vincular y mostrar tus imágenes locales con Inerita.</p>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer Custom -->
        <footer class="border-t border-gray-200 dark:border-white/10 bg-white/50 dark:bg-transparent">
            <div class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-lg font-black tracking-tight text-gray-900 dark:text-white">eSponsor<span class="text-indigo-500">Clone</span></span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-500 text-center">
                    Coded with ❤️ using Laravel v{{ laravelVersion }} and Vue 3 (PHP v{{ phpVersion }}) 
                </p>
                <div class="text-sm font-bold text-gray-400">
                    &copy; 2026 Todos los derechos reservados.
                </div>
            </div>
        </footer>
        
    </div>
</template>
