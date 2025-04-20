<template>
  <router-view>
  
  </router-view>
  </template>
  
  <script>
  
  import { useProductStore } from '@stores/ProductDatasStore';
  import { useUserStore } from '@stores/UserDatasStore';
  
  export default {
    async mounted(){
      await useProductStore().fetchProducts();
    }
  }
  
  </script>