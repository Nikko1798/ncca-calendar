<script setup lang="ts">
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
    password: '',
});

const closeModal = () => {
    form.clearErrors();
    form.reset();
};
const fetchAuthUrl = async () => {
  const res = await axios.get('/ncca-calendar/google/auth')
  window.location.href = res.data.authUrl
}
</script>

<template>
    <div class="space-y-6">
        <HeadingSmall title="Connect to Google Account" description="Connect your google Account here." />
        <div class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
            <Button @click="fetchAuthUrl">Connect to google</Button>
        </div>
    </div>
</template>
