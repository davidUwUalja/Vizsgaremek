<template>
    <div class="min-h-screen bg-gray-100 p-6 flex flex-col items-center">
      <div class="max-w-5xl w-full bg-white p-8 shadow-lg rounded-md">
        <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Webshop Blog</h1>
        
        <div class="space-y-10">
          <div class="bg-gray-50 p-6 rounded-lg shadow-md flex flex-col md:flex-row-reverse items-center">
            <img src="https://via.placeholder.com/300" alt="Kazah kézműves hagyományok" class="rounded-lg shadow-md md:w-1/3 mb-4 md:mb-0 md:ml-6" />
            <div class="md:w-2/3">
              <h2 class="text-2xl font-semibold text-blue-500">Kazah kézműves hagyományok</h2>
              <p class="text-gray-700 mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id velit vel ex malesuada gravida. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae. Curabitur suscipit justo nec magna aliquet, a vulputate nulla lacinia. Duis hendrerit velit at mauris volutpat, nec volutpat nisi tempus. Integer nec orci vel velit tristique accumsan. Nam dictum euismod ligula, ac volutpat nulla cursus ac.</p>
              <p class="text-gray-700 mt-2">Sed at urna vel libero cursus auctor a id odio. Fusce fermentum, nisl eget dignissim sagittis, lectus odio rhoncus sapien, id fermentum ligula eros ut ex. Etiam non varius felis, ac vulputate arcu. Donec nec urna et nulla vestibulum egestas. Mauris convallis lectus eget elit blandit volutpat.</p>
            </div>
          </div>
          
          <div class="bg-gray-50 p-6 rounded-lg shadow-md flex flex-col md:flex-row-reverse items-center">
            <img src="https://via.placeholder.com/300" alt="A legújabb termékeink" class="rounded-lg shadow-md md:w-1/3 mb-4 md:mb-0 md:ml-6" />
            <div class="md:w-2/3">
              <h2 class="text-2xl font-semibold text-blue-500">A legújabb termékeink</h2>
              <p class="text-gray-700 mt-2">Nulla facilisi. In hac habitasse platea dictumst. Suspendisse potenti. Nam id elit eget justo gravida luctus non eu ex. Cras tincidunt, felis id aliquet hendrerit, turpis sapien tempor erat, vel tempor quam purus ut risus. Aliquam erat volutpat. Integer nec nunc non turpis auctor gravida non at velit.</p>
              <p class="text-gray-700 mt-2">Praesent id nunc eget nunc cursus fringilla. Etiam nec orci sit amet libero vestibulum venenatis. Morbi lobortis velit vel dolor vulputate, a gravida elit malesuada. Phasellus scelerisque ligula nec quam ultricies, id facilisis magna bibendum. Quisque rhoncus justo ut eros sollicitudin, eget gravida sapien ultrices.</p>
            </div>
          </div>
        </div>
        
        <div class="mt-12">
          <h2 class="text-2xl font-semibold text-blue-500 mb-4 text-center">Hozzászólások</h2>
          <div class="max-w-lg mx-auto bg-gray-50 p-4 rounded-lg shadow-md h-64 overflow-y-auto">
            <div v-for="(comment, index) in comments" :key="index" class="mb-3 p-3 bg-white shadow rounded-lg">
              <p class="text-sm text-gray-600 font-semibold">{{ comment.name }}</p>
              <p class="text-gray-800">{{ comment.message }}</p>
            </div>
            <p v-if="comments.length === 0" class="text-center text-gray-500">Nincsenek hozzászólások.</p>
          </div>
          <form @submit.prevent="submitComment" class="max-w-lg mx-auto mt-4">
            <div class="mb-2">
              <input id="name" type="text" v-model="form.name" placeholder="Név" class="w-full border rounded-lg px-4 py-2 shadow-sm" />
            </div>
            <div class="mb-2">
              <textarea id="message" rows="2" v-model="form.message" placeholder="Írd be az üzeneted" class="w-full border rounded-lg px-4 py-2 shadow-sm"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full font-semibold shadow-md">
              Küldés
            </button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Blog',
    data() {
      return {
        form: {
          name: '',
          message: ''
        },
        comments: []
      };
    },
    methods: {
      submitComment() {
        if (this.form.name && this.form.message) {
          this.comments.push({
            name: this.form.name,
            message: this.form.message
          });
          this.form.name = '';
          this.form.message = '';
        }
      }
    }
  };
  </script>
  