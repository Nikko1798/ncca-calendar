<script setup>
import axios from 'axios'
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
const emit = defineEmits(['refresh-table'])
const form = useForm({
    media: null,
    floor: 1,
    queue: 1,
});
function submit() {
  form.post(route('videos-view.insert'), {
    forceFormData: true, // ⬅ important for file uploads
    onSuccess: () => {
      if (confirm('Upload successful! Do you want to refresh the page?')) {
        location.reload(); // Refreshes the Inertia page without full reload
      }
    },
  })
}
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="default">
        Upload Video
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px]">
        <form @submit.prevent="submit">
        <DialogHeader>
            <DialogTitle>Upload Video</DialogTitle>
        </DialogHeader>
        
        <div class="grid gap-4 py-4">
            <div class="grid grid-cols-4 items-center gap-4">
            <Label for="media" class="text-right">
                File
            </Label>
                <Input id="media" type="file"  @change="e => form.media = e.target.files[0]"/>    
            </div>

            <div class="grid grid-cols-4 items-center gap-4">
            <Label for="username" class="text-right">
                Floor Number
            </Label>
            <Input id="username" v-model="form.floor" class="col-span-3" />
            </div>
            
            <div class="grid grid-cols-4 items-center gap-4">
            <Label for="username" class="text-right">
                Queue
            </Label>
            <Input id="queue" v-model="form.queue" class="col-span-3" />
            </div>
        </div>
        <DialogFooter>
            <Button type="submit">
            Save changes
            </Button>
        </DialogFooter>
        </form>
    </DialogContent>
  </Dialog>
</template>