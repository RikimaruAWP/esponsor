<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Crear Cuenta" />

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Únete a eSponsor</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Crea tu página gratis y empieza a recibir apoyo.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="name" value="Nombre Completo" class="font-bold text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Juan Pérez"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Correo Electrónico" class="font-bold text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="tu@correo.com"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Contraseña" class="font-bold text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirmar Contraseña" class="font-bold text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="pt-2 flex flex-col items-center gap-4">
                <PrimaryButton
                    class="w-full flex justify-center py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all"
                    :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                    :disabled="form.processing"
                >
                    Crear mi cuenta
                </PrimaryButton>
                
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    ¿Ya tienes una cuenta?
                    <Link
                        :href="route('login')"
                        class="font-bold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
                    >
                        Inicia sesión aquí
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
