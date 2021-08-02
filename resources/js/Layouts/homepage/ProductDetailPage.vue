<template>
  <div>
  <!-- Header -->
  <div id="header">
  <div class="logo-container">
  <img class="logo-top md-elevation-20" src="/images/logo.png"></img>
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

    <md-toolbar class="md-primary mobile-menu">
        <md-button class="md-icon-button" @click="showMobileNavigation = true">
          <md-icon>menu</md-icon>
        </md-button>
        <!-- <span class="md-title">Felisa</span> -->
      </md-toolbar>

      <md-drawer :md-active.sync="showMobileNavigation" md-swipeable>
        <md-toolbar class="md-transparent" md-elevation="0">
        </md-toolbar>

        <md-list>
          <md-list-item>
            <md-icon>home</md-icon>
            <span class="md-list-item-text" @click="setPage('home')">Home</span>
          </md-list-item>

          <md-list-item>
            <md-icon>description</md-icon>
            <span class="md-list-item-text" @click="setPage('home', 'about')">About</span>
          </md-list-item>

          <md-list-item>
            <md-icon>shopping_cart</md-icon>
            <span class="md-list-item-text" @click="setPage('shop')" :href="'#'">Shop</span>
          </md-list-item>

          <md-list-item>
            <md-icon>contact_page</md-icon>
            <span class="md-list-item-text" @click="setPage('home', 'contact')">Contact</span>
          </md-list-item>

          <md-list-item>
            <md-icon>shopping_basket</md-icon>
            <span class="md-list-item-text" :href="'#header'" @click="setPage('cart')">Winkelwagen</span>
          </md-list-item>
        </md-list>
      </md-drawer>

    <div class="header-container-small">

      <!-- begin header foto -->
      <img src="/product_fotos/25-3840x2160.jpg"></img>
      <!-- einde header foto -->

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

      <div class="md-layout-item md-size-35 md-xsmall-size-100" v-if="this.aantalFotos == 1">
        <img :src="this.selectedItem.foto" alt="product.naam">
      </div>

  <div id="case-example-cover" class="md-layout-item md-size-35 md-xsmall-size-100" v-else-if="this.aantalFotos > 1 && this.displayingPicture == 1">
    <div id="nav-container">
          <span id="case-left" class="material-icons table-icon" @click='pictureDown()'>arrow_right_alt</span>
          <span id="case-right" class="material-icons table-icon" @click='pictureUp()'>arrow_right_alt</span>
        <img :src="this.selectedItem.foto" />
    </div>
</div>
<div id="case-example-cover" class="md-layout-item md-size-35 md-xsmall-size-100" v-else-if="this.aantalFotos > 1 && this.displayingPicture == 2">
  <div id="nav-container">
        <span id="case-left" class="material-icons table-icon" @click='pictureDown()'>arrow_right_alt</span>
        <span id="case-right" class="material-icons table-icon" @click='pictureUp()'>arrow_right_alt</span>
      <img :src="this.selectedItem.foto2" />
  </div>
</div>
<div id="case-example-cover" class="md-layout-item md-size-35 md-xsmall-size-100" v-else>
  <div id="nav-container">
        <span id="case-left" class="material-icons table-icon" @click='pictureDown()'>arrow_right_alt</span>
        <span id="case-right" class="material-icons table-icon" @click='pictureUp()'>arrow_right_alt</span>
      <img :src="this.selectedItem.foto3" />
  </div>
</div>

      <div class="md-layout-item md-size-62 margin-left-2vw md-xsmall-size-100">
        <p>{{this.selectedItem.beschrijving}}</p>

        <div class="md-layout md-gutter margin-top-2">
          <div class="md-layout-item md-size-30 md-xsmall-size-40 margin-left-2vw" v-if="this.opties.length > 0">

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

       <div class="md-layout-item md-size-45 md-xsmall-size-20" v-if="this.opties.length > 0">
       </div>

       <div class="md-layout-item md-size-20 md-xsmall-size-30" v-if="this.opties.length > 0">


         <p>Prijs per stuk: €{{this.selectedItem.prijs}}</p>
         <p>BTW (21%): €{{taxPrice}}</p>


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

        <div class="ta-center md-xsmall-hide">
        <md-button class="md-primary md-raised color-white fill-available buy-button" @click="addToCart()">Kopen</md-button>
       </div>
       </div>

       <div class="md-layout-item md-size-30 md-xsmall-size-100" v-else>


         <p>Prijs per stuk: €{{this.selectedItem.prijs}}</p>
         <p>BTW (21%): €{{taxPrice}}</p>


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

        <div class="ta-center md-xsmall-hide">
        <md-button class="md-primary md-raised color-white fill-available buy-button" @click="addToCart()">Kopen</md-button>
       </div>
       </div>

       <div class="ta-center mobile-buy-button md-size-100">
       <md-button class="md-primary md-raised color-white fill-available buy-button" @click="addToCart()">Kopen</md-button>
       </div>

     </div>

     <div>

    <md-dialog-confirm
      :md-active.sync="dialogActive"
      md-title="Product is aan uw winkelwagen toegevoegd."
      md-content="Wilt u door gaan met shoppen of wilt u naar de winkelwagen om af te rekenen?"
      md-confirm-text="Afrekenen"
      md-cancel-text="Verder shoppen"
      @md-cancel="onDialogCancel"
      @md-confirm="onDialogConfirm" />
  </div>

      </div>
    </div>


<h2 class="product-page-titel">Gerelateerde producten</h2>
      <div class="md-layout md-gutter margin-top-2 related-product-gutter margin-bottom-2vh">
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
    <label>Naam*</label>
    <md-input v-model="name"></md-input>
  </md-field>

  <md-field>
    <label>E-mail*</label>
    <md-input v-model="email"></md-input>
  </md-field>

  <md-field>
    <label>Telefoon nummer</label>
    <md-input v-model="number"></md-input>
  </md-field>

  <md-field>
    <label>Bericht*</label>
    <md-input v-model="message"></md-input>
  </md-field>

  <md-checkbox v-model="checkbox" class="form-akkoord-tekst">Ik ga ermee akkoord dat mijn data wordt opgeslagen in overeenkomst met onze privacy policy.</md-checkbox>

  <md-button class="md-raised md-primary margin-top-2vh margin-bottom-2vh" @click="sendForm()">Verstuur</md-button>



  </div>
  </div>

  <md-dialog-alert
    :md-active.sync="contactAlert"
    md-title="Let op!"
    md-content="U moet akkoord gaan met het opslaan van uw data om dit formulier te kunnen gebruiken." />

    <md-dialog-alert
      :md-active.sync="contactCompleteAlert"
      md-title="Bedankt voor uw bericht!"
      md-content="Wij zullen zo snel mogelijk reageren." />

  <div class="md-layout-item instagram-box">
    <div class="display-flex">
      <h2 class="section-titel" style="margin-left: 0!important; margin-right: 1vw;">Instagram.</h2>
      <md-button class="md-raised md-primary margin-top-5vh-mobile normal-view-profile-button" @click="goToInsta()">Bekijk profiel</md-button>
    </div>

    <div class="md-layout md-gutter margin-bottom-2vh">
  <div class="md-layout-item md-size-33 margin-bottom-2vh">
    <!-- Instagram foto 1 -->
    <img src="Insta/foto1.jpg" alt="">
    <!-- Einde instagram foto 1 -->
  </div>
  <div class="md-layout-item md-size-33 margin-bottom-2vh">
    <!-- Instagram foto 2 -->
    <img src="Insta/foto2.jpg" alt="">
    <!-- Einde instagram foto 2 -->
  </div>
  <div class="md-layout-item md-size-33 margin-bottom-2vh">
    <!-- Instagram foto 3 -->
    <img src="Insta/foto3.jpg" alt="">
    <!-- Einde instagram foto 3 -->
  </div>
  <div class="md-layout-item md-size-33 margin-bottom-2vh">
    <!-- Instagram foto 4 -->
    <img src="Insta/foto4.jpg" alt="">
    <!-- Einde instagram foto 4 -->
  </div>
  <div class="md-layout-item md-size-33 margin-bottom-2vh">
    <!-- Instagram foto 5 -->
    <img src="Insta/foto5.jpg" alt="">
    <!-- Einde instagram foto 5 -->
  </div>
  <div class="md-layout-item md-size-33 margin-bottom-2vh">
    <!-- Instagram foto 6 -->
    <img src="Insta/foto6.jpg" alt="">
    <!-- Einde instagram foto 6 -->
  </div>
  <md-button class="md-raised md-primary margin-top-5vh-mobile mobile-view-profile-button" @click="goToInsta()">Bekijk profiel</md-button>
  </div>
</div>
</div>
</div>

<md-dialog-confirm
  :md-active.sync="showCookieConsentConfirm"
  md-title="Gebruik van cookies toestaan?"
  md-content="Let op! Cookies worden eigenlijk alleen gebruikt om de winkelwagen op te slaan. Als dit niet wordt toegelaten en de website opnieuw wordt opgestart is uw winkelwagen weer leeg."
  md-confirm-text="Toestaan"
  md-cancel-text="Weigeren"
  @md-cancel="onCookieDecline()"
  @md-confirm="onCookieAllow()" />

<div id="footer">
  <p class="footer-text margin-left-auto">Copyright 2021 Felisa,</p>
  <p class="footer-text link" @click='downloadAlgemeneVoorwaarden()'>Algemene voorwaarden,</p>
  <p class="footer-text link" @click='downloadPrivacyPolicy()'>Privacy policy,</p>
  <p class="footer-text margin-right-auto link" @click='downloadTerugstuurFormulier()'>Terugstuur formulier.</p>
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
            showCookieConsentConfirm: false,
            showMobileNavigation: false,
            contactAlert: false,
            contactCompleteAlert: false,
            categorieNaam: '',
            subCategorieNaam: '',
            opties: [],
            selectedKeuzes: [undefined, undefined, undefined],
            relatedProducts: [],
            aantalVanProduct: 1,
            dialogActive: false,
            aantalFotos: 0,
            displayingPicture: 1,
          };
        },

        computed: {

          taxPrice(){
            var taxPrice = this.selectedItem.prijs.replace(',', '.')*0.21;
            return String(taxPrice.toFixed(2)).replace('.', ',');
          },

        },

        watch:{
        },

        mounted(){
          window.scrollTo(0, 0);

          axios
          .post('/get-categorie-name', {'id': this.selectedItem.categorie})
          .then(response => this.categorieNaam = response.data)

          axios
          .post('/get-categorie-name', {'id': this.selectedItem.subCategorie})
          .then(response => this.subCategorieNaam = response.data)

          if (this.selectedItem.opties != null) {
            if (Array.isArray(this.selectedItem.opties)) {
            var str = this.selectedItem.opties.join();
          }else {
            var str = this.selectedItem.opties;
          }



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

          }

          axios
          .post('/get-related-products', {'id': this.selectedItem.id, 'categorie': this.selectedItem.categorie, 'subCategorie': this.selectedItem.subCategorie})
          .then(response => this.relatedProducts = response.data);

          if (this.selectedItem.foto != '/product_fotos/') {
            this.aantalFotos = this.aantalFotos + 1;
          }
          if (this.selectedItem.foto2 != '/product_fotos/') {
            this.aantalFotos = this.aantalFotos + 1;
          }
          if (this.selectedItem.foto3 != '/product_fotos/') {
            this.aantalFotos = this.aantalFotos + 1;
          }

        },

        methods:{
          setPage(page, item, item2, item3, item4){
            this.$emit('setPage', page, item, item2, item3, item4);
          },

          jump(h){
            this.showMobileNavigation = false;
            var top = document.getElementById(h).offsetTop; //Getting Y of target element
            window.scrollTo(0, top);                        //Go there directly or some transition
          },

          goToInsta(){
            window.open('https://www.instagram.com/felisa.handmade/?hl=en', '_blank');
          },

          pictureUp(){
            if (this.displayingPicture < this.aantalFotos) {
              this.displayingPicture = this.displayingPicture + 1;
            }else {
              this.displayingPicture = 1;
            }
          },

          pictureDown(){
            if (this.displayingPicture > 1) {
              this.displayingPicture = this.displayingPicture - 1;
            }else {
              this.displayingPicture = this.aantalFotos;
            }
          },

          downloadTerugstuurFormulier(){
            axios({
              url: '/download-return-form', //your url
              method: 'POST',
              responseType: 'blob', // important
            }).then((response) => {
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', 'Terugstuur-formulier.pdf'); //or any other extension
              document.body.appendChild(link);
              link.click();
            });
          },

          downloadAlgemeneVoorwaarden(){
            axios({
              url: '/download-algemene-voorwaarden', //your url
              method: 'POST',
              responseType: 'blob', // important
            }).then((response) => {
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', 'Algemene-voorwaarden.pdf'); //or any other extension
              document.body.appendChild(link);
              link.click();
            });
          },

          downloadPrivacyPolicy(){
            axios({
              url: '/download-privacy-policy', //your url
              method: 'POST',
              responseType: 'blob', // important
            }).then((response) => {
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', 'Privacy-policy.pdf'); //or any other extension
              document.body.appendChild(link);
              link.click();
            });
          },

          sendForm(){
            if (this.checkbox == false) {
              this.contactAlert = true;
            }else {
              axios
              .post('send-contact-form', {'name': this.name, 'email': this.email, 'phonenumber': this.number, 'message': this.message});

              this.contactCompleteAlert = true;
              this.name = '';
              this.email = '';
              this.number = '';
              this.message = '';
              this.checkbox = false;
            }
          },

          onDialogConfirm(){
            this.$emit('setPage', 'cart');
          },

          onDialogCancel(){
            this.dialogActive = false;
          },

          addToCart(){
            this.dialogActive = true;
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

            if (this.selectedItem.opties != null) {

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

            }

            axios
            .post('/get-related-products', {'id': this.selectedItem.id, 'categorie': this.selectedItem.categorie, 'subCategorie': this.selectedItem.subCategorie})
            .then(response => this.relatedProducts = response.data)
          }
        },
    }
</script>
