<script setup>
  const wordpress_host = 'http://localhost/wp-json/wp/v2'
  const { data:about } = await useFetch(wordpress_host+'/pages', { query: {slug: 'frontpage'} });
  const { data:featured_image } = await useFetch(wordpress_host+'/media/'+about.value[0].featured_media, { pick: ['source_url', 'media_details.filename'] });
  const { data:posts } = await useFetch(wordpress_host+'/posts');
  const current_year = new Date().getFullYear();

  const route = useRoute();

  const showProjectModal = useState('showProjectModal', () => false);

  onMounted(() => {
    console.log("mounted on route:", route.path);
    if (route.params.slug) {
      showProjectModal.value = route.params.slug[0];
    }
  });

  definePageMeta({
    pageTransition: {
    }
  })

</script>

<template>
  <main class="bg-black text-white"> 
    <div id="page-wrapper">

      <section id="hero" class="relative h-screen w-screen">
        <div class="h-full w-full">
          <video id="bgVideo" class="h-full w-full object-cover" preload="true" autoplay loop muted>
            <!-- TODO: make link variable, set in customize menu. Also give option for photo (use php to change between video and img tag) -->
            <source src="http://localhost/wp-content/uploads/2024/02/Home_Page.webm" type="video/webm" /> 
          </video>
        </div>
        <div class="absolute inset-0 flex flex-col justify-center bg-gray-600/60 z-20">
          <div class="text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold my-4">
              {{ about[0].title.rendered }}
            </h1>
            <p class="text-lg sm:text-2xl font-medium">Musician | Producer</p>
          </div>
        </div>
      </section>

      <hr>

      <section id="about" class="w-screen py-12">
        <div class="flex flex-row items-start justify-center w-6/12 m-auto">
          <div class="w-8/12 p-8">
            <h2 class="text-4xl font-extrabold">
              About Me
            </h2>
            <div v-html="about[0].content.rendered">
            </div>
          </div>
          <img class="w-4/12" :src="featured_image.source_url"/>
        </div>
      </section>

      <hr>

      <section id="projects" class="w-screen py-12 sm:px-2">
        <div class="min-w-screen-lg grid 2xl:grid-cols-6 xl:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
          <PostCard v-for="post,index in posts" :key="'project'+index" v-bind:post="post" v-bind:wordpress_host="wordpress_host" />
        </div>

      </section>

      <hr>

      <footer class="w-screen h-20 flex flex-col justify-center">
        <div class="flex flex-col items-center text-center justify-center text-sm">
          <p>Copyright © {{ current_year }} | {{ about[0].title.rendered }}</p>
          <p>Theme created with ❤️ by <a href="https://geertroks.com" class="underline">Geert Roks</a></p>
        </div>
      </footer>

    </div>
      <ProjectModal :project="posts.find(project => { return project.slug === showProjectModal })" :wordpress_host="wordpress_host" />
  </main>
</template>
