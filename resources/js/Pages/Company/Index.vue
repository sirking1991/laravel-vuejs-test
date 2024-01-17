<script setup>
import Paginator from '@/Components/Paginator.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import debounce from "lodash/debounce";

let props = defineProps({
    companies: Object,
    search: String
});

let search = ref(props.search);

watch(search, debounce(function(value){
    router.get('/companies', {search: value}, {preserveState: true, replace: true});
}, 300));

let destroy = (id) => {
    if (confirm('Are you sure?')){
        router.delete('/company/' + id);
    }
}

</script>

<template>
    <Head title="Companies" />

    <AuthenticatedLayout>
        
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between ">
                        <span class="text-3xl" >
                            Companies
                            <Link 
                                href="/company/new"
                                class="text-sm bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                                >Create new company</Link>
                        </span >
                        <input v-model="search" type="text" placeholder="Search..." class="border px-2 rounded-lg" />
                    </div>

                    <div class="p-6 text-gray-900">
                        <table class="table table-bordered table-responsive  mx-auto">
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
                                        |
                                        <Link 
                                            :href="`#`"
                                            v-on:click="destroy(company.id)"                                            
                                            class="text-red-600 hover:text-red-900">
                                            Delete
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
