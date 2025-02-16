<template>
  <div class="flex justify-center items-center min-h-screen">
    <div class="text-center">
      <h1 class="text-4xl font-bold mb-4 text-gray-800">{{ $t('welcome') }}</h1>
      <p class="text-lg text-gray-600">{{ $t('browseProducts') }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Landing',
};
</script>
