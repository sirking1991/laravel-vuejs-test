<script setup>
import Paginator from '@/Components/Paginator.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

let props = defineProps({
    companies: Object,
    search: String
});

let search = ref(props.search);

watch(search, value => {
    router.get('/companies', {search: value}, {preserveState: true});
})
</script>

<template>
    <Head title="Companies" />

    <AuthenticatedLayout>
        
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between">
                        <span class="text-3xl" >
                            Companies
                        </span >
                        <input v-model="search" type="text" placeholder="Search..." class="border px-2 rounded-lg" />
                    </div>

                    <div class="p-6 text-gray-900">
                        <table class="table table-bordered table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="company in companies.data">
                                    <td class="p-3">{{ company.id }}</td>
                                    <td class="p-3">{{ company.name }}</td>
                                    <td class="p-3">{{ company.email }}</td>
                                    <td class="p-3">{{ company.phone }}</td>
                                    <td class="p-3">
                                        <Link 
                                            :href="`/company/${company.id}`"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            View
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-center mt-6">
                        <Paginator :links="companies.links"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
