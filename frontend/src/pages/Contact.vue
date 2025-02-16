<template>
  <div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6 text-blue-500">{{ $t('contactUs') }}</h1>
    <form class="bg-white p-6 shadow-lg rounded-md max-w-md mx-auto">
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-semibold">{{ $t('name') }}</label>
        <input
          id="name"
          type="text"
          :placeholder="$t('namePlaceholder')"
          class="w-full border rounded px-3 py-2 mt-1"
        />
      </div>
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-semibold">{{ $t('email') }}</label>
        <input
          id="email"
          type="email"
          :placeholder="$t('emailPlaceholder')"
          class="w-full border rounded px-3 py-2 mt-1"
        />
      </div>
      <div class="mb-4">
        <label for="message" class="block text-gray-700 font-semibold">{{ $t('message') }}</label>
        <textarea
          id="message"
          rows="4"
          :placeholder="$t('messagePlaceholder')"
          class="w-full border rounded px-3 py-2 mt-1"
        ></textarea>
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        {{ $t('submitButton') }}
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'Contact',
};
</script>