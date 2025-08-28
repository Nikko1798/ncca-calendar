<style>
.vuecal {
  --vuecal-primary-color: #d41616;
}
.vuecal__event {color: #fff;border: 1px solid;}
.vuecal__event:hover {
    cursor: pointer;
}
.vuecal__event.leisure {background-color: #fd9c42d9;}
.vuecal__event.health {background-color: #57cea9cc;}
.vuecal__event.sport {background-color: #ff6666d9;}
.vuecal__event.lunch {
  background-color: repeating-linear-gradient(45deg, transparent 0 10px, #ffffff11 10px 20px);
  border: none;
}
</style>
<template>
  <div data-aos="zoom-in">
     <vue-cal
     
     @view-change="onViewChange"
     @cell-click="onCellClick"
        :events="events"
        events-on-month-view
        :views="{ days: { cols: 5, rows: 1 }, month: {} }"
        view="month"
        >
    </vue-cal>
  </div>
</template>
<script setup>
import axios from 'axios';
import { VueCal } from 'vue-cal'
import 'vue-cal/style'
import { useCalendarService } from '@/services/calendar-service'
import { onMounted, toRaw, ref } from 'vue'
import AOS from 'aos'
import 'aos/dist/aos.css'
const props=defineProps({
  rawEvents: Array
})
const events=ref([]);
onMounted(()=>{
  AOS.init()
})
// Helper to add days to a Date
const {getSchedule, onCellClick}=useCalendarService();




const onViewChange = view => {
  const formatted = view.start.toLocaleDateString('en-US', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit'
  })
  // `.format()` is an added Date prototype by vue-cal.
  // fetchEvents(view.start.format(), view.end.format())
  // alert(view.start.format())
  console.log(formatted)
}
onMounted(async ()=>{
  const data = await getEvents();
  events.value=data;
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