<template>
    <div class="p-4 bg-white shadow-md rounded-lg max-w-md mx-auto">
      <h2 class="text-xl font-semibold mb-4">Wishlist</h2>
      <ul v-if="wishlist.length" class="space-y-4">
        <li v-for="item in wishlist" :key="item.id" class="flex justify-between items-center border-b pb-2">
          <span>{{ item.name }} - {{ item.price }} Ft</span>
          <div class="space-x-2">
            <button @click="moveToCart(item)" class="bg-blue-500 text-white px-3 py-1 rounded">Add to Cart</button>
            <button @click="removeFromWishlist(item)" class="bg-red-500 text-white px-3 py-1 rounded">Remove</button>
          </div>
        </li>
      </ul>
      <p v-else class="text-gray-500">Your wishlist is empty.</p>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      wishlist: Array,
      cartItems: Array,
    },
    methods: {
      moveToCart(item) {
        this.$emit("add-to-cart", item);
        this.removeFromWishlist(item);
      },
      removeFromWishlist(item) {
        this.$emit("remove-from-wishlist", item);
      },
    },
  };
  </script>