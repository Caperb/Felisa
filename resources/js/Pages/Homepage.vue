<template>
  <!-- Header -->
  <div id="header">
  <div class="logo-container">
  <img class="logo-top" src="/images/logo.jpeg"></img>
  </div>

  <md-toolbar :md-elevation="0" class="md-transparent home-menu md-toolbar-offset">
     <div class="md-toolbar-section-start">
      <md-button class="top-menu-button">Home</md-button>
      <md-button class="top-menu-button">About</md-button>
    </div>

    <div class="md-toolbar-section-end">
     <md-button class="top-menu-button">Shop</md-button>
     <md-button class="top-menu-button">Contact</md-button>
     <md-button><img class="" src="/images/shopping_cart-24px.svg"></img></md-button>
   </div>

    </md-toolbar>

  <div class="header-container">
  <p>Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor sit amet consectetur</p>
  <img src="https://picsum.photos/1920/900"></img>
  </div>

  <!-- Products -->
  <div id="products">
    <h2 class="section-titel">Products</h2>
  </div>

</div>
</template>

<script>

    export default {
        components: {
        },
    }
</script>
