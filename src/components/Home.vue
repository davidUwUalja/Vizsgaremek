<template>
    <div>
      <Navbar @toggle-filter="toggleFilter" />
      <div class="flex">
        <!-- Szűrő -->
        <FilterSidebar :visible="filterVisible" />
        
        <!-- Termékek -->
        <div class="grid grid-cols-3 gap-4 p-4">
          <ProductCard v-for="i in 9" :key="i" />
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Navbar from './Navbar.vue';
  import FilterSidebar from './FilterPanel.vue';
  import ProductCard from './ProductList.vue';
  
  export default {
    components: { Navbar, FilterSidebar, ProductCard },
    data() {
      return {
        filterVisible: false,
      };
    },
    methods: {
      toggleFilter() {
        this.filterVisible = !this.filterVisible;
      },
    },
  };
  </script>
  
  <style scoped>
  </style>
  