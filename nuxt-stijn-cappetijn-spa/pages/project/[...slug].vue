<template>
  <div class="text-black">
    <header class="flex flex-row justify-between">
      <NuxtLink to="/">x</NuxtLink>
    </header>
    {{ $route.params.slug[0] }}
  </div>
</template>
