<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    creator: Object,
});

const isModalOpen = ref(false);

const form = useForm({
    supporter_name: '',
    message: '',
    amount: 5,
});

const submitSupport = () => {
    form.post(route('support.store', props.creator.slug), {
        preserveScroll: true,
        onSuccess: () => {
            isModalOpen.value = false;
            form.reset();
            alert('¡Muchas gracias por tu apoyo! 💖');
        },
    });
};
</script>

<template>
    <div>
        <button @click="isModalOpen = true" class="w-full bg-gradient-to-r from-pink-500 hover:from-pink-600 to-rose-500 hover:to-rose-600 text-white font-black text-lg py-4 px-8 rounded-2xl shadow-xl hover:shadow-2xl hover:scale-[1.02] transform transition-all duration-300 border border-white/20">
            💖 Apoyar a {{ creator.name }}
        </button>

        <Modal :show="isModalOpen" @close="isModalOpen = false" maxWidth="md">
            <div class="p-8 bg-white dark:bg-gray-800 rounded-2xl">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="flex-shrink-0 w-10 h-10 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center text-pink-500 dark:text-pink-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">
                        Enviar Apoyo
                    </h2>
                </div>

                <form @submit.prevent="submitSupport" class="space-y-5">
                    <div>
                        <InputLabel for="supporter_name" value="Tu Nombre" class="font-bold text-gray-700 dark:text-gray-300" />
                        <TextInput id="supporter_name" v-model="form.supporter_name" type="text" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:ring-pink-500 focus:border-pink-500" required placeholder="Juan Pérez" />
                    </div>

                    <div>
                        <InputLabel for="amount" value="Monto ($)" class="font-bold text-gray-700 dark:text-gray-300" />
                        <div class="relative mt-1 rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                            </div>
                            <TextInput id="amount" v-model="form.amount" type="number" min="1" max="1000" class="block w-full rounded-xl pl-7 border-gray-300 dark:border-gray-600 focus:ring-pink-500 focus:border-pink-500 text-lg font-bold text-indigo-900 dark:text-indigo-100" required />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="message" value="Mensaje (Opcional)" class="font-bold text-gray-700 dark:text-gray-300" />
                        <textarea id="message" v-model="form.message" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-pink-500 focus:border-pink-500 shadow-sm transition-colors" rows="3" placeholder="¡Me encanta tu contenido!"></textarea>
                    </div>

                    <div class="mt-8 flex justify-end gap-4 items-center">
                        <button type="button" @click="isModalOpen = false" class="text-sm font-semibold text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">Cancelar</button>
                        <button type="submit" :disabled="form.processing" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-900 to-gray-800 dark:from-white dark:to-gray-200 border border-transparent rounded-xl font-bold text-xs text-white dark:text-gray-900 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition shadow-md hover:shadow-lg disabled:opacity-50">
                            Enviar ${{ form.amount }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>
