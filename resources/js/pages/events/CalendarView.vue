<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

import Calendar from './Calendar.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Calendar',
        href: '/calendar',
    },
];
 const props = defineProps({
    events: Array // or Array if it's a list
})
</script>

<template>
    <Head title="Calendar" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Calendar :rawEvents="events"></Calendar>
        </div>
    </AppLayout>
</template>
