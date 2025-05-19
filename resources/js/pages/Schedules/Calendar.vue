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
     <vue-cal
     @cell-click="onCellClick"
        :events="events"
        events-on-month-view
        :views="{ days: { cols: 5, rows: 1 }, month: {} }"
        view="month"
        >
    </vue-cal>
</template>
<script setup>

import { VueCal } from 'vue-cal'
import 'vue-cal/style'
// Helper to add days to a Date
function addDays(date, days) {
  const result = new Date(date)
  result.setDate(result.getDate() + days)
  return result
}

const onCellClick=((date, events)=>{

  console.log('Clicked date:', date.cursor.date)
  console.log('Events on this date:', events)
})
const events = [
  {
    start: new Date(new Date().setHours(10, 30, 0, 0)),
    end: new Date(new Date().setHours(11, 30, 0, 0)),
    title: 'Doctor Appt.',
    content: '<i class="icon mdi mdi-stethoscope"></i>',
    class: 'health', // Custom class
    style: {
      backgroundColor: 'rgb(198 246 213)', // Light green
      color: '#065f46' // Dark green text
    }
  },
  {
    start: addDays(new Date(new Date().setHours(9, 0)), 4),
    end: addDays(new Date(new Date().setHours(10, 0)), 4),
    title: 'Doctor Appt.',
    content: '<i class="w-icon mdi mdi-stethoscope"></i>',
    class: 'health',
    style: {
      backgroundColor: 'rgb(158 199 237)', // Light blue
      color: '#0e5597' // Dark blue text
    }
  },
  // Add more events here...
]

</script>