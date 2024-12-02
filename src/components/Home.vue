<template>
  <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
    <h1 class="text-4xl font-bold text-blue-500 mb-4">Üdvözlünk a Főoldalon!</h1>
    <p class="text-gray-700 text-lg">
      Böngéssz termékeink között, vagy vedd fel velünk a kapcsolatot!
    </p>
    <router-link to="/products">
      <button class="mt-6 bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">
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
