<template>
    <footer class="bg-gray-100 py-4">
      <div class="container mx-auto flex flex-col md:flex-row justify-between items-center px-4">
        <p class="text-sm text-gray-500">
          © 2024 Your Company, Inc. All rights reserved.
        </p>
        <div class="flex space-x-4 mt-2 md:mt-0">
          <a
            href="#"
            aria-label="Facebook"
            class="text-gray-500 hover:text-gray-700"
          >
            <i class="fab fa-facebook"></i>
          </a>
          <a
            href="#"
            aria-label="Instagram"
            class="text-gray-500 hover:text-gray-700"
          >
            <i class="fab fa-instagram"></i>
          </a>
          
          <a
            href="#"
            aria-label="GitHub"
            class="text-gray-500 hover:text-gray-700"
          >
            <i class="fab fa-github"></i>
          </a>
          
        </div>
      </div>
    </footer>
  </template>
  
  <script>
  export default {
    name: "Footer",
  };
  </script>
  
  <style scoped>
  /* FontAwesome ikonokhoz szükséges stílusok */
  @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
  </style>
  