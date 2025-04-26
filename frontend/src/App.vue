<template>
  <router-view>
  
  </router-view>
  </template>
  
  <script>
  
  import { useProductStore } from '@stores/ProductDatasStore';
  import { useUserStore } from '@stores/UserDatasStore';
  import { mapActions } from 'pinia';

  export default {
    methods: {
      ...mapActions(useProductStore, ['fetchProducts']),
      
    },
    mounted() {
      this.fetchProducts();
    },
  }
  
  </script>