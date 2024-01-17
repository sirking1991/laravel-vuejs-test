<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    links: Array,
});
</script>

<template>
    <span v-for="linkItem in links">
        <Link v-if="linkItem.url" :href="linkItem.url" v-html="linkItem.label" class="m-2" />
        <span v-else v-html="linkItem.label" class="text-gray-500"></span>                                
    </span>
</template>