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
     <md-button class="home-top-menu-button" @click="setPage('cart')" :href="'#header'"><img class="" src="/images/shopping_cart-24px.svg"></img></md-button>
   </div>

    </md-toolbar>

    <div class="header-container">
    <img src="https://picsum.photos/1920/300"></img>
    </div>
  </div>

  <!-- Shop -->
  <div id="shop">

  <div class="product-container">
    <div class="shop-link-container">
      <p class="clickable" @click="setPage('home')"> Home</p>
      <p class="margin-left-3px"> / </p>
      <p class="clickable margin-left-3px"  @click="setCategorie('', '', '', '')"> Shop </p>
      <p class="margin-left-3px" v-if="this.selectedMainCategorie != ''"> / </p>
      <p class="clickable margin-left-3px" v-if="this.selectedMainCategorie != ''" @click="setCategorie(selectedMainCategorie, selectedMainCategorieNaam, '', '')"> {{this.selectedMainCategorieNaam}} </p>
      <p class="margin-left-3px" v-if="this.selectedSubCategorie != ''"> / </p>
      <p class="clickable margin-left-3px" v-if="this.selectedSubCategorie != ''" @click="setCategorie(selectedMainCategorie, selectedMainCategorieNaam, selectedSubCategorie, selectedSubCategorieNaam)"> {{this.selectedSubCategorieNaam}} </p>
    </div>

    <div class="md-layout md-gutter md-alignment-top-center">

      <div class="md-layout-item md-size-20 clickable ta-center" v-for="(categorie, index) in this.allCategories"  :key="categorie">
         <md-menu :md-active="menuStatus[index].value" md-size="auto" md-align-trigger @click="setCategorie(categorie.id, categorie.naam, '', '')"
         @mouseover="toggleMenu(index)" >
        <md-button md-menu-trigger>{{categorie.naam}}</md-button>

        <md-menu-content v-if="categorie.aantalSubs > 0">
          <md-menu-item @click="setCategorie(categorie.id, categorie.naam, subCategorie.id, subCategorie.naam)" class="clickable" v-for="subCategorie in allSubCategories"  :key="subCategorie"
          v-if="subCategorie.hoofdCategorie == categorie.id">{{subCategorie.naam}}</md-menu-item>
        </md-menu-content>
      </md-menu>
    </div>

   </div>

  <div class="md-layout md-gutter margin-top-2">

   <div @click="setPage('productDetailPage', product)" class="md-layout-item md-size-25 clickable" v-for="product in this.allProducts"  :key="product">
     <md-card>
     <md-card-media-cover md-solid>
       <md-card-media md-ratio="1:1">
         <img :src="product.foto" :alt="product.naam">
       </md-card-media>
     </md-card-media-cover>
   </md-card>
   <p>{{product.naam}}</p>
   <p>{{product.prijs}}</p>
   </div>

 </div>
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

        props:['selectedCategorieProp', 'selectedSubCategorieProp', 'selectedCategorieNaamProp', 'selectedSubCategorieNaamProp'],

        data() {
          return {
            name: "",
            email: "",
            number: "",
            message: "",
            checkbox: false,
            allCategories: [],
            allSubCategories: [],
            allProducts: [],
            menuStatus: [],
            selectedMainCategorie: '',
            selectedSubCategorie: '',
            selectedMainCategorieNaam: '',
            selectedSubCategorieNaam: '',
          };
        },

        watch:{
          allCategories(){
            this.allCategories.forEach((item, i) => {
            this.menuStatus.push({'value': false});
            });
          },
        },

        mounted(){
          axios
          .post('get-all-categories')
          .then(response => this.allCategories = response.data);

          axios
          .post('get-all-sub-categories')
          .then(response => this.allSubCategories = response.data);

          axios
          .post('get-all-products')
          .then(response => this.allProducts = response.data);

          if (this.selectedCategorieProp != '' && this.selectedCategorieNaamProp != '') {
            this.selectedMainCategorie = this.selectedCategorieProp;
            this.selectedSubCategorie = this.selectedSubCategorieProp;
            this.selectedMainCategorieNaam = this.selectedCategorieNaamProp;
            this.selectedSubCategorieNaam = this.selectedSubCategorieNaamProp;
            this.refreshData();
          }
        },

        methods:{
          setPage(page, product){
            this.$emit('setPage', page, product);
          },

          toggleMenu(i){
            this.menuStatus.forEach((item, index) => {
              this.menuStatus[index].value = false
            });

            this.menuStatus[i].value = true;
          },

          setCategorie(mainID, mainName, subID, subName){
            this.selectedMainCategorie = mainID;
            this.selectedMainCategorieNaam = mainName;
            this.selectedSubCategorie = subID;
            this.selectedSubCategorieNaam = subName;

            if (mainID == '' && mainName == '' && subID == '' && subName == '') {
              this.resetSearch();
            }else {
              this.refreshData();
            }

          },

          refreshData(){
            axios
            .post('search-products', {main: this.selectedMainCategorie, sub: this.selectedSubCategorie})
            .then(response => this.allProducts = response.data);
          },

          resetSearch(){
            axios
            .post('get-all-products')
            .then(response => this.allProducts = response.data);
          },
        },
    }
</script>
