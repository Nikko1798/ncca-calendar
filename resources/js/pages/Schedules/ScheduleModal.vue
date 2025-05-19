<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { CalendarPlus } from 'lucide-vue-next';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Textarea } from '@/components/ui/textarea';
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button class="button-main">
        <CalendarPlus/>Create Schedule
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[800px]">
      <DialogHeader>
        <DialogTitle>Create a schedule</DialogTitle>
        <DialogDescription>
          Make a schedule here. Click save when you're done.
        </DialogDescription>
      </DialogHeader>
      <div class="grid gap-4 py-4">
        <div class="flex flex-col gap-2">
          <Label for="name">
            Title
          </Label>
          <Input id="name" default-value="Pedro Duarte" />
        </div>

        <div class="flex flex-col gap-2">
          <Label for="name">
            Desription
          </Label>
          <Textarea  id="name" default-value="Pedro Duarte" />
        </div>
        <div class="flex flex-row gap-4">
          <!-- Start Time -->
          <div class="flex flex-col gap-2 w-full">
            <Label for="start_time">Start Date</Label>
            <input
                type="date"
                id="start_date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
              />
          </div>

          <!-- End Time -->
          <div class="flex flex-col gap-2 w-full">
            <Label for="end_time">Start Time</Label>
            <input type="time" id="end_time"
              class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700"
              min="09:00" max="18:00" />
          </div>
        </div>

        <div class="flex flex-row gap-4">
          <!-- Start Time -->
          <div class="flex flex-col gap-2 w-full">
            <Label for="start_time">End Date</Label>
            <input
                type="date"
                id="start_date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
              />
          </div>

          <!-- End Time -->
          <div class="flex flex-col gap-2 w-full">
            <Label for="end_time">End Time</Label>
            <input type="time" id="end_time"
              class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700"
              min="09:00" max="18:00" />
          </div>
        </div>

      </div>
      <DialogFooter>
        <Button variant="destructive" type="submit">
          Save changes
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>