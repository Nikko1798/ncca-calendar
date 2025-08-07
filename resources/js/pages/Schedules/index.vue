
<script setup lang="ts">
    import {ref, onMounted, onUnmounted, toRaw} from 'vue'
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head } from '@inertiajs/vue3';
    import Calendar from '../events/Calendar.vue'
    import { Button } from '@/components/ui/button'
    import SchedulModal from '../events/ScheduleModal.vue';
    import UpcomingEvent from '../events/UpcomingEvent.vue';
    import VideoPlayer from '../events/VideoPlayer.vue';
    const currentTheme=ref<'light' | 'dark'>('light')
    const currentIndex = ref(0)
    let interval = null
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'My Schedules',
            href: '/my-schedule',
        },
    ];
    const props = defineProps({
    events: Array // or Array if it's a list
    })
    const detectTheme= (()=>{
    currentTheme.value = document.documentElement.classList.contains('dark') ? 'dark' : 'light'
    })
    const changeComponent=(()=>{
            interval = setInterval(() => {
            currentIndex.value ++;
            if (currentIndex.value >= 3) {
                currentIndex.value = 0 // Loop back to start
            }
        }, 3000)
    })
    onMounted(()=>{
        detectTheme()
        changeComponent()
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
    <Head title="Events" />

    <AppLayout :breadcrumbs="breadcrumbs">
      
        <!-- <div class="flex justify-end mb-5 pr-7 pt-2">
            
            
        </div> -->
        <!-- <div class="p-7 flex flex-col md:flex-row gap-5"> -->
            <!-- Calendar -->
            <!-- <div class="md:w-2/3 w-full"> -->
                <div class="p-2">
                    <!-- <Calendar :rawEvents="events" v-if="currentTheme==='light'"/>
                    <Calendar :rawEvents="events" dark v-else /> -->
                </div>
                <div>
                    <Calendar v-if="currentIndex===0"  :rawEvents="events"></Calendar>
                    <UpcomingEvent v-if="currentIndex===1" :rawEvents="events"></UpcomingEvent>
                    <VideoPlayer v-if="currentIndex===2"></VideoPlayer>
                </div>
            <!-- </div> -->

            <!-- Details -->
             <!-- <div class="md:w-1/3 w-full flex flex-col">
                <SchedulModal></SchedulModal>
                <div class=" bg-gray-100 p-5 rounded-lg flex-1 mt-2">
                    
                    <h2 class="text-lg font-bold mb-3">Details</h2>
                    <p>Select an event to see details here.</p>
                </div>
            </div> -->
        <!-- </div> -->

    </AppLayout>
</template>
