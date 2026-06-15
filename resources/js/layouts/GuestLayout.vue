<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
 
import { ChartArea, LogIn } from 'lucide-vue-next';
const page = usePage() as any;
</script>

<template>

    <div
        class="min-h-screen flex flex-col bg-muted text-muted-foreground"
    >
        <!-- Header -->
        <header class="w-full p-4 border-b  rounded-b-lg shadow-xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal hover:border-[#1915014a] dark:border-[#3E3E3A] dark:hover:border-[#62605b]"
                >
                    <div class="flex flecx-row gap-2 items-center">
                        <ChartArea class="w-4 h-4" /> Go to Dashboard
                    </div>
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal hover:border-[#19140035] dark:hover:border-[#3E3E3A]"
                    >
                    
                        <div class="flex flecx-row gap-2 items-center">
                            <LogIn class="w-4 h-4" /> Go to Login
                        </div>
                    </Link>
                </template>
            </nav>
        </header>

        <!-- Body -->
        <main class="flex-1 flex p-4 ">
            <div class="w-full ">
                <slot />
            </div>
        </main>
    </div>
</template>