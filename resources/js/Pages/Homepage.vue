<template>
  <div>
  <!-- Header -->
  <div id="header">
  <div class="logo-container">
  <img class="logo-top md-elevation-20" src="/images/logo.jpeg"></img>
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
</div>
  <!-- Products -->
  <div id="products">
    <h2 class="section-titel">Products.</h2>

    <div class="product-container">
      <div class="md-layout md-gutter">
        <div class="md-layout-item product-block">
        <img src="/images/product1.png"></img>
        <p>Categorie Titel</p>
        </div>

        <div class="md-layout-item product-block">
        <img src="/images/product1.png"></img>
        <p>Categorie Titel</p>
        </div>

        <div class="md-layout-item product-block">
        <img src="/images/product1.png"></img>
        <p>Categorie Titel</p>
        </div>

        <div class="md-layout-item product-block">
        <img src="/images/product1.png"></img>
        <p>Categorie Titel</p>
        </div>
      </div>

      <div class="md-layout md-gutter margin-top-2vh">
        <div class="md-layout-item product-block">
        <img src="/images/product1.png"></img>
        <p>Categorie Titel</p>
        </div>

        <div class="md-layout-item product-block">
        <img src="/images/product1.png"></img>
        <p>Categorie Titel</p>
        </div>

        <div class="md-layout-item product-block">
        <img src="/images/product1.png"></img>
        <p>Categorie Titel</p>
        </div>

        <div class="md-layout-item product-block">
        <img src="/images/product1.png"></img>
        <p>Categorie Titel</p>
        </div>
      </div>
    </div>

<h2 class="all-products-link">See all available products</h2>
  </div>

  <div id="about">
    <div class="container">
      <img src="/images/about-image.png"></img>
      <div class="about-tekst-blok">
        <h2>About Felisa.</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tincidunt nulla a orci condimentum laoreet. Donec tortor ante, tincidunt quis arcu eu, rutrum blandit dui. Pellentesque ut lectus ex. Donec cursus lacus sed lorem eleifend auctor. Sed ac erat iaculis, fringilla odio id, dictum quam. Sed efficitur congue faucibus. Nunc ut nulla mauris. Donec viverra sapien vitae justo ornare porttitor. Nunc lectus magna, tincidunt eget dapibus sed, eleifend id lorem. Pellentesque malesuada eros quis tellus hendrerit accumsan.</p>
      </div>
    </div>
  </div>

  <!-- Customers -->
  <div id="customers">
    <h2 class="section-titel">Happy customers.</h2>

    <div class="md-layout md-gutter">
    <div class="md-layout-item">
      <img src="/images/review1.png"></img>
    </div>
    <div class="md-layout-item">
      <img src="/images/review1.png"></img>
    </div>
    <div class="md-layout-item">
      <img src="/images/review1.png"></img>
    </div>
    <div class="md-layout-item">
      <img src="/images/review1.png"></img>
    </div>
  </div>


  <h2 class="all-products-link">See all Happy Customers</h2>
  </div>


  <!-- Contact -->
  <div id="contact" class="md-elevation-20">
    <div class="md-layout md-gutter">
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

        data() {
          return {
            name: "",
            email: "",
            number: "",
            message: "",
            checkbox: false,
          };
        },
    }
</script>
