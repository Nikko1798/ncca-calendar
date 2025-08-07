<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import VideoTable from './VideoTable.vue';
import AddVideoForm from './AddVideoForm.vue';
import { router } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Videos',
        href: '/videos',
    },
];

 const props = withDefaults(defineProps<{
    videos?: any[]
    }>(), {
    videos: () => []
});
const refreshTable = (()=>{
  router.reload({
    only: ['videos'],
  });
});

</script>

<template>
    <Head title="Calendar" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <AddVideoForm></AddVideoForm>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <VideoTable @refresh-table="refreshTable" :videos="videos"></VideoTable>
        </div>
    </AppLayout>
</template>
