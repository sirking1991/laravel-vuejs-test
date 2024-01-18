<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

let props = defineProps({
    company: Object,
    errors: Object
});

let logo = ref(null);

const handleFileChanged = (event) => {
    logo = event.target.files[0];
};

let form = useForm({
    _method: 'put',
    name: props.company.name,
    email: props.company.email,
    phone: props.company.phone,
    logo: null,
});

const submit = () => {
    form.logo = logo;
    router.post('/company/' + props.company.id, form);
};
</script>

<template>
    <Head :title=company.name />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  p-6">
                    <div class="flex justify-between">
                        <span class="text-3xl" >
                            {{company.name}} (ID:{{ company.id }})
                        </span >
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
                                    v-if="errors.name" 
                                    v-text="errors.name" 
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
                                    v-if="errors.email" 
                                    v-text="errors.email" 
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
                                    v-if="errors.phone" 
                                    v-text="errors.phone" 
                                    class="text-red-500 ext-xs mt-1"></div>
                            </div>

                            <div class="mb-6">
                                <label for="logo" class="block mb-2 uppercase font-bold text-gray-700">Logo</label>
                                <input 
                                    @change="handleFileChanged"
                                    type="file" 
                                    name="logo" 
                                    id="logo"
                                    required
                                    class="border border-gray-400 p-2 w-full rounded-lg"
                                    >
                                <img :src="`/file?path=`+ company.logo" :alt="company.name" class="w-100">
                            </div>

                            <div class="mb-6">
                                <button type="submit" class="w-full bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
