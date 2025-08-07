import axios from 'axios';
import { router } from '@inertiajs/vue3';

export function useCalendarService(){
    const getSchedule=((start: String, end: String)=>{
        return axios.post(route('my-schedules.get'),{
            start_date: start, end_date: end
        } )
        .then((response) => {
            console.log(response)
            return response.data;
        })
        .catch((error) => {
            console.log(error);
            alert('error')
            return error;
        });
    });

    const onCellClick=((date: any, events: any)=>{

        console.log('Clicked date:', date.cursor.date)
        console.log('Events on this date:', events)
    })
    return {getSchedule, onCellClick}
}