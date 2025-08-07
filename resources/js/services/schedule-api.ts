import axios from 'axios';
import { router } from '@inertiajs/vue3';
import { ref, reactive, toRaw, computed, onMounted  } from 'vue';
axios.defaults.headers.common["X-CSRF-TOKEN"] = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

export function useSchedApi(){
    const now = new Date();
    const formattedDate = now.toISOString().split('T')[0];
    const schedule=ref({
        title: '',
        details: '',
        start_date: formattedDate,
        start_time: '12:00',
        end_date: formattedDate, 
        end_time: '12:00'
    })
    
    const insertStepOne = () => {
        return axios.post(route('my-schedules.create'), schedule.value)
        .then((response) => {
            alert('success')
            return response.data;
        })
        .catch((error) => {
            console.log(error);
            alert('error')
            return error;
        });
    }
   
    return {schedule, insertStepOne}
}