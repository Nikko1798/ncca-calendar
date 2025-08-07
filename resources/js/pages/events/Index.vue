<script setup lang="ts">
    import {ref, onMounted, onUnmounted, toRaw, watch, computed} from 'vue'
    import type { Component } from 'vue';
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head } from '@inertiajs/vue3';
    import { Button } from '@/components/ui/button'

    import Calendar from './Calendar.vue';
    import ScheduleModal from './ScheduleModal.vue';
    import UpcomingEvent from './UpcomingEvent.vue';
    import VideoPlayer from './VideoPlayer.vue';
    import { UseEventIndexService } from '@/services/EventService/EventIndex';
    const props = withDefaults(defineProps<{
        events?: any[],
        videos?: any[]
        }>(), {
        events: () => [],
        videos: () => []
    });
    const currentTheme=ref<'light' | 'dark'>('light')
    const detectTheme= (()=>{
        currentTheme.value = document.documentElement.classList.contains('dark') ? 'dark' : 'light'
    })
    const  { currentIndex, currentComponent, componentProps, 
        resetSlides, goToSpecificComponent, changeComponent } =UseEventIndexService(props)
    watch(currentIndex, (newVal, oldVal)=>{
        console.log(`newVal: ${newVal}`)
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
    <div>
        <!-- <Calendar v-if="currentIndex===0"  :rawEvents="events"></Calendar>
        <UpcomingEvent v-if="currentIndex===1" :rawEvents="events"></UpcomingEvent>
        <VideoPlayer v-if="currentIndex===2" :videos="videos" @video-ended="resetSlides"></VideoPlayer> -->
        <component
            :is="currentComponent"
            v-bind="componentProps"
            @video-ended="resetSlides"
            @goto-component="goToSpecificComponent"
            />
    </div>
</template>
