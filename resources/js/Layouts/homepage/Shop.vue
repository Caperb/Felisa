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

  <!-- Shop -->
  <div id="shop">

  <div class="shop-container">
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

  <div class="md-layout md-gutter margin-top-2 shop-grid">

   <div @click="setPage('productDetailPage', product)" class="md-layout-item md-size-25 clickable" v-for="product in this.allProducts"  :key="product">
     <md-card>
     <md-card-media-cover md-solid>
       <md-card-media md-ratio="1:1">
         <img :src="product.foto" :alt="product.naam">
       </md-card-media>
     </md-card-media-cover>
   </md-card>
   <p>{{product.naam}}</p>
   <p>€{{product.prijs}}</p>
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

        props:['selectedCategorieProp', 'selectedSubCategorieProp', 'selectedCategorieNaamProp', 'selectedSubCategorieNaamProp'],

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
          window.scrollTo(0, 0);

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

          jump(h){
            this.showMobileNavigation = false;
            var top = document.getElementById(h).offsetTop; //Getting Y of target element
            window.scrollTo(0, top);                        //Go there directly or some transition
          },

          goToInsta(){
            window.open('https://www.instagram.com/felisa.handmade/?hl=en', '_blank');
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
