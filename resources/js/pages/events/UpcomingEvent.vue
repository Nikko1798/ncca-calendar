<template>
    <div class="p-10" >
      
      <p class="text-2xl font-bold mb-2" data-aos="fade-right" >Events for the week</p>
        <div class="grid grid-cols-2 gap-2 "  >
          <div v-for="item in formattedEvents" :key="item.title" class="p-5 " data-aos="fade-right">
                  <!-- {{ item.title }} -->
            <Card class="w-1/2] border border-gray-300 bg-blue-600 text-white ">
                <CardHeader>
                  <CardTitle>{{ item.title }}</CardTitle>
                  <CardDescription class="text-white">{{ item.formattedStart }} - {{ item.formatedDateEnd }}.</CardDescription>
                </CardHeader>
                <CardContent>
                  <!-- <h4><b>Attendees</b> {{ item.attendees.length>1 ? item.attendees.length: 1 }}</h4> -->
                  <div class="flex flex-wrap gap-2">
                    <Badge v-for="attendeesitm in item.attendees" :key="attendeesitm.email" class="bg-blue-500">
                      {{ attendeesitm.email }}
                    </Badge>
                  </div>
                </CardContent>
            </Card>
          </div>
        </div>
    </div>
    <div class="p-10">
     
    </div>
</template>
<script setup >
import axios from 'axios'
import AOS from 'aos'
import 'aos/dist/aos.css'
import VideoPlayer from './VideoPlayer.vue'
import {ref, onMounted, toRaw, onBeforeUnmount, computed} from 'vue'
import { Badge } from '@/components/ui/badge'
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
const props=defineProps({
    rawEvents: Array
})
const eventsData=ref([])
const groupSize = 4
const currentIndex = ref(0)
let interval = null
const emit = defineEmits(['goto-component'])

const getStartOfWeek=(()=>{
  const today=new Date();
  const dayOfWeek = today.getDay(); 
  const mondayBasedOffset = (dayOfWeek + 6) % 7;
  // Get start of the week (Monday)
  const startOfWeek = new Date(today);
  startOfWeek.setDate(today.getDate() - mondayBasedOffset);
  return startOfWeek;
});
const getEndOfTheWeek=(()=>{

  const startOfWeek=getStartOfWeek();
  // Get end of the week (Sunday)
  const endOfWeek = new Date(startOfWeek);
  endOfWeek.setDate(startOfWeek.getDate() + 6);
  return endOfWeek;
})
const visibleEvents = computed(() => {
  const filtered = eventsData.value.filter(event => {
    const eventDate = new Date(event.start)
    return eventDate >= getStartOfWeek() && eventDate <= getEndOfTheWeek()
  })
  const start = currentIndex.value
  return filtered.slice(start, start + groupSize)
})
const AllEventsForTheWeekSize=computed(()=>{
  const filtered = eventsData.value.filter(event => {
    const eventDate = new Date(event.start)
    return eventDate >= getStartOfWeek() && eventDate <= getEndOfTheWeek()
  })
  return filtered.length;
});

const formattedEvents = computed(() => {
  return visibleEvents.value.map(event => {
    const dateStart = new Date(event.start);
    const dateEnd = new Date(event.end);
    const formattedStart = new Intl.DateTimeFormat('en-US', {
      timeZone: 'Asia/Singapore',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      hour12: false,
    }).format(dateStart).replace(',', '');
    const formatedDateEnd =new Intl.DateTimeFormat('en-US', {
      timeZone: 'Asia/Singapore',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      hour12: false,
    }).format(dateEnd).replace(',', '');
    return {
      ...event,
      formatedDateEnd: formatedDateEnd,
      formattedStart:  formattedStart,// Replace original start value
    };
  });
});


onMounted(() => {
  console.log(AllEventsForTheWeekSize.value)
  console.log(`curr: ${currentIndex.value} ${props.rawEvents.length}`)
  AOS.init()
  interval = setInterval(() => {
    
    if ((currentIndex.value) >= (AllEventsForTheWeekSize.value -1 )) {
      if(interval!==null)
      {
        clearInterval(interval);
        currentIndex.value = 0 // Loop back to start
        goToSpecificComponent();
      }
    }
    else{
      
      currentIndex.value += groupSize
    }
  }, 3000)
})
function goToSpecificComponent(){
  emit('goto-component', VideoPlayer);
}
onBeforeUnmount(() => {
  clearInterval(interval)
})


onMounted(async ()=>{
  const data = await getEvents();
  eventsData.value=data;
  console.log(data); // logs actual data
})
const getEvents=async ()=>{
  return axios.get(route('calendar-events.all'))
  .then((response) => {
      return response.data
  })
  .catch((error) => {
    console.log(error);
    let errorStr=getErrorStr(error.response.data.errors);
      warning(errorStr)
      return error;
  });
}
</script>