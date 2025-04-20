<template>
  <BaseLayout>
    <div class="min-h-screen bg-amber-50 p-6 flex flex-col items-center">
    <div class="max-w-2xl w-full bg-yellow-50 p-8 shadow-xl rounded-sm border-4 border-double border-yellow-700">
      <h1 class="text-4xl font-serif font-bold text-center text-yellow-900 mb-8 tracking-wide">
        {{ $t('contactUs') }}
      </h1>

      <form @submit.prevent class="space-y-6">
        <div>
          <label for="name" class="block text-yellow-800 font-serif font-semibold mb-1">
            {{ $t('name') }}
          </label>
          <input
            id="name"
            type="text"
            :placeholder="$t('namePlaceholder')"
            class="w-full border-2 border-yellow-700 rounded-sm px-4 py-3 shadow-md bg-yellow-50 text-yellow-900 placeholder-yellow-600 focus:border-yellow-900 focus:outline-none focus:ring-1 focus:ring-yellow-900 transition-all duration-300"
          />
        </div>

        <div>
          <label for="email" class="block text-yellow-800 font-serif font-semibold mb-1">
            {{ $t('email') }}
          </label>
          <input
            id="email"
            type="email"
            :placeholder="$t('emailPlaceholder')"
            class="w-full border-2 border-yellow-700 rounded-sm px-4 py-3 shadow-md bg-yellow-50 text-yellow-900 placeholder-yellow-600 focus:border-yellow-900 focus:outline-none focus:ring-1 focus:ring-yellow-900 transition-all duration-300"
          />
        </div>

        <div>
          <label for="message" class="block text-yellow-800 font-serif font-semibold mb-1">
            {{ $t('message') }}
          </label>
          <textarea
            id="message"
            rows="4"
            :placeholder="$t('messagePlaceholder')"
            class="w-full border-2 border-yellow-700 rounded-sm px-4 py-3 shadow-md bg-yellow-50 text-yellow-900 placeholder-yellow-600 focus:border-yellow-900 focus:outline-none focus:ring-1 focus:ring-yellow-900 transition-all duration-300"
          ></textarea>
        </div>

        <button
          type="submit"
          class="bg-yellow-800 text-yellow-50 px-6 py-3 rounded-sm hover:bg-yellow-900 w-full font-serif font-semibold shadow-lg border-2 border-yellow-700 transition-all duration-300 hover:shadow-xl"
        >
          {{ $t('submitButton') }}
        </button>
      </form>
    </div>
  </div>

  </BaseLayout>
</template>

<script>
import BaseLayout from '@layouts/BaseLayout.vue';

export default {
  name: 'Contact',
  components:{BaseLayout},
};
</script>

<route lang="json">
  {
      "name": "contact",
      "meta":{
          "title": "Kapcsolat"
      }
  }
</route>
