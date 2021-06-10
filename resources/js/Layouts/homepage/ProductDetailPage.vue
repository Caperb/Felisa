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

  <!-- Product info -->
  <div id="shop">
    <div class="product-container">

      <div class="shop-link-container">
        <p class="clickable" @click="setPage('home')"> Home</p>
        <p class="margin-left-3px"> / </p>
        <p class="clickable margin-left-3px"  @click="setPage('shop')"> Shop </p>
        <p class="margin-left-3px" v-if="this.selectedItem.categorie != ''"> / </p>
        <p class="clickable margin-left-3px" v-if="this.selectedItem.categorie != ''" @click="setPage('shop', selectedItem.categorie, '',
        categorieNaam[0], '')"> {{this.categorieNaam[0]}} </p>
        <p class="margin-left-3px" v-if="this.selectedItem.subCategorie != ''"> / </p>
        <p class="clickable margin-left-3px" v-if="this.selectedItem.subCategorie != ''" @click="setPage('shop', selectedItem.categorie, selectedItem.subCategorie,
        categorieNaam[0], subCategorieNaam[0])"> {{this.subCategorieNaam[0]}} </p>
      </div>

    <h2 class="product-page-titel">{{this.selectedItem.naam}}</h2>
    <div class="md-layout md-gutter margin-top-2">

      <div class="md-layout-item md-size-35">
        <img src="/product_fotos/about-image.png" alt="product.naam">
      </div>

      <div class="md-layout-item md-size-62 margin-left-2vw">
        <p>{{this.selectedItem.beschrijving}}</p>

        <div class="md-layout md-gutter margin-top-2">
          <div class="md-layout-item md-size-30 margin-left-2vw">

          <span v-for="(optie, index) in this.opties"  :key="optie">

            <md-field v-if="optie[0].type == 'meerdereKeuzes'">
             <label for="opties">{{optie[0].naam}}</label>
             <md-select v-model="selectedKeuzes[index]" name="opties" id="opties" multiple>
               <md-option v-for="keuze in optie"  :key="keuze" :value="keuze.value">{{keuze.value}}</md-option>
             </md-select>
           </md-field>

           <md-field v-else-if="optie[0].type == 'keuze'">
            <label for="opties">{{optie[0].naam}}</label>
            <md-select v-model="selectedKeuzes[index]" name="opties" id="opties">
              <md-option v-for="keuze in optie"  :key="keuze" :value="keuze.value">{{keuze.value}}</md-option>
            </md-select>
          </md-field>

           <md-field v-else>
             <label>Tekst</label>
             <md-input
               v-model="selectedKeuzes[index]"
               placeholder="Tekst"
               type="Tekst"
             ></md-input>
           </md-field>

         </span>

       </div>

       <div class="md-layout-item md-size-45">
       </div>

       <div class="md-layout-item md-size-20">


         <p>Prijs per stuk: €{{this.selectedItem.prijs}}</p>


         <md-field>
          <label for="aantal">Aantal</label>
          <md-select v-model="aantalVanProduct" name="aantal" id="aantal">
            <md-option value="1">1</md-option>
            <md-option value="2">2</md-option>
            <md-option value="3">3</md-option>
            <md-option value="4">4</md-option>
            <md-option value="5">5</md-option>
          </md-select>
        </md-field>

        <div class="ta-center">
        <md-button class="md-primary md-raised color-white fill-available buy-button" @click="addToCart()">Kopen</md-button>
       </div>
       </div>


     </div>
      </div>
    </div>


<h2 class="product-page-titel">Related products.</h2>
      <div class="md-layout md-gutter margin-top-2">
        <div class="md-layout-item md-size-25 clickable" @click="setRelatedProduct(product)"
        v-for="product in this.relatedProducts"  :key="product">

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

        props:['selectedItem'],

        data() {
          return {
            name: "",
            email: "",
            number: "",
            message: "",
            checkbox: false,
            categorieNaam: '',
            subCategorieNaam: '',
            opties: [],
            selectedKeuzes: [undefined, undefined, undefined],
            relatedProducts: [],
            aantalVanProduct: 1,
          };
        },

        watch:{
        },

        mounted(){
          axios
          .post('/get-categorie-name', {'id': this.selectedItem.categorie})
          .then(response => this.categorieNaam = response.data)

          axios
          .post('/get-categorie-name', {'id': this.selectedItem.subCategorie})
          .then(response => this.subCategorieNaam = response.data)

          var str = this.selectedItem.opties;
          var res = str.split(",");
          var newArray = [];
          var number = 0;

          res.forEach((item, i) => {
            number = parseInt(item);
            newArray.push(number);
          });

          this.selectedItem.opties = newArray;

          axios
          .post('/get-keuze-opties', {'id': newArray})
          .then(response => this.opties = response.data)

          axios
          .post('/get-related-products', {'id': this.selectedItem.id, 'categorie': this.selectedItem.categorie, 'subCategorie': this.selectedItem.subCategorie})
          .then(response => this.relatedProducts = response.data)

        },

        methods:{
          setPage(page, item, item2, item3, item4){
            this.$emit('setPage', page, item, item2, item3, item4);
          },

          addToCart(){
            this.selectedItem.aantalVanProduct = this.aantalVanProduct;
            this.selectedItem.selectedKeuzes = this.selectedKeuzes;

            var newArray = [];

            this.opties.forEach((item, i) => {
              newArray.push(item[0].naam);
              this.selectedItem.optieNaam = newArray;
            });

            this.$emit('addToCart', this.selectedItem);
          },

          setRelatedProduct(product){
            this.selectedItem = product;
            this.getRelatedProductData();
          },

          getRelatedProductData(){
            axios
            .post('/get-categorie-name', {'id': this.selectedItem.categorie})
            .then(response => this.categorieNaam = response.data)

            axios
            .post('/get-categorie-name', {'id': this.selectedItem.subCategorie})
            .then(response => this.subCategorieNaam = response.data)

            var str = this.selectedItem.opties;
            var res = str.split(",");
            var newArray = [];
            var number = 0;

            res.forEach((item, i) => {
              number = parseInt(item);
              newArray.push(number);
            });

            this.selectedItem.opties = newArray;

            axios
            .post('/get-keuze-opties', {'id': newArray})
            .then(response => this.opties = response.data)

            axios
            .post('/get-related-products', {'id': this.selectedItem.id, 'categorie': this.selectedItem.categorie, 'subCategorie': this.selectedItem.subCategorie})
            .then(response => this.relatedProducts = response.data)
          }
        },
    }
</script>
