<script setup>
import Paginator from '@/Components/Paginator.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import debounce from "lodash/debounce";

let props = defineProps({
    employees: Object,
    search: String
});

let search = ref(props.search);

watch(search, debounce(function(value){
    router.get('/employees', {search: value}, {preserveState: true, replace: true});
}, 300));

let destroy = (id) => {
    if (confirm('Are you sure?')){
        router.delete('/employee/' + id);
    }
}

</script>

<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between ">
                        <span class="text-3xl" >
                            Employees
                            <Link 
                                href="/employee/new"
                                class="text-sm bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                                >Create new employee</Link>
                        </span >
                        <input v-model="search" type="text" placeholder="Search..." class="border px-2 rounded-lg" />
                    </div>

                    <div class="p-6 text-gray-900">
                        <table v-if="employees.data.length>0" class="table table-bordered table-responsive  mx-auto">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">First name</th>
                                    <th scope="col">Last name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="employee in employees.data">
                                    <td class="p-3">{{ employee.id }}</td>
                                    <td class="p-3">{{ employee.first_name }}</td>
                                    <td class="p-3">{{ employee.last_name }}</td>
                                    <td class="p-3">{{ employee.email }}</td>
                                    <td class="p-3">{{ employee.company_name }}</td>
                                    <td class="p-3">
                                        <Link 
                                            :href="`/employee/${employee.id}`"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            View
                                        </Link>
                                        |
                                        <Link 
                                            :href="`#`"
                                            v-on:click="destroy(employee.id)"                                            
                                            class="text-red-600 hover:text-red-900">
                                            Delete
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <span v-else class="text-red-900 flex justify-center">No records</span>
                    </div>
                    <div class="flex justify-center mt-6">
                        <Paginator :links="employees.links"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
