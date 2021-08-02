<template>
  <div>
  <!-- Header -->
  <div id="header">
  <div class="logo-container">
  <img class="logo-top md-elevation-20" src="/images/logo.png"></img>
  </div>

    <div class="header-container-small">

      <!-- begin header foto -->
      <img src="/product_fotos/25-3840x2160.jpg"></img>
      <!-- einde header foto -->

    </div>
  </div>

  <!-- Bedankt pagina -->
  <div id="bedankt">
    <div class="margin-top-5vh input-wrapper ta-center">


    <md-card-header>
    <div class="md-title ta-center">
      Hartelijk bedankt voor uw bestelling!
    </div>
  </md-card-header>

    <md-content class="ta-center margin-top-2vh margin-bottom-5vh">
      Zodra de bestelling verwerkt is door het systeem krijgt u per mail een bevestiging.<br>
      Wij zullen u op de hoogte houden zodra we beginnen met de bestelling met de hand te maken en wanneer hem gaan versturen.<br>
      Als u verder nog vragen heeft horen wij graag van u.
    </md-content>

    <md-button class="md-primary md-raised" @click="goToHome()">Terug naar homepagina</md-button>

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

        props:[],

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
            cart: '',
          };
        },

        computed: {
        },

        watch:{
        },

        mounted(){
          window.scrollTo(0, 0);

          var cookiesAllowed = this.getCookieCheck('cookieAllowed');

          if (cookiesAllowed == '"yes"') {

          var name = 'cart';
          // Get cookie using our custom function
          var firstName = this.getCookieCheck(name);

          if (firstName != null) {
              // Split cookie string and get all individual name=value pairs in an array
              var cookieArr = document.cookie.split(";");
              // Loop through the array elements
              for (var i = 0; i < cookieArr.length; i++) {
                  var cookiePair = cookieArr[i].split("=");
                  /* Removing whitespace at the beginning of the cookie name
                  and compare it with the given string */
                  if (name == cookiePair[0].trim()) {
                      // Decode the cookie value and return
                      var newArray = JSON.parse(decodeURIComponent(cookiePair[1]));

                      var date = new Date();
                      document.cookie = "cart=" + JSON.stringify(newArray) + "; expires=" + date.toUTCString();
                  }
              }
          } else {
              var cookiesAllowed = this.getCookieCheck('cookieAllowed');

              if (cookiesAllowed == '"yes"') {
                var date = new Date();
                document.cookie = "cart=" + JSON.stringify(this.cart) + "; expires=" + date.toUTCString();
              }
          }
        }
        },

        methods:{
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

          goToHome(){
            window.location.replace("http://felisa.verenmanta.com");
          }
        },
    }
</script>
