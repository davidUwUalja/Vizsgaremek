<template>
 <BaseLayout>
 <div class="flex justify-center items-center min-h-screen bg-amber-50 p-6">
    <div class="bg-yellow-50 p-10 rounded-sm shadow-xl border-4 border-double border-yellow-700 max-w-4xl w-full">

      <h1 class="text-5xl font-serif font-bold text-center text-yellow-900 mb-8 tracking-wide">
        {{$t('welcome')}}
      </h1>

      <p class="text-lg text-yellow-800 font-serif text-center mb-10">
        {{$t('browseProducts')}}
      </p>

      <div class="flex flex-col md:flex-row justify-center gap-6 mb-12">

        <router-link
          to="/productList"
          class="px-8 py-4 bg-yellow-700 text-yellow-50 font-serif font-semibold rounded-sm border-2 border-yellow-800 shadow-md
                 hover:bg-yellow-900 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center"
        >
        {{$t('buying')}}
        </router-link>

        <router-link
          to="/blogpage"
          class="px-8 py-4 bg-transparent text-yellow-800 font-serif font-semibold rounded-sm border-2 border-yellow-800 shadow-md
                 hover:bg-yellow-800 hover:text-yellow-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center"
        >
        {{$t('blog')}}
        </router-link>

      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
        <div class="p-6 bg-amber-100 rounded-sm border-2 border-yellow-700 shadow-md hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-xl font-serif font-semibold text-yellow-900 mb-2">{{$t('handmade')}}</h3>
          <p class="text-yellow-800">{{$t('handmadeText')}}</p>
        </div>

        <div class="p-6 bg-amber-100 rounded-sm border-2 border-yellow-700 shadow-md hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-xl font-serif font-semibold text-yellow-900 mb-2">{{$t('natural')}}</h3>
          <p class="text-yellow-800">{{$t('naturalText')}}</p>
        </div>

        <div class="p-6 bg-amber-100 rounded-sm border-2 border-yellow-700 shadow-md hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-xl font-serif font-semibold text-yellow-900 mb-2">{{$t('order')}}</h3>
          <p class="text-yellow-800">{{$t('orderText')}}</p>
        </div>
      </div>

    </div>
  </div>
 </BaseLayout>
</template>

<script>
import BaseLayout from '@layouts/BaseLayout.vue';


export default {
  name: 'Landing',
  components:{BaseLayout},
};
</script>
