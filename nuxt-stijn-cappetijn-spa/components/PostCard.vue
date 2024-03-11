<script setup>
  const props = defineProps(['post', 'wordpress_host']);
  const { data: post_image } = await useFetch(props.wordpress_host+'/media/'+props.post.featured_media, { pick: ['source_url', 'media_details.filename'] })
  const has_image = (props.post.featured_media === 0) ? false : true;
  const post_path = "project/" + props.post.slug;

  //const showPost = useState('showPost');
  const showProjectModal = useState('showProjectModal', () => false);
  const openProjectModal = (slug) => {
    showProjectModal.value = slug;
    navigateTo(`/project/${slug}`);
  };

</script>

<template>
  <article>
    <div class="relative aspect-square">
      <!--
        <?php
        if ( has_post_thumbnail() ) :
        the_post_thumbnail('full', array('class' => 'object-cover aspect-square'));
        ?>
        <a v-if="" href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>" class="absolute h-full inset-0 opacity-0 hover:opacity-100 bg-black/60 cursor-pointer p-4">
        <a v-if="" href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>" class="absolute h-full inset-0 opacity-100 hover:bg-black/60 bg-gray-700 cursor-pointer p-4">
      <a v-else href="/" alt="/" class="absolute h-full inset-0 hover:bg-black/60 bg-gray-700 cursor-pointer p-4">
      -->
      <img v-if="has_image" :src="post_image.source_url" class="h-full w-full object-cover aspect-square" />
      <!--
        <NuxtLink :to="post_path" class="p-4 absolute h-full inset-0 bg-gray-700 cursor-pointer hover:bg-black/60 transition" v-bind:class="{'opacity-0': has_image, 'hover:opacity-100': has_image}">
      -->
      <div @click="openProjectModal(props.post.slug)" class="p-4 absolute h-full inset-0 bg-gray-700 cursor-pointer hover:bg-black/60 transition" :class="{'opacity-0': has_image, 'hover:opacity-100': has_image}">
        <div class="">
          <h1 class="text-4xl text-white my-2 font-extrabold">
            <!--
              <?php the_title(); ?>
            -->
            {{ props.post.title.rendered }}
          </h1>
          <p class="text-xl font-medium text-gray-400 my-1">
          <!--
            <?php the_date(); ?>
          -->
          {{ new Date(props.post.date).toLocaleDateString('en-us', { year:"numeric", month:"short"}) }}
          </p>
        </div>
        <!--
      </NuxtLink>
        -->
      </div>
    </div>
  </article><!-- #post-## -->
</template>

