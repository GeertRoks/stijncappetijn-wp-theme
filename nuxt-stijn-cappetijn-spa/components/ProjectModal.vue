<template>
  <div class="absolute inset-0 z-50 w-screen h-screen bg-black/60">
    <div class="w-1/2 m-auto bg-gray-600">
      <h6>Saved!</h6>
      <p>Your Details have been saved Successfully</p>
      <button @click="$emit('close-modal')">Go Home</button>
    </div>
  </div>
</template>

<script>
  export default {
    /*
    mounted() {
      window.onpopstate = this.close
    },
    beforeDestroy() {
      window.onpopstate = null
    },
    */
  }
</script>
