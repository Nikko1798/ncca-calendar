<script setup lang="ts">
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

const props = withDefaults(defineProps<{
    videos?: any[]
    }>(), {
    videos: () => []
});
</script>

<template>
  <Table>
    <TableCaption>A list of your Videos.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead>ID</TableHead>
        <TableHead>File Name</TableHead>
        <TableHead class="text-right">
          Floor
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="item in videos" :key="item.id">
        <TableCell>{{ item.id }}</TableCell>
        <TableCell>
          <a :href="`/ncca-calendar/videos/${item.file_location}`">{{ item.file_location }}</a>
        </TableCell>
        <TableCell class="text-right">
          {{ item.floor }}
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>