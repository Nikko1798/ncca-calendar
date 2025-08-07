<script setup>
import axios from 'axios'
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Components
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    picture: null,
    picture1: null,
    picture2: null,
});
function submit() {
  form.post(route('profile.uploadVideos'), {
    forceFormData: true, // ⬅ important for file uploads
  })
}
const closeModal = () => {
    form.clearErrors();
    form.reset();
};

</script>

<template>
    <div class="space-y-6">
        <HeadingSmall title="Upload videos" description="Connect your google Account here." />
            <form @submit.prevent="submit">
                <div class="space-y-4 rounded-lg border border-black-100 p-4 dark:border-red-200/10 dark:bg-red-700/10"> 
                    <Input id="picture" type="file" @change="e => form.picture = e.target.files[0]" />
                    <Input id="picture1" type="file" @change="e => form.picture1 = e.target.files[0]" />
                    <Input id="picture2" type="file" @change="e => form.picture2 = e.target.files[0]" />
                </div>
                
                <div class="flex items-center gap-4">
                    <Button type="submit" :disabled="form.processing">Upload</Button>
                </div>
            </form>
    </div>
</template>
