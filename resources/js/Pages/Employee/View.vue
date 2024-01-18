<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';

let props = defineProps({
    companies: Object,
    employee: Object,
    errors: Object
});

let form = useForm({
    _method: 'put',
    first_name: props.employee.first_name,
    last_name: props.employee.last_name,
    email: props.employee.email,
    company_id: props.employee.company_id,
});

const submit = () => {
    router.post('/employee/' + props.employee.id, form);
};

let fullName = () => {
    return props.employee.first_name + ' ' + props.employee.last_name;
}
</script>

<template>
    <Head :title=fullName() />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  p-6">
                    <div class="flex justify-between">
                        <span class="text-3xl" >
                            {{fullName()}} (ID:{{ employee.id }})
                        </span >
                    </div>
                    <hr>
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-6">
                                    <label for="first_name" class="block mb-2 uppercase font-bold text-gray-700">First name</label>
                                    <input 
                                        v-model="form.first_name"
                                        type="text" 
                                        required
                                        class="border border-gray-400 p-2 w-full rounded-lg"
                                        >
                                    <div 
                                        v-if="errors.first_name" 
                                        v-text="errors.first_name" 
                                        class="text-red-500 ext-xs mt-1"></div>
                                </div>
                                <div class="mb-6">
                                    <label for="last_name" class="block mb-2 uppercase font-bold text-gray-700">Last name</label>
                                    <input 
                                        v-model="form.last_name"
                                        type="text" 
                                        required
                                        class="border border-gray-400 p-2 w-full rounded-lg"
                                        >
                                    <div 
                                        v-if="errors.last_name" 
                                        v-text="errors.last_name" 
                                        class="text-red-500 ext-xs mt-1"></div>
                                </div>
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
                                <label for="company_id" class="block mb-2 uppercase font-bold text-gray-700">Company</label>
                                <select                 
                                    v-model="form.company_id"
                                    required
                                    class="border border-gray-400 p-2 w-full rounded-lg">
                                    <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
                                </select>
                                <div 
                                    v-if="errors.company_id" 
                                    v-text="errors.company_id" 
                                    class="text-red-500 ext-xs mt-1"></div>
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
