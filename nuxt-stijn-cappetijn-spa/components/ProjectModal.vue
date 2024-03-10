<template>
  <div>
    <transition name="fade" mode="out-in">
    <div v-show="showProjectModal" class="fixed inset-0 z-50 grid place-items-center w-screen h-screen bg-black/60 transition duration-200 ease-out opacity-0" :class="{'opacity-100' : showProjectModal}">
      <div class="w-1/2 m-auto transition duration-200">
        <header class="bg-gray-900">
          <button @click="closeProjectModal()">Go Home</button>
        </header>
        <div v-if="showProjectModal" class="bg-gray-600">
          <h2> {{ props.project.title.rendered }}</h2>
          <div v-html="props.project.content.rendered"></div>
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
