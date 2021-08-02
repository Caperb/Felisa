<template>
  <div>
  <!-- Header -->
  <div id="header">
  <div class="logo-container">
  <img class="logo-top md-elevation-20" src="/images/logo.png"></img>
  </div>

  <md-toolbar :md-elevation="0" class="md-transparent home-menu md-toolbar-offset home-md-toolbar">
     <div class="md-toolbar-section-start">
      <md-button class="home-top-menu-button" :href="'#header'">Home</md-button>
      <md-button class="home-top-menu-button" :href="'#about'">About</md-button>
    </div>

    <div class="md-toolbar-section-end">
     <md-button class="home-top-menu-button" @click="setPage('shop')" :href="'#'">Shop</md-button>
     <md-button class="home-top-menu-button" :href="'#contact'">Contact</md-button>
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
            <span class="md-list-item-text" @click="jump('header')">Home</span>
          </md-list-item>

          <md-list-item>
            <md-icon>description</md-icon>
            <span class="md-list-item-text" @click="jump('about')">About</span>
          </md-list-item>

          <md-list-item>
            <md-icon>shopping_cart</md-icon>
            <span class="md-list-item-text" @click="setPage('shop')" :href="'#'">Shop</span>
          </md-list-item>

          <md-list-item>
            <md-icon>contact_page</md-icon>
            <span class="md-list-item-text" @click="jump('contact')">Contact</span>
          </md-list-item>

          <md-list-item>
            <md-icon>shopping_basket</md-icon>
            <span class="md-list-item-text" :href="'#header'" @click="setPage('cart')">Winkelwagen</span>
          </md-list-item>
        </md-list>
      </md-drawer>

  <div class="header-container">

  <!-- begin header tekst -->
  <p class="md-display-3">Test</p>
  <!-- einde header tekst -->

  <!-- begin header foto -->
  <img src="/product_fotos/25-3840x2160.jpg"></img>
  <!-- einde header foto -->

  </div>
</div>
  <!-- Products -->
  <div id="products">
    <h2 class="section-titel">Producten.</h2>

    <div class="product-container">
      <div class="md-layout md-gutter">

        <div class="md-layout-item md-size-25 clickable" @click="setPage('productDetailPage', homeProduct)"
        v-for="homeProduct in this.homeProducts"  :key="homeProduct">
        <md-card class="margin-bottom-2vh">
        <md-card-media-cover md-solid>
          <md-card-media md-ratio="1:1">
            <img :src="homeProduct.foto" :alt="homeProduct.naam">
          </md-card-media>

          <md-card-area>
            <md-card-header>
              <span class="md-title" style="text-align: center;">{{homeProduct.naam}}</span>
            </md-card-header>

          </md-card-area>
        </md-card-media-cover>
      </md-card>
        </div>

    </div>
  </div>

<h2 class="all-products-link clickable" @click="setPage('shop')">Zie alle producten</h2>
  </div>

  <div id="about">

    <div class="md-layout md-gutter">
    <div id="about-img-container" class="md-layout-item md-size-50">
      <!-- begin about foto -->
      <img src="/product_fotos/content-pictures/about-image-homepage - Copy.png"></img>
      <!-- einde about foto -->
    </div>
    <div class="md-layout-item md-size-50 padding-top-15vh padding-right-10vw">
      <div class="about-tekst-blok">
        <!-- begin about titel -->
        <h2>Over Felisa.Test</h2>
        <!-- einde about titel -->
        <!-- begin about tekst -->
        <p>TestLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tincidunt nulla a orci condimentum laoreet. Donec tortor ante, tincidunt quis arcu eu, rutrum blandit dui. Pellentesque ut lectus ex. Donec cursus lacus sed lorem eleifend auctor. Sed ac erat iaculis, fringilla odio id, dictum quam. Sed efficitur congue faucibus. Nunc ut nulla mauris. Donec viverra sapien vitae justo ornare porttitor. Nunc lectus magna, tincidunt eget dapibus sed, eleifend id lorem. Pellentesque malesuada eros quis tellus hendrerit accumsan.</p>
        <!-- einde about tekst -->
      </div>
  </div>
    </div>
  </div>

  <!-- Customers -->
  <div id="customers">
    <h2 class="section-titel">Blije klanten</h2>

    <div class="md-layout md-gutter" v-if="this.happyCustomers != []">


    <div class="md-layout-item md-size-25">
      <img :src="happyCustomers[1][0].fotoNaam"></img>
    </div>

    <div class="md-layout-item md-size-25">
      <div class="input-wrapper ta-center margin-50-top-bottom">
      <md-card-header>
          <div class="md-title">{{happyCustomers[0][0].naam}}</div>
        </md-card-header>
      <p>{{happyCustomers[0][0].tekst}}</p>
    </div>
    </div>

    <div class="md-layout-item md-size-25">
      <img :src="happyCustomers[1][1].fotoNaam"></img>
    </div>

    <div class="md-layout-item md-size-25">
      <div class="input-wrapper ta-center margin-50-top-bottom">
      <md-card-header>
          <div class="md-title">{{happyCustomers[0][1].naam}}</div>
        </md-card-header>
      <p>{{happyCustomers[0][1].tekst}}</p>
    </div>
    </div>


  </div>


  <h2 class="all-products-link clickable margin-bottom-5vh" @click="setPage('happyCustomers')">Zie alle blije klanten</h2>
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

        props:['selectedHeader'],

        data() {
          return {
            name: "",
            email: "",
            number: "",
            message: "",
            checkbox: false,
            homeProducts: [],
            happyCustomers: [],
            showCookieConsentConfirm: false,
            showMobileNavigation: false,
            contactAlert: false,
            contactCompleteAlert: false,
          };
        },

        mounted() {
            window.scrollTo(0, 0);

            axios
            .post('/get-home-products')
            .then(response => this.homeProducts = response.data);

            axios
            .get('/get-home-happy-customers')
            .then(response => this.happyCustomers = response.data);

            var name = 'cookieAllowed';
            var cookie = this.getCookieCheck(name);
            if (cookie == null) {
              this.showCookieConsentConfirm = true;
            };

            window.addEventListener('load', () => {
              this.jump('about');
            });
        },

        watch:{
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

          onCookieDecline(){
            var date = new Date();
            date.setTime(date.getTime() + (3650 * 24 * 60 * 60 * 1000));
            document.cookie = "cookieAllowed=" + JSON.stringify('no') + "; expires=" + date.toUTCString();
          },

          onCookieAllow(){
            var date = new Date();
            date.setTime(date.getTime() + (3650 * 24 * 60 * 60 * 1000));
            document.cookie = "cookieAllowed=" + JSON.stringify('yes') + "; expires=" + date.toUTCString();
          },

          getCookieCheck(name) {
              // Split cookie string and get all individual name=value pairs in an array
              var cookieArr = document.cookie.split(";");

              // Loop through the array elements
              for (var i = 0; i < cookieArr.length; i++) {
                  var cookiePair = cookieArr[i].split("=");

                  /* Removing whitespace at the beginning of the cookie name
                  and compare it with the given string */
                  if (name == cookiePair[0].trim()) {
                      // Decode the cookie value and return
                      return decodeURIComponent(cookiePair[1]);
                  }
              }

              // Return null if not found
              return null;
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
        },
    }
</script>
