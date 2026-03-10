<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar Sesión" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 p-3 rounded-xl border border-green-200 dark:border-green-800">
            {{ status }}
        </div>

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Bienvenido de nuevo</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Ingresa tus credenciales para acceder a tu panel.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="email" value="Correo Electrónico" class="font-bold text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="tu@correo.com"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <InputLabel for="password" value="Contraseña" class="font-bold text-gray-700 dark:text-gray-300" />
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                    >
                        ¿Olvidaste tu contraseña?
                    </Link>
                </div>
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center cursor-pointer">
                    <Checkbox name="remember" v-model:checked="form.remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                    <span class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-400 select-none">Recordarme</span>
                </label>
            </div>

            <div class="pt-2">
                <PrimaryButton
                    class="w-full flex justify-center py-3 rounded-xl bg-gradient-to-r from-gray-900 to-gray-800 dark:from-white dark:to-gray-200 text-white dark:text-gray-900 shadow-lg hover:shadow-xl transition-all"
                    :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                    :disabled="form.processing"
                >
                    Iniciar Sesión
                </PrimaryButton>
            </div>
            
            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
                ¿No tienes una cuenta?
                <Link :href="route('register')" class="font-bold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                    Regístrate gratis
                </Link>
            </p>
        </form>
    </GuestLayout>
</template>
