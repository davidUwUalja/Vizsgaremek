<template>
  <BaseLayout>
    <div class="min-h-screen bg-amber-50 p-6 flex flex-col items-center">
      <div v-if="showDetails" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <BlogDetails @close="showDetails = false" />
      </div>
      <div class="max-w-5xl w-full bg-yellow-50 p-8 shadow-xl rounded-sm border-4 border-double border-yellow-700">
        <h1 class="text-5xl font-serif font-bold text-center text-yellow-900 mb-8 tracking-wide">
          {{ $t('WebshopBlog') }}
        </h1>

        <div class="space-y-10">
          <div class="bg-amber-50 p-6 rounded-sm shadow-lg flex flex-col md:flex-row-reverse items-center border-2 border-yellow-800 hover:shadow-2xl hover:border-yellow-900 transition-all duration-300">
            <img 
              src="../kepek/blogpage1.jpg" 
              alt="Kazah kézműves hagyományok" 
              class="rounded-sm shadow-md md:w-1/2 mb-4 md:mb-0 md:ml-6 hover:scale-105 transition-transform duration-300" 
            />
            <div class="md:w-2/3">
              <h2 class="text-3xl font-serif font-semibold text-yellow-800 border-b-2 border-yellow-700 pb-2 mb-4">
                {{ $t('kazahCrafts') }}
              </h2>
              <p class="text-yellow-900 mt-2 leading-relaxed">
                {{$t('bekezdes1')}}
              </p>
              <p class="text-yellow-900 mt-2 leading-relaxed">
                {{$t('bekezdes2')}}
              </p>
             
              <a 
                href="/BlogDetailsPage" 
                class="inline-block mt-4 px-6 py-2 bg-yellow-700 text-yellow-50 font-serif hover:bg-yellow-900 transition-colors duration-300 border border-yellow-800 shadow-md rounded-sm"
              >
                {{ $t('readMore') }}
              </a>
               
            </div>
          </div>

          <div class="bg-amber-50 p-6 rounded-sm shadow-lg flex flex-col md:flex-row items-center border-2 border-yellow-800 hover:shadow-2xl hover:border-yellow-900 transition-all duration-300">
            <img 
              src="../kepek/blogpage2.jpg" 
              alt="A legújabb termékeink" 
              class="rounded-sm shadow-md md:w-1/2 mb-4 md:mb-0 md:mr-6 hover:scale-105 transition-transform duration-300" 
            />
            <div class="md:w-2/3">
              <h2 class="text-3xl font-serif font-semibold text-yellow-800 border-b-2 border-yellow-700 pb-2 mb-4">
                {{ $t('latestProducts') }}
              </h2>
              
              <p class="text-yellow-900 mt-2 leading-relaxed">
                {{$t('bekezdes3')}}            </p>
              <p class="text-yellow-900 mt-2 leading-relaxed">
                {{$t('bekezdes4')}}            </p>
              <a 
                href="/productList" 
                class="inline-block mt-4 px-6 py-2 bg-yellow-700 text-yellow-50 font-serif hover:bg-yellow-900 transition-colors duration-300 border border-yellow-800 shadow-md rounded-sm"
              >
                {{ $t('viewProducts') }}
              </a>
            </div>
          </div>
        </div>

        <!-- <div class="mt-12">
          <h2 class="text-3xl font-serif font-semibold text-yellow-800 mb-4 text-center border-b-2 border-yellow-700 pb-2 mx-auto max-w-lg">
            {{ $t('comments') }}
          </h2>
          <div class="max-w-lg mx-auto bg-amber-50 p-6 rounded-sm shadow-lg h-64 overflow-y-auto border-2 border-yellow-800">
            <div 
              v-for="(comment, index) in comments" 
              :key="index" 
              class="mb-4 p-4 bg-yellow-50 shadow-md rounded-sm border-l-4 border-yellow-800 hover:shadow-lg transition-shadow duration-300"
            >
              <p class="text-sm text-yellow-800 font-serif font-semibold border-b border-yellow-700 pb-1">
                {{ comment.name }}
              </p>
              <p class="text-yellow-900 mt-2 italic">
                {{ comment.message }}
              </p>
            </div>
            <p 
              v-if="comments.length === 0" 
              class="text-center text-yellow-800 italic font-serif"
            >
              {{ $t('noComments') }}
            </p>
          </div>
          <form @submit.prevent="submitComment" class="max-w-lg mx-auto mt-6">
            <div class="mb-4">
              <input 
                id="name" 
                type="text" 
                v-model="form.name" 
                :placeholder="$t('namePlaceholder')" 
                class="w-full border-2 border-yellow-700 rounded-sm px-4 py-3 shadow-md bg-yellow-50 text-yellow-900 placeholder-yellow-600 focus:border-yellow-900 focus:outline-none focus:ring-1 focus:ring-yellow-900 transition-all duration-300" 
              />
            </div>
            <div class="mb-4">
              <textarea 
                id="message" 
                rows="3" 
                v-model="form.message" 
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
        Befejezés alatt áll
         -->
      </div>
    </div>
  </BaseLayout>
</template>

<script>
import BaseLayout from '@layouts/BaseLayout.vue';
//import BlogDetails from '@components/BlogDetails.vue';

export default {
  name: 'Blog',
  components: { BaseLayout },
  data() {
    return {
      showDetails: false,
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
<route lang="json">
  {
      "name": "blogpage",
      "meta":{
          "title": "Blog"
      }
  }
</route>
