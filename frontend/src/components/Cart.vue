<template>
    <div>
      <Cart :cartItems="cartItems" @remove-item="removeItemFromCart" @update-quantity="updateItemQuantity"/>
    </div>
  </template>
  
  <script>
  
  export default {
    components: { Cart },
    data() {
      return {
        cartItems: [
          { id: 1, name: 'Termék 1', price: 1000, image_url: 'kep1.jpg', quantity: 2 },
          { id: 2, name: 'Termék 2', price: 2000, image_url: 'kep2.jpg', quantity: 1 },
        ],
      };
    },
      methods: {
          removeItemFromCart(item) {
              const index = this.cartItems.findIndex(cartItem => cartItem.id === item.id)
              if(index !== -1) {
                  this.cartItems.splice(index, 1)
              }
          },
          updateItemQuantity(item, change) {
              const index = this.cartItems.findIndex(cartItem => cartItem.id === item.id)
              if(index !== -1) {
                  this.cartItems[index].quantity += change
              }
          }
      }
  };
  </script>