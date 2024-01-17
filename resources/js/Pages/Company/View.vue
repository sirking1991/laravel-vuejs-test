<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    company: Object,
});
</script>

<template>
    <Head :title=company.name />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ company.name }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
