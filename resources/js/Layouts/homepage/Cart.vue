<template>
  <div>
  <!-- Header -->
  <div id="header">
  <div class="logo-container">
  <img class="logo-top md-elevation-20" src="/images/logo.jpeg"></img>
  </div>

  <md-toolbar :md-elevation="0" class="md-transparent home-menu md-toolbar-offset home-md-toolbar">
     <div class="md-toolbar-section-start">
      <md-button class="home-top-menu-button" @click="setPage('home')" :href="'#header'">Home</md-button>
      <md-button class="home-top-menu-button" @click="setPage('home')" :href="'#about'">About</md-button>
    </div>

    <div class="md-toolbar-section-end">
     <md-button class="home-top-menu-button" @click="setPage('shop')" :href="'#'">Shop</md-button>
     <md-button class="home-top-menu-button" @click="setPage('home')" :href="'#contact'">Contact</md-button>
     <md-button class="home-top-menu-button" :href="'#header'"><img class="" src="/images/shopping_cart-24px.svg"></img></md-button>
   </div>

    </md-toolbar>

    <div class="header-container">
    <img src="https://picsum.photos/1920/300"></img>
    </div>
  </div>

  <!-- Cart -->
  <div id="cart">
    <div class="cart-container">

      <div class="shop-link-container">
        <p class="clickable" @click="setPage('home')">Home</p>
        <p class="margin-left-3px">/</p>
        <p class="clickable margin-left-3px"  @click="setPage('shop')">Shop</p>
        <p class="margin-left-3px">/</p>
        <p class="clickable margin-left-3px">Cart</p>
      </div>

        <md-table-empty-state v-if="this.cart.length == 0"
          md-label="Geen producten gevonden"
          :md-description="`Geen producten gevonden in de winkelwagen. Voeg eerst een product toe aan je winkelwagen.`"
        >
        </md-table-empty-state>

      <span v-else>

        <div class="md-layout md-gutter">
          <div class="md-layout-item">Foto</div>
          <div class="md-layout-item">Naam</div>
          <div class="md-layout-item">Aanpassingen</div>
          <div class="md-layout-item">Prijs</div>
          <div class="md-layout-item">Aantal</div>
          <div class="md-layout-item">Totaal prijs</div>
          <div class="md-layout-item">Acties</div>
        </div>

  <div class="md-layout md-gutter margin-top-2vh" v-for="(product, index) in this.cart"  :key="product">
    <div class="md-layout-item margin-auto-top-bottom"><img :src="product.foto" :alt="product.naam"></div>
    <div class="md-layout-item margin-auto-top-bottom">{{product.naam}}</div>
    <div class="md-layout-item margin-auto-top-bottom">

      <span v-for="(optie, index) in product.optieNaam"  :key="optie">
      <p v-if="Array.isArray(product.selectedKeuzes[index])">{{optie}}: {{product.selectedKeuzes[index].toString()}}</p>
      <p v-else>{{optie}}: {{product.selectedKeuzes[index]}}</p>
      </span>

    </div>
    <div class="md-layout-item margin-auto-top-bottom">{{product.prijs}}</div>
    <div class="md-layout-item margin-auto-top-bottom">
      <md-field>
       <label for="aantal">Aantal</label>
       <md-select v-model="product.aantalVanProduct" @md-selected='editCart()' name="aantal" id="aantal">
         <md-option value="1">1</md-option>
         <md-option value="2">2</md-option>
         <md-option value="3">3</md-option>
         <md-option value="4">4</md-option>
         <md-option value="5">5</md-option>
       </md-select>
     </md-field>
    </div>
    <div class="md-layout-item margin-auto-top-bottom">{{parseFloat(product.prijs.replace(",", ".")) * product.aantalVanProduct}}</div>
    <div class="md-layout-item margin-auto-top-bottom" @click="deleteProduct(product, index)">X</div>
  </div>

  <div class="cart-totaal-container">
    <div class="md-layout md-gutter">
    <div class="md-layout-item">Subtotal</div>
    <div class="md-layout-item">100,-</div>
  </div>
  <div class="md-layout md-gutter">
  <div class="md-layout-item">Taxes</div>
  <div class="md-layout-item">21,-</div>
</div>
<div class="md-layout md-gutter">
<div class="md-layout-item">Total</div>
<div class="md-layout-item">121,-</div>
</div>
<md-button class="md-raised md-primary" @click="bestelWinkelwagen()">Bestellen</md-button>
  </div>
</span>

    </div>
  </div>

  <!-- Contact -->
  <div id="contact" class="md-elevation-20">
    <div class="md-layout">
    <div class="md-layout-item">
      <h2 class="section-titel">Contact.</h2>

      <div class="form">
      <md-field>
      <label>Name*</label>
      <md-input v-model="name"></md-input>
      <span class="md-helper-text">Name</span>
    </md-field>

    <md-field>
      <label>E-mail*</label>
      <md-input v-model="email"></md-input>
      <span class="md-helper-text">E-mail</span>
    </md-field>

    <md-field>
      <label>Telephone number</label>
      <md-input v-model="number"></md-input>
      <span class="md-helper-text">Telephone number</span>
    </md-field>

    <md-field>
      <label>Message*</label>
      <md-input v-model="message"></md-input>
      <span class="md-helper-text">Message</span>
    </md-field>

    <md-checkbox v-model="checkbox">I approve my data being saved and used in accordance with our privacy policy.</md-checkbox>
    </div>
    </div>
    <div class="md-layout-item">
      <h2 class="section-titel" style="margin-left: 0!important;">Instagram.</h2>
      <img src="/images/instagram.png"></img>
    </div>
  </div>
  </div>

  <div id="footer">
    <p class="footer-text">Copyright 2021 Felisa, Privacy Policy, Terms of Services, Return Policy.</p>
  </div>
</div>
</template>

<script>

    export default {
        components: {
        },

        props:['cartProp'],

        data() {
          return {
            name: "",
            email: "",
            number: "",
            message: "",
            checkbox: false,
            tab: 'Home / Shop / New',
            cart: [],
          };
        },

        mounted(){

    var name = 'cart';

      // Get cookie using our custom function
   var firstName = this.getCookieCheck(name);

   if(firstName != null) {
     // Split cookie string and get all individual name=value pairs in an array
     var cookieArr = document.cookie.split(";");
     // Loop through the array elements
     for(var i = 0; i < cookieArr.length; i++) {
         var cookiePair = cookieArr[i].split("=");
         /* Removing whitespace at the beginning of the cookie name
         and compare it with the given string */
         if(name == cookiePair[0].trim()) {
             // Decode the cookie value and return
         var newArray = JSON.parse(decodeURIComponent(cookiePair[1]));

         this.cart = newArray;
       }
   }
}else {
  this.cart = this.cartProp;
      }
    },

        methods:{
          setPage(page){
            this.$emit('setPage', page);
          },

          bestelWinkelwagen(){
            axios
            .post('/prepare-payment', this.cart)
            .then(response => console.log(response))
          },

          editCart(){
            this.$emit('editCart', this.cart);
          },

          deleteProduct(product, index){
            this.cart.splice(index, 1);
            this.$emit('deleteProduct', index);
          },

          getCookieCheck(name) {
      // Split cookie string and get all individual name=value pairs in an array
      var cookieArr = document.cookie.split(";");

      // Loop through the array elements
      for(var i = 0; i < cookieArr.length; i++) {
          var cookiePair = cookieArr[i].split("=");

          /* Removing whitespace at the beginning of the cookie name
          and compare it with the given string */
          if(name == cookiePair[0].trim()) {
              // Decode the cookie value and return
              return decodeURIComponent(cookiePair[1]);
          }
      }

      // Return null if not found
      return null;
  },
        },
    }
</script>
