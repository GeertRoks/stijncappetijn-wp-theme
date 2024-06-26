<script setup>
  const wordpress_host = 'http://wordpress';
  //const wordpress_host = 'http://localhost';
  const wordpress_api = '/wp-json/wp/v2';
  const config_api = '/wp-json/plugin_stijncappetijn_config/v1';
  const wordpress_api_url = wordpress_host + wordpress_api;
  const config_api_url = wordpress_host + config_api;

  const { data:site_configuration } = await useFetch(config_api_url+'/config');
  const { data:projects } = await useFetch(wordpress_api_url+'/posts/?per_page=100');
  const current_year = new Date().getFullYear();

  const route = useRoute();

  const showProjectModal = useState('showProjectModal', () => false);

  onMounted(() => {
    if (route.fullPath === "/") {
      showProjectModal.value = false;
    } else {
      const pathSegments = route.fullPath.split('/');
      showProjectModal.value = pathSegments[pathSegments.length - 1];
      document.getElementById('projects').scrollIntoView({ behavior: 'smooth' });
    }
  });

watch(route, (newRoute) => {
  const pathSegments = newRoute.fullPath.split('/');
  showProjectModal.value = pathSegments[pathSegments.length - 1];
}, { deep: true })

  const scrollArrow = () => {
    const element = document.getElementById('about');
    element.scrollIntoView({ behavior: 'smooth' });
  };

  const isImageOrVideoFile = (fileName) => {
    // Regular expression to match image file extensions
    const imageExtensions = /\.(jpg|jpeg|png|gif|bmp|svg\+xml)$/i;
    // Regular expression to match video file extensions
    const videoExtensions = /\.(mp4|webm|ogg|flv|avi|mov|wmv|mkv)$/i;

    // Check if the file name matches any of the image or video extensions
    if (imageExtensions.test(fileName)) {
        return 'image';
    } else if (videoExtensions.test(fileName)) {
        return 'video';
    } else {
        return 'unknown';
    }
  }
</script>


<template>
  <main v-if="site_configuration" class="bg-black text-white">
    <div id="page-wrapper" class="h-screen w-screen overflow-scroll" :class="{ 'overflow-hidden blur-sm': showProjectModal }">

      <section id="hero" class="relative h-screen w-screen">
        <div class="h-full w-full">
          <video v-if="isImageOrVideoFile(site_configuration.landing.background) === 'video'" id="bgVideo" class="h-full w-full object-cover" preload="true" autoplay loop muted>
            <source :src="site_configuration.landing.background" type="video/webm" /> 
          </video>
          <img v-else :src="site_configuration.landing.background" class="h-full w-full object-cover" />
        </div>
        <div class="absolute inset-0 flex flex-col justify-between items-center bg-gray-600/60 z-20">
          <div><!--spacer--></div>
          <div class="text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold my-4">
              {{ site_configuration.landing.title }}
            </h1>
            <p class="text-lg sm:text-2xl font-medium">
              {{ site_configuration.landing.subtitle }}
            </p>
          </div>
          <div class="p-4 text-4xl font-medium animate-bounce cursor-pointer" @click="scrollArrow()">
            &#65088
          </div>
        </div>
      </section>


      <section id="about" class="w-screen py-12">
        <div class="flex flex-col sm:flex-row-reverse items-start justify-center p-4 md:w-full lg:w-8/12 xl:w-6/12 m-auto">
          <img class="sm:w-4/12 m-auto" :src="site_configuration.about.picture"/>
          <div class="p-4 sm:w-8/12">
            <h2 class="text-4xl font-extrabold my-2">
              {{ site_configuration.about.biotitle }}
            </h2>
            <p class="text-xl text-gray-300">
              {{ site_configuration.about.bio }}
            </p>
          </div>
        </div>
      </section>


      <section id="projects" class="w-screen py-12 sm:px-2">
        <div class="min-w-screen-lg grid 2xl:grid-cols-6 xl:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
          <PostCard v-for="project,index in projects" :key="'project'+index" v-bind:project="project" v-bind:wordpress_host="wordpress_api_url" />
        </div>

      </section>


      <footer class="w-screen flex flex-col justify-center">
        <div class="my-4 flex flex-col items-center text-center justify-center text-sm">
          <div id="socials" class="mb-2 flex flex-row gap-2">
            <a v-for="social in site_configuration.footer.socials" :href="social[0]" class="text-white h-5 w-5" v-html="social[1]">
            </a>
          </div>
          <p>Copyright © {{ current_year }} | {{ site_configuration.landing.title }}</p>
          <p>Theme created with ❤️ by <a href="https://geertroks.com" class="underline">Geert Roks</a></p>
        </div>
      </footer>

    </div>
    <ProjectModal :project="projects.find(project => { return project.slug === showProjectModal })" :wordpress_host="wordpress_api_url" />
  </main>
  <div v-else class="h-screen flex flex-row justify-center">
    <div class="max-w-lg m-auto p-8 bg-gray-200">
      <h1 class="text-2xl font-bold my-2">Welcome to stijncappetijn.com</h1>
      <p>When you see this page, something went wrong. If you are a visitor, please contact the owner of this page and notify them of this message.</p>
    </div>
  </div>
</template>
