<template>
  <div>
  <div class="logo-container">
  <img class="logo-top" src="/images/logo.jpeg"></img>
  </div>

  <md-toolbar :md-elevation="0" class="md-transparent home-menu md-toolbar-offset">
     <div class="md-toolbar-section-start">
      <md-button>Home</md-button>
      <md-button>About</md-button>
    </div>

    <div class="md-toolbar-section-end">
     <md-button>Shop</md-button>
     <md-button>Contact</md-button>
     <md-button><img class="logo-top" src="/images/shopping_cart-24px.svg"></img></md-button>
   </div>

    </md-toolbar>

  <img src="https://picsum.photos/1920/900"></img>
  <div style="height: 25vh;">
  </div>
</div>
</template>

<script>

    export default {
        components: {
        },
    }
</script>
