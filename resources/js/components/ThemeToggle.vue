<script setup lang="ts">
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { useColorMode } from '@vueuse/core'
import {SunMoon} from 'lucide-vue-next'

// Pass { disableTransition: false } to enable transitions
const mode = useColorMode({
  selector: 'html', // apply the "dark" class to the <html> tag
  attribute: 'class', // manage it via class, not data-attribute
  modes: {
    auto: 'auto', // optional
    light: 'light',
    dark: 'dark'
  }
})
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      
        <!-- <Icon icon="radix-icons:moon" class="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
        <Icon icon="radix-icons:sun" class="absolute h-[1.2rem] w-[1.2rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" /> -->
        <SunMoon class="icon-header"></SunMoon>
        <span class="sr-only">Toggle theme</span>
      
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuItem style="cursor: pointer;" @click="mode = 'light'">
        Light
      </DropdownMenuItem>
      <DropdownMenuItem style="cursor: pointer;" @click="mode = 'dark'">
        Dark
      </DropdownMenuItem>
      <DropdownMenuItem style="cursor: pointer;" @click="mode = 'auto'">
        System
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>