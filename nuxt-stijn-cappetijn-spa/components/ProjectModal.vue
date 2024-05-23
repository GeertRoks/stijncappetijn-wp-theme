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
    <div v-show="showProjectModal" class="fixed inset-0 z-50 grid place-items-center w-screen h-screen bg-black/80 px-2 py-4 md:px-16 md:py-9">
      <div class="w-full h-full m-auto flex flex-col overflow-hidden max-w-screen-2xl">
        <header class="bg-gray-900 h-16 px-4">
          <button @click="closeProjectModal()" class="h-full text-4xl">&#10005</button>
        </header>
        <div v-if="showProjectModal" class="bg-gray-600 h-full flex-grow p-4 flex flex-col gap-4 overflow-scroll lg:overflow-hidden lg:flex-row">
          <div class="w-full lg:w-7/12 lg:p-20">
            <img :src="project.featured_media_url" class="h-full w-full object-contain" />
          </div>
          <div class="w-full lg:w-5/12 h-full lg:overflow-scroll">
            <h2 class="text-4xl font-extrabold my-2" v-html="props.project.title.rendered"></h2>
            <h3 class="my-1 font-medium text-xl text-gray-400">
              {{ new Date(props.project.date).toLocaleDateString('en-us', { year:"numeric", month:"short"}) }}
            </h3>
            <div class="project-content p-4" v-html="props.project.content.rendered"></div>
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
</script>

<style>
iframe {
  max-width: 100%;
}
</style>
