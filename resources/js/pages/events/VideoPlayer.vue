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
    <source :src="`${currentVideo}`" type="video/mp4" />
    <source :src="`${currentVideo}`" type="video/ogg" />
    Your browser does not support the video tag.
  </video>
  
  <img
  v-else
  :src="`${currentVideo}`"
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
const currentVideo = ref(toRaw(props.videos[currentIndex.value].completeVidUrl));
// When video changes, reload and play it
watch(() => currentVideo.value, (newVal, oldVal) => {
  console.log(props.videos[currentIndex.value].completeVidUrl)
  
   
      if(isVideo(currentVideo.value))
      {
        playVideo();
      }
      else{
        setTimeout(() => {
          currentIndex.value++;
          if(props.videos[currentIndex.value])
          {
            currentVideo.value = props.videos[currentIndex.value].completeVidUrl;
          }
         
          else{
            onVideoEnded()
          }
          
        }, 1000)
      }
    
  
},{ immediate: true });

function VideosEnded(){
  emit('video-ended', 0);
}
function onVideoEnded() {
  if (currentIndex.value < props.videos.length - 1) {
    currentIndex.value++;
    currentVideo.value = props.videos[currentIndex.value].completeVidUrl;
  } else {
    // Optionally restart or stop
    currentIndex.value = 0;
    currentVideo.value = props.videos[0].completeVidUrl;
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
