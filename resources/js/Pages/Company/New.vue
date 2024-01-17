<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    errors: Object
});

let form = useForm({
    'name': '',
    'email': '',
    'phone': '',
    'logo': '',
});

let submit = () => {
    form.post('/company', form);
}

</script>

<template>
    <Head title='Create new company' />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  p-6">
                    <div class="flex justify-between">
                        <span class="text-3xl" >Create new company</span >
                    </div>
                    <hr>
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <label for="name" class="block mb-2 uppercase font-bold text-gray-700">Name</label>
                                <input 
                                    v-model="form.name"
                                    type="text" 
                                    name="name" 
                                    id="name"
                                    required
                                    class="border border-gray-400 p-2 w-full rounded-lg"
                                    >
                                <div 
                                    v-if="form.errors.name" 
                                    v-text="form.errors.name" 
                                    class="text-red-500 ext-xs mt-1"></div>
                            </div>

                            <div class="mb-6">
                                <label for="email" class="block mb-2 uppercase font-bold text-gray-700">Email</label>
                                <input 
                                    v-model="form.email"
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    required
                                    class="border border-gray-400 p-2 w-full rounded-lg"
                                    >
                                <div 
                                    v-if="form.errors.email" 
                                    v-text="form.errors.email" 
                                    class="text-red-500 ext-xs mt-1"></div>
                            </div>

                            <div class="mb-6">
                                <label for="phone" class="block mb-2 uppercase font-bold text-gray-700">Phone</label>
                                <input 
                                    v-model="form.phone"
                                    type="phone" 
                                    name="phone" 
                                    id="phone"
                                    required
                                    class="border border-gray-400 p-2 w-full rounded-lg"
                                    >
                                <div 
                                    v-if="form.errors.phone" 
                                    v-text="form.errors.phone" 
                                    class="text-red-500 ext-xs mt-1"></div>
                            </div>

                            <div class="mb-6">
                                <label for="logo" class="block mb-2 uppercase font-bold text-gray-700">Logo</label>
                                <input 
                                    type="file" 
                                    name="logo" 
                                    id="logo"
                                    class="border border-gray-400 p-2 w-full rounded-lg"
                                    >
                            </div>

                            <div class="mb-6">
                                <button 
                                    type="submit" 
                                    class="w-full bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                                    :disabled="form.processing"
                                    >Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
