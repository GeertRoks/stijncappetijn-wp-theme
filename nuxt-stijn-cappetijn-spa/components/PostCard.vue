<script setup>
  const props = defineProps(['project', 'wordpress_host']);
  const has_image = (props.project.featured_media === 0) ? false : true;

  const showProjectModal = useState('showProjectModal', () => false);
  const openProjectModal = (slug) => {
    showProjectModal.value = slug;
    navigateTo(`/project/${slug}`);
  };

</script>

<template>
  <article>
    <div class="relative aspect-square">
      <img v-if="has_image" :src="project.featured_media_url" class="h-full w-full object-cover aspect-square" />
      <div @click="openProjectModal(props.project.slug)" class="p-4 absolute h-full inset-0 bg-gray-700 cursor-pointer hover:bg-black/60 transition" :class="{'opacity-0': has_image, 'hover:opacity-100': has_image}">
        <div class="">
          <h1 class="text-4xl text-white my-2 font-extrabold" v-html="props.project.title.rendered"></h1>

          <p class="text-xl font-medium text-gray-400 my-1">
            {{ new Date(props.project.date).toLocaleDateString('en-us', { year:"numeric", month:"short"}) }}
          </p>
        </div>
      </div>
    </div>
  </article>
</template>

