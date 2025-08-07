import {ref, onMounted, onUnmounted, toRaw, watch, computed} from 'vue'
import type { Component } from 'vue';

import Calendar from '@/pages/events/Calendar.vue';
import UpcomingEvent from '@/pages/events/UpcomingEvent.vue';
import VideoPlayer from '@/pages/events/VideoPlayer.vue';

export function UseEventIndexService(props: any){
const currentIndex = ref(0)
let interval: ReturnType<typeof setInterval> | null = null
const components = [Calendar, UpcomingEvent, VideoPlayer];
// Get current component
const currentComponent = computed(() => components[currentIndex.value]);
const componentProps = computed(() => {
    const current = components[currentIndex.value];

    if (current === Calendar) {
        return { rawEvents: props.events };
    } else if (current === UpcomingEvent) {
        return { rawEvents: props.events };
    } else if (current === VideoPlayer) {
        return { videos: props.videos };
    }

    return {};
});

    
   
    const resetSlides=(()=>{
        currentIndex.value=0;
        changeComponent()
    });
    
    const goToSpecificComponent = (componentVal: Component) => {
        // const index=components.indexOf(component)
        const index = components.findIndex(component => component === componentVal);
        currentIndex.value=index
        return index;
    };

    const changeComponent=(()=>{
        interval = setInterval(() => {
            if(currentComponent.value!=Calendar)
            {
                if (interval !== null) {
                    clearInterval(interval);
                    interval = null;
                }
            }
            else{
                currentIndex.value++;
                
            }
            // if(props.videos.length>0){
            //     if (currentIndex.value >= 2) { //pag nasa vide na or last page
            //         if (interval !== null) {
            //             currentIndex.value=2;
            //             clearInterval(interval)
            //         } // Loop back to start
            //     }
            // }
            // else{
            //     if (currentIndex.value >= 2) {
            //         currentIndex.value=0;
            //     }
            // }

            
        }, 3000)
    })
    
    return {currentIndex,
         currentComponent, componentProps, resetSlides, goToSpecificComponent, changeComponent}
}