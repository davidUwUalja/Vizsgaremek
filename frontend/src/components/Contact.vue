<template>
    <div class="min-h-screen bg-gray-100 p-6">
      <h1 class="text-3xl font-bold mb-6 text-blue-500">Kapcsolat</h1>
      <form class="bg-white p-6 shadow-lg rounded-md max-w-md mx-auto">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-semibold">Név</label>
          <input
            id="name"
            type="text"
            placeholder="Add meg a neved"
            class="w-full border rounded px-3 py-2 mt-1"
          />
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-semibold">Email</label>
          <input
            id="email"
            type="email"
            placeholder="Add meg az email címed"
            class="w-full border rounded px-3 py-2 mt-1"
          />
        </div>
        <div class="mb-4">
          <label for="message" class="block text-gray-700 font-semibold">Üzenet</label>
          <textarea
            id="message"
            rows="4"
            placeholder="Írd be az üzeneted"
            class="w-full border rounded px-3 py-2 mt-1"
          ></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Üzenet Küldése
        </button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Contact',
  };
  </script>
  