
<script setup lang="ts">
import {ref, onMounted, onUnmounted} from 'vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Calendar from './Calendar.vue'
import { Button } from '@/components/ui/button'
import SchedulModal from './ScheduleModal.vue';
const currentTheme=ref<'light' | 'dark'>('light')
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My Schedules',
        href: '/my-schedule',
    },
];
const detectTheme= (()=>{
   currentTheme.value = document.documentElement.classList.contains('dark') ? 'dark' : 'light'
})
onMounted(()=>{
detectTheme()
    const observer = new MutationObserver(() => {
        detectTheme()
    })
     observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class'],
  })

  // Cleanup observer when the component is unmounted
  onUnmounted(() => {
    observer.disconnect()
  })
})
</script>

<template>
    <Head title="My Schedules" />

    <AppLayout :breadcrumbs="breadcrumbs">
      
        <!-- <div class="flex justify-end mb-5 pr-7 pt-2">
            
            
        </div> -->
        <div class="p-7 flex flex-col md:flex-row gap-5">
            <!-- Calendar -->
            <div class="md:w-2/3 w-full">
                <Calendar v-if="currentTheme==='light'"/>
                <Calendar dark v-else />
            </div>

            <!-- Details -->
             <div class="md:w-1/3 w-full flex flex-col">
                <SchedulModal></SchedulModal>
                <div class=" bg-gray-100 p-5 rounded-lg flex-1 mt-2">
                    
                    <h2 class="text-lg font-bold mb-3">Details</h2>
                    <p>Select an event to see details here.</p>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
