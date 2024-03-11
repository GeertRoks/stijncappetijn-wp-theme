<template>
  <div>
    <transition
        enter-active-class="transition-opacity duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-100 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
    <div v-show="showProjectModal" class="fixed inset-0 z-50 grid place-items-center w-screen h-screen bg-black/80 px-2 py-4 md:px-16 md:py-9 lg:px-32 lg:py-18">
      <div class="w-full h-full m-auto flex flex-col overflow-hidden">
        <header class="bg-gray-900 h-16 px-4">
          <button @click="closeProjectModal()" class="h-full text-4xl">&#10005</button>
        </header>
        <div v-if="showProjectModal" class="bg-gray-600 flex-grow p-4 overflow-scroll flex flex-col md:flex-row">
          <div class="w-full sm:w-1/2 2xl:w-2/3">
            image or video, gallery?
          </div>
          <div class="w-full sm:w-1/2 2xl:w-1/3">
            <h2 class="text-4xl font-extrabold my-2">{{ props.project.title.rendered }}</h2>
            <h3 class="my-1 font-medium text-xl text-gray-400">
              {{ new Date(props.project.date).toLocaleDateString('en-us', { year:"numeric", month:"short"}) }}
            </h3>
            <div v-html="props.project.content.rendered"></div>
          </div>
        </div>
      </div>
    </div>
    </transition>
  </div>
</template>

<script setup>
  const props = defineProps(['project', 'wordpress_host']);

  const route = useRoute();
  const showProjectModal = useState('showProjectModal', () => false);
  const closeProjectModal = () => {
    showProjectModal.value = false;
    navigateTo(`/`);
  };
  console.log(props.project);
</script>

<script>
  //export default {
    /*
    mounted() {
      window.onpopstate = this.close
    },
    beforeDestroy() {
      window.onpopstate = null
    },
    */
  //}
</script>
