<template>
  <div class="min-h-screen bg-gradient-to-b from-blue-100 to-blue-200 flex flex-col items-center justify-center">
    <h1 class="text-5xl font-extrabold text-blue-700 mb-6 text-center">{{ $t('welcome') }}</h1>
    <p class="text-lg text-gray-600 mb-8 text-center max-w-2xl">
      Fedezd fel a termékeinket, és vedd fel velünk a kapcsolatot egyedi ajánlatokért! Böngéssz és élvezd a lehetőségeket, amiket kínálunk.
    </p>
    <router-link to="/products">
      <button class="px-8 py-4 bg-blue-600 text-white text-lg font-medium rounded-lg shadow-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 transition ease-in-out duration-300">
        Termékek megtekintése
      </button>
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'Home',
};
</script>