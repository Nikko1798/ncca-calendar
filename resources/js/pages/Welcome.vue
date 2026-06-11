<script setup lang="ts">
import {
    Card,
    CardContent,
} from '@/components/ui/card'

import { Button } from '@/components/ui/button'
import { Building2, ArrowRight } from 'lucide-vue-next'
import GuestLayout from '@/layouts/GuestLayout.vue';

const floors = [
    {
        id: 6,
        name: '6th Floor',
        description: 'Executive Offices',
    },
    {
        id: 5,
        name: '5th Floor',
        description: 'Accounting',
    },
    {
        id: 4,
        name: '4th Floor',
        description: 'IT Department',
    },
    {
        id: 3,
        name: '3rd Floor',
        description: 'Conference Rooms',
    },
    {
        id: 2,
        name: '2nd Floor',
        description: 'Human Resources',
    },
    {
        id: 1,
        name: 'Ground Floor',
        description: 'Lobby & Reception',
    },
]
const props = withDefaults(defineProps<{
    videos?: any[]
    }>(), {
    videos: () => []
});
</script>

<template>
    <GuestLayout >
        <div class="min-h-screen bg-muted text-muted-foreground p-6">
            <div  class="mx-auto max-w-7xl space-y-8">
                <!-- Header -->
                <div>
                    <h1 class="text-3xl font-bold">
                        Building Directory
                    </h1>

                   
                </div>

                <!-- Floor Grid -->
                <div
                    class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4"
                >
                    <Card
                        v-for="(item, index) in videos" :key="index"
                        class="group overflow-hidden transition-all hover:-translate-y-1 hover:shadow-xl"
                    >
                        <CardContent
                            class="flex aspect-square flex-col items-center justify-center p-6 text-center"
                        >
                            <div
                                class="mb-4 rounded-full bg-muted text-muted-foreground p-4"
                            >
                                <Building2
                                    class="h-10 w-10 text-primary"
                                />
                            </div>

                            <h2 class="text-lg font-semibold">
                                Floor Number: {{ item.floor }}
                            </h2>

                 
                            <a :href="route('events.index', item.floor)">
                                <Button
                                    class="mt-6"
                                    variant="outline"
                                >
                                    View
                                    <ArrowRight class="ml-2 h-4 w-4" />
                                </Button>
                            </a>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>