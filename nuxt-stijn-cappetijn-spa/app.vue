<script setup>
  const wordpress_host = 'http://localhost';
  const wordpress_api = '/wp-json/wp/v2';
  const config_api = '/wp-json/plugin_stijncappetijn_config/v1';
  const wordpress_api_url = wordpress_host + wordpress_api;
  const config_api_url = wordpress_host + config_api;

  const { data:site_configuration } = await useFetch(config_api_url+'/config');
  //const { data:featured_image } = await useFetch(wordpress_api_url+'/media/'+about.value[0].featured_media, { pick: ['source_url', 'media_details.filename'] });
  const { data:posts } = await useFetch(wordpress_api_url+'/posts/?per_page=100');
  const current_year = new Date().getFullYear();

  const route = useRoute();

  const showProjectModal = useState('showProjectModal', () => false);

  onMounted(() => {
    console.log("mounted on route:", route.path);
    if (route.params.slug) {
      showProjectModal.value = route.params.slug[0];
      document.getElementById('projects').scrollIntoView({ behavior: 'smooth' });
    }
  });

  const scrollArrow = () => {
    const element = document.getElementById('about');
    element.scrollIntoView({ behavior: 'smooth' });
    console.log(posts.value);
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
  <main class="bg-black text-white"> 
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

      <hr>

      <section id="about" class="w-screen py-12">
        <div class="flex flex-col sm:flex-row-reverse items-start justify-center p-4 md:w-full lg:w-8/12 xl:w-6/12 m-auto">
          <img class="sm:w-4/12 m-auto" :src="site_configuration.about.picture"/>
          <div class="p-4 sm:w-8/12">
            <h2 class="text-4xl font-extrabold">
              {{ site_configuration.about.biotitle }}
            </h2>
            <p>
              {{ site_configuration.about.bio }}
            </p>
          </div>
        </div>
      </section>

      <hr>

      <section id="projects" class="w-screen py-12 sm:px-2">
        <div class="min-w-screen-lg grid 2xl:grid-cols-6 xl:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
          <PostCard v-for="post,index in posts" :key="'project'+index" v-bind:post="post" v-bind:wordpress_host="wordpress_api_url" />
        </div>

      </section>

      <hr>

      <footer class="w-screen flex flex-col justify-center">
        <div class="my-4 flex flex-col items-center text-center justify-center text-sm">
          <div id="socials" class="mb-2 flex flex-row gap-2">
            <a href="https://www.instagram.com/stijn.cappetijn/" class="text-white h-5 w-5">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" stroke-width="0.9600000000000002"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.06167 7.24464C3.10844 6.22264 3.26846 5.56351 3.48487 5.00402L3.48778 4.99629C3.70223 4.42695 4.03818 3.91119 4.47224 3.48489L4.47833 3.47891L4.48431 3.47282C4.91096 3.0382 5.42691 2.70258 5.99575 2.4887L6.00556 2.48495C6.56378 2.26786 7.22162 2.10843 8.24447 2.06167M3.06167 7.24464C3.0125 8.33659 2.99997 8.67508 2.99997 11.5063C2.99997 14.3381 3.01181 14.6758 3.06164 15.768M3.06167 7.24464L3.06167 7.52008M3.48867 18.0168C3.70255 18.5856 4.03817 19.1015 4.47279 19.5282L4.47887 19.5342L4.48484 19.5402C4.91116 19.9743 5.42694 20.3103 5.99628 20.5247L6.00478 20.5279C6.56351 20.7446 7.22167 20.9041 8.24447 20.9509M3.48867 18.0168L3.48492 18.0069C3.26783 17.4487 3.1084 16.7909 3.06164 15.768M3.48867 18.0168L3.47585 17.9492M3.06164 15.768L3.07839 15.8562M3.06164 15.768L3.06164 15.4919M3.47585 17.9492L3.07839 15.8562M3.47585 17.9492C3.30704 17.5033 3.13322 16.881 3.07839 15.8562M3.47585 17.9492C3.48177 17.9649 3.48768 17.9803 3.49359 17.9955C3.70766 18.5726 4.04685 19.0952 4.48679 19.5256C4.91708 19.9655 5.43944 20.3046 6.01636 20.5187C6.47934 20.699 7.13172 20.8875 8.24431 20.9385C9.3671 20.9896 9.71399 21 12.5062 21C15.2985 21 15.6457 20.9896 16.7685 20.9385C17.8824 20.8874 18.534 20.6979 18.9954 20.519C19.5726 20.305 20.0953 19.9657 20.5257 19.5256C20.9655 19.0953 21.3046 18.573 21.5187 17.9961C21.699 17.5331 21.8875 16.8808 21.9384 15.7682C21.9895 14.6454 22 14.2978 22 11.5063C22 8.71472 21.9895 8.36684 21.9384 7.24405C21.8871 6.12427 21.6959 5.47168 21.5161 5.00992C21.2811 4.40322 20.9831 3.94437 20.525 3.48627C20.0678 3.02999 19.6102 2.73179 19.003 2.49654C18.5396 2.31537 17.8866 2.12531 16.7685 2.07406C16.6712 2.06964 16.5798 2.06552 16.4921 2.06168M3.07839 15.8562C3.07684 15.8273 3.07539 15.7981 3.07403 15.7685C3.06961 15.6712 3.06548 15.5797 3.06164 15.4919M8.24447 2.06167C9.33668 2.01184 9.67505 2 12.5062 2C15.3374 2 15.6756 2.01252 16.7675 2.06168M8.24447 2.06167L8.52062 2.06167M16.7675 2.06168L16.4921 2.06168M16.7675 2.06168C17.7897 2.10844 18.4489 2.26844 19.0085 2.48487L19.0162 2.48781C19.5855 2.70226 20.1013 3.03821 20.5276 3.47227L20.5335 3.4783L20.5396 3.48422C20.9737 3.91055 21.3096 4.42646 21.5239 4.99596L21.5275 5.00559C21.7446 5.56381 21.9041 6.22165 21.9508 7.2445M8.52062 2.06167L16.4921 2.06168M8.52062 2.06167C9.44548 2.02123 9.95666 2.01253 12.5062 2.01253C15.056 2.01253 15.5671 2.02124 16.4921 2.06168M8.52062 2.06167C8.43284 2.06551 8.34134 2.06964 8.24402 2.07406C7.13004 2.12512 6.47843 2.31464 6.01708 2.49358C5.43767 2.70837 4.91328 3.04936 4.48192 3.49186C4.0281 3.94756 3.73105 4.40422 3.49655 5.0094C3.31536 5.4728 3.12527 6.12614 3.07402 7.24434C3.06961 7.34135 3.06549 7.43257 3.06167 7.52008M21.9508 15.768C21.9041 16.7908 21.7446 17.449 21.5279 18.0077L21.5247 18.0162C21.3102 18.5856 20.9743 19.1013 20.5402 19.5276L20.5341 19.5336L20.5282 19.5397C20.1015 19.9743 19.5856 20.3099 19.0167 20.5238L19.0069 20.5276C18.4487 20.7447 17.7908 20.9041 16.768 20.9509M3.06164 15.4919C3.0212 14.567 3.0125 14.0558 3.0125 11.5063C3.0125 8.95591 3.0212 8.44544 3.06167 7.52008M3.06164 15.4919L3.06167 7.52008M10.8155 15.5881C11.3515 15.8101 11.926 15.9244 12.5062 15.9244C13.678 15.9244 14.8018 15.4589 15.6304 14.6304C16.4589 13.8018 16.9244 12.678 16.9244 11.5063C16.9244 10.3345 16.4589 9.21072 15.6304 8.38215C14.8018 7.55359 13.678 7.0881 12.5062 7.0881C11.926 7.0881 11.3515 7.20238 10.8155 7.42442C10.2794 7.64645 9.79239 7.97189 9.38213 8.38215C8.97187 8.79242 8.64643 9.27947 8.42439 9.81551C8.20236 10.3515 8.08808 10.9261 8.08808 11.5063C8.08808 12.0865 8.20236 12.661 8.42439 13.197C8.64643 13.7331 8.97187 14.2201 9.38213 14.6304C9.79239 15.0406 10.2794 15.3661 10.8155 15.5881ZM9.37229 8.37231C10.2035 7.54113 11.3308 7.07418 12.5062 7.07418C13.6817 7.07418 14.809 7.54113 15.6402 8.37231C16.4714 9.20349 16.9383 10.3308 16.9383 11.5063C16.9383 12.6817 16.4714 13.809 15.6402 14.6402C14.809 15.4714 13.6817 15.9383 12.5062 15.9383C11.3308 15.9383 10.2035 15.4714 9.37229 14.6402C8.54111 13.809 8.07416 12.6817 8.07416 11.5063C8.07416 10.3308 8.54111 9.20349 9.37229 8.37231ZM19.434 6.04229C19.434 6.37873 19.3003 6.70139 19.0625 6.93929C18.8246 7.17719 18.5019 7.31084 18.1655 7.31084C17.829 7.31084 17.5064 7.17719 17.2685 6.93929C17.0306 6.70139 16.8969 6.37873 16.8969 6.04229C16.8969 5.70585 17.0306 5.38319 17.2685 5.1453C17.5064 4.9074 17.829 4.77375 18.1655 4.77375C18.5019 4.77375 18.8246 4.9074 19.0625 5.1453C19.3003 5.38319 19.434 5.70585 19.434 6.04229Z" stroke="#ffffff" stroke-linejoin="round"></path> </g></svg>
            </a>
            <a href="https://www.youtube.com/@flut.9755" class="text-white h-5 w-5">
              <svg fill="#ffffff" viewBox="0 -4 32 32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" stroke="#ffffff" stroke-width="0.00032"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M30.722,20.579 C30.137,21.894 28.628,23.085 27.211,23.348 C27.066,23.375 23.603,24.000 16.010,24.000 L15.990,24.000 C8.398,24.000 4.932,23.375 4.788,23.349 C3.371,23.085 1.861,21.894 1.275,20.578 C1.223,20.461 0.001,17.647 0.001,12.000 C0.001,6.353 1.223,3.538 1.275,3.421 C1.861,2.105 3.371,0.915 4.788,0.652 C4.932,0.625 8.398,-0.000 15.990,-0.000 C23.603,-0.000 27.066,0.625 27.210,0.651 C28.628,0.915 30.137,2.105 30.723,3.420 C30.775,3.538 32.000,6.353 32.000,12.000 C32.000,17.647 30.775,20.461 30.722,20.579 ZM28.893,4.230 C28.581,3.529 27.603,2.759 26.845,2.618 C26.813,2.612 23.386,2.000 16.010,2.000 C8.615,2.000 5.185,2.612 5.152,2.618 C4.394,2.759 3.417,3.529 3.104,4.234 C3.094,4.255 2.002,6.829 2.002,12.000 C2.002,17.170 3.094,19.744 3.106,19.770 C3.417,20.471 4.394,21.241 5.153,21.382 C5.185,21.388 8.615,22.000 15.990,22.000 L16.010,22.000 C23.386,22.000 26.813,21.388 26.846,21.382 C27.604,21.241 28.581,20.471 28.894,19.766 C28.904,19.744 29.998,17.170 29.998,12.000 C29.998,6.830 28.904,4.255 28.893,4.230 ZM13.541,17.846 C13.379,17.949 13.193,18.000 13.008,18.000 C12.842,18.000 12.676,17.959 12.525,17.875 C12.206,17.699 12.008,17.364 12.008,17.000 L12.008,7.000 C12.008,6.637 12.204,6.303 12.521,6.127 C12.838,5.950 13.227,5.958 13.534,6.149 L21.553,11.105 C21.846,11.286 22.026,11.606 22.027,11.951 C22.028,12.296 21.852,12.618 21.560,12.801 L13.541,17.846 ZM14.009,8.794 L14.009,15.189 L19.137,11.963 L14.009,8.794 Z"></path> </g></svg>
            </a>
          </div>
          <p>Copyright © {{ current_year }} | {{ site_configuration.landing.title }}</p>
          <p>Theme created with ❤️ by <a href="https://geertroks.com" class="underline">Geert Roks</a></p>
        </div>
      </footer>

    </div>
    <ProjectModal :project="posts.find(project => { return project.slug === showProjectModal })" :wordpress_host="wordpress_api_url" />
  </main>
</template>
