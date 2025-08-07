<template>
  
  <video
  v-if="isVideo(currentVideo)"
    ref="videoRef"
    data-aos="zoom-in"
    class="w-screen h-screen object-cover"
    autoplay
    muted
    playsinline
    @ended="onVideoEnded"
  >
    <source :src="`/ncca-calendar/medias/${currentVideo}`" type="video/mp4" />
    <source :src="`/ncca-calendar/medias/${currentVideo}`" type="video/ogg" />
    Your browser does not support the video tag.
  </video>
  
  <img
  v-else
  :src="`/ncca-calendar/medias/${currentVideo}`"
  alt="Media"
  class="w-full h-screen object-contain mx-auto block"
/>
</template>

<script setup>
import { toRaw, ref, watch, onMounted } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({
  videos: Array,
});

const emit = defineEmits(['video-ended'])
// Initialize AOS
onMounted(() => {
  AOS.init();
  playVideo();
   console.log(toRaw(props.videos.length))
});

const videoRef = ref(null);
const currentIndex = ref(0);
const currentVideo = ref(toRaw(props.videos[currentIndex.value].file_location));
// When video changes, reload and play it
watch(() => currentVideo.value, (newVal, oldVal) => {
  if(isVideo(currentVideo.value))
  {
    playVideo();
  }
  else{
    setTimeout(() => {
      currentIndex.value++;
      currentVideo.value = props.videos[currentIndex.value].file_location;
    }, 1000)
  }
},{ immediate: true });

function VideosEnded(){
  emit('video-ended', 0);
}
function onVideoEnded() {
  if (currentIndex.value < props.videos.length - 1) {
    currentIndex.value++;
    currentVideo.value = props.videos[currentIndex.value].file_location;
  } else {
    // Optionally restart or stop
    currentIndex.value = 0;
    currentVideo.value = props.videos[0].file_location;
    VideosEnded();
  }
  
 
}

function playVideo() {
  const video = videoRef.value;
  if (video) {
    video.load(); // Reload the video
    video.play(); // Start playback
  }
}
function isVideo(file) {
  const videoExtensions = ['mp4', 'mov', 'avi', 'webm'];

  // Extract the extension
  const ext = file.split('.').pop().toLowerCase();

  return videoExtensions.includes(ext);
}
</script>
