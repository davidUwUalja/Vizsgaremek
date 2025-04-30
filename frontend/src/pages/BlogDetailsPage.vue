<template>
    <BaseLayout>
      <div class="min-h-screen bg-amber-50 p-6 flex flex-col items-center">
        <div class="max-w-5xl w-full bg-yellow-50 p-8 shadow-xl rounded-sm border-4 border-double border-yellow-700">
          <h1 class="text-4xl font-serif font-bold text-center text-yellow-900 mb-2 tracking-wide">
            {{ $t('kazahCrafts') }}
          </h1>
          <p class="text-center text-yellow-700 text-sm font-serif mb-8">
            {{ $t('publishedOn')   }}: {{ $t('blogDate') }}
          </p>
          <div class="space-y-6">
            <img 
              src="../kepek/blogpage1.jpg" 
              alt="Kazah kézműves hagyományok" 
              class="rounded-sm shadow-md w-full hover:scale-105 transition-transform duration-300"
            />
            <p class="text-yellow-900 leading-relaxed">
              {{$t('blogContent')}}
            </p>
            <p class="text-yellow-900 leading-relaxed">
              {{$t('blogContent2')}}
            </p>
            <img 
              src="../kepek/blogpage2.jpg" 
              alt="Kazah kézműves termékek" 
              class="rounded-sm shadow-md w-full hover:scale-105 transition-transform duration-300"
            />
            <p class="text-yellow-900 leading-relaxed">
              {{$t('blogContent3')}}
            </p>
            <p class="text-yellow-900 leading-relaxed">
              {{$t('blogContent4')}}
            </p>
            <p class="text-yellow-900 leading-relaxed">
              {{$t('blogContent5')}}
            </p>
          </div>
          <div class="mt-12 text-center">
            <RouterLink 
              to="/blogPage" 
              class="px-6 py-3 bg-yellow-700 text-yellow-50 font-serif rounded-sm hover:bg-yellow-900 transition-colors duration-300 border border-yellow-800 shadow-md"
            >
              {{ $t('backToBlog') }}
            </RouterLink>
          </div>
        </div>
      </div>
    </BaseLayout>
  </template>
  
  <script>
  import BaseLayout from '@layouts/BaseLayout.vue';
  
  export default {
    name: 'BlogDetailsPage',
    components: { BaseLayout },
  };
  </script>
  
  <route lang="json">{
      "name": "BlogDetailsPage",
      "meta": {
          "title": "Kazah Kézműves Hagyományok"
      }
  }
  </route>
  