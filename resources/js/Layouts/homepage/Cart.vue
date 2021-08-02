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
     <md-button class="home-top-menu-button" :href="'#header'"><img class="" src="/images/shopping_cart-24px.svg"></img></md-button>
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
            <span class="md-list-item-text" @click="setPage('home', '')">Home</span>
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

  <!-- Cart -->
  <div id="cart" v-if="this.activePage == 'cart'">
    <div class="cart-container">

      <div class="shop-link-container">
        <p class="clickable" @click="setPage('home')">Home</p>
        <p class="margin-left-3px">/</p>
        <p class="clickable margin-left-3px"  @click="setPage('shop')">Shop</p>
        <p class="margin-left-3px">/</p>
        <p class="clickable margin-left-3px">Winkelwagen</p>
      </div>

        <md-table-empty-state v-if="this.cart.length == 0"
          md-label="Geen producten gevonden"
          :md-description="`Geen producten gevonden in de winkelwagen. Voeg eerst een product toe aan je winkelwagen.`"
        >
        </md-table-empty-state>

      <span v-else>

        <div class="md-layout md-gutter cart-gutter">
          <div class="md-layout-item md-size-7"></div>
          <div class="md-layout-item md-size-15">Foto</div>
          <div class="md-layout-item md-size-10">Naam</div>
          <div class="md-layout-item md-size-15">Aanpassingen</div>
          <div class="md-layout-item md-size-10">Prijs</div>
          <div class="md-layout-item md-size-15">Aantal</div>
          <div class="md-layout-item md-size-10">Totaal prijs</div>
          <div class="md-layout-item md-size-10">Acties</div>
          <div class="md-layout-item md-size-7"></div>
        </div>

  <div class="md-layout md-gutter margin-top-2vh cart-gutter break-words" v-for="(product, index) in this.cart"  :key="product">
    <div class="md-layout-item md-size-7"></div>
    <div class="md-layout-item margin-auto-top-bottom md-size-15"><img @click="setPage('productDetailPage', product)" :src="product.foto" :alt="product.naam"></div>
    <div class="md-layout-item margin-auto-top-bottom md-size-10"><p @click="setPage('productDetailPage', product)">{{product.naam}}</p></div>
    <div class="md-layout-item margin-auto-top-bottom md-size-15" v-if="product.opties != null">

      <span v-for="(optie, index) in product.optieNaam"  :key="optie">
      <p v-if="Array.isArray(product.selectedKeuzes[index]) && product.selectedKeuzes[index].length == 0">{{optie}}: Niks gekozen.</p>
      <p v-else-if="Array.isArray(product.selectedKeuzes[index])">{{optie}}: {{product.selectedKeuzes[index].toString()}}</p>
      <p v-else-if="product.selectedKeuzes[index] == null">{{optie}}: Niks gekozen.</p>
      <p v-else>{{optie}}: {{product.selectedKeuzes[index]}}</p>
      </span>

    </div>
    <div class="md-layout-item margin-auto-top-bottom md-size-15" v-else>
      <p>Geen opties</p>
    </div>
    <div class="md-layout-item margin-auto-top-bottom md-size-10">€{{product.prijs}}</div>
    <div class="md-layout-item margin-auto-top-bottom md-size-15" style="padding-right: 4vw;">
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
    <div class="md-layout-item margin-auto-top-bottom md-size-10">€{{priceXaantal(product.prijs, product.aantalVanProduct)}}</div>
    <div class="md-layout-item margin-auto-top-bottom md-size-10" @click="deleteProduct(product, index)">
      <span class="material-icons table-icon">delete</span>
</div>
<div class="md-layout-item md-size-7"></div>
  </div>

  <div class="input-wrapper ta-center">
  <md-button class="md-raised md-primary" @click="activePage = 'verzendInfo'">Bestellen</md-button>
  </div>

  <!-- <div class="cart-totaal-container">
    <div class="md-layout md-gutter">
    <div class="md-layout-item">Sub totaal:</div>
    <div class="md-layout-item">€{{priceTogheter}}</div>
  </div>
  <div class="md-layout md-gutter">
  <div class="md-layout-item">BTW (21%):</div>
  <div class="md-layout-item">€{{taxPrice}}</div>
</div>
<div class="md-layout md-gutter">
<div class="md-layout-item">Verzenden:</div>
<div class="md-layout-item">€{{deliveryCosts}}</div>
</div>
<div class="md-layout md-gutter">
<div class="md-layout-item">Totaal:</div>
<div class="md-layout-item">€{{totalPrice}}</div>
</div>
  </div> -->
</span>

    </div>
  </div>

  <!-- Bestel info -->
  <div id="cart" v-if="this.activePage == 'verzendInfo'">
    <div class="cart-container -">

      <div class="shop-link-container">
        <p class="clickable" @click="setPage('home')">Home</p>
        <p class="margin-left-3px">/</p>
        <p class="clickable margin-left-3px"  @click="setPage('shop')">Shop</p>
        <p class="margin-left-3px">/</p>
        <p class="clickable margin-left-3px">Winkelwagen</p>
      </div>

      <div class="input-wrapper ta-center">

        <md-card-header>
          <div class="md-title">Verzend informatie</div>
        </md-card-header>

  <div class="md-layout md-gutter">
    <div class="md-layout-item md-size-50 md-xsmall-size-100">
      <md-field>
      <label>Voor + achternaam*</label>
      <md-input v-model="verzendInfo.naam"></md-input>
    </md-field>
    </div>

    <div class="md-layout-item md-size-50 md-xsmall-size-100">
      <md-field>
      <label>E-mail*</label>
      <md-input v-model="verzendInfo.email"></md-input>
    </md-field>
    </div>

    <div class="md-layout-item md-size-50 md-xsmall-size-100">
      <md-field>
      <label>Adres*</label>
      <md-input v-model="verzendInfo.adres"></md-input>
    </md-field>
    </div>

    <div class="md-layout-item md-size-50 md-xsmall-size-100">
      <md-field>
      <label>Postcode*</label>
      <md-input v-model="verzendInfo.postcode"></md-input>
    </md-field>
    </div>

    <div class="md-layout-item md-size-50 md-xsmall-size-100">
      <md-field>
      <label>Plaats*</label>
      <md-input v-model="verzendInfo.plaats"></md-input>
    </md-field>
    </div>

    <div class="md-layout-item md-size-50 md-xsmall-size-100">
      <md-field>
          <label for="Land">Land*</label>
      <md-select v-model="verzendInfo.land" name="land" id="land">
            <md-option value="Nederland">Nederland</md-option>
            <md-option value="Duitsland">Duitsland</md-option>
            <md-option value="België">België</md-option>
            <md-option value="Luxemburg">Luxemburg</md-option>
          </md-select>
        </md-field>
    </div>

  </div>

  <md-button class="md-raised md-primary" @click="activePage = 'cart'">Terug</md-button>



  <md-button class="md-primary md-raised" @click="checkFields()">Afrekenen</md-button>

  <md-dialog-alert
      :md-active.sync="alertDialog"
      md-content="Vul alle velden goed in."
      md-confirm-text="Begrepen" />

  <md-dialog :md-active.sync="showDialog">

      <md-tabs md-dynamic-height>
        <md-tab md-label="Bestelling informatie">
          <div class="input-wrapper ta-center">
        <div class="md-layout md-gutter">
          <div class="md-layout-item md-size-50">
            <md-field>
            <label>Voor + achternaam</label>
            <md-input v-model="verzendInfo.naam" readonly></md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>E-mail</label>
            <md-input v-model="verzendInfo.email" readonly></md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>Adres</label>
            <md-input v-model="verzendInfo.adres" readonly></md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>Postcode</label>
            <md-input v-model="verzendInfo.postcode" readonly></md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>Plaats</label>
            <md-input v-model="verzendInfo.plaats" readonly></md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>Land</label>
            <md-input v-model="verzendInfo.land" readonly></md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>Sub totaal</label>
            <md-input v-model='subTotaal' readonly>€{{priceTogheter}}</md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>BTW (21%)</label>
            <md-input v-model='taxPrijs' readonly>€{{taxPrice}}</md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>Verzend kosten</label>
            <md-input v-model='verzendKosten' readonly>€{{deliveryCosts}}</md-input>
          </md-field>
          </div>

          <div class="md-layout-item md-size-50">
            <md-field>
            <label>Totaal</label>
            <md-input v-model='totaalPrijs' readonly>€{{totalPrice}}</md-input>
          </md-field>
          </div>

        </div>
  </div>
    </md-tab>
        </md-tabs>

        <md-card-header>
          <div class="md-title ta-center bestel-info-check">Klopt alle info?</div>
        </md-card-header>

      <md-dialog-actions>
        <md-button class="md-primary" @click="showDialog = false">Terug</md-button>
        <md-button class="md-primary" @click="bestelWinkelwagen()">Afrekenen</md-button>
      </md-dialog-actions>

      <div class="footer-margin-bottom">
      </div>

    </md-dialog>

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

        props:['cartProp'],

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
            tab: 'Home / Shop / New',
            cart: [],
            activePage: 'cart',
            showDialog: false,
            alertDialog: false,
            subTotaal: '',
            taxPrijs: '',
            verzendKosten: '',
            totaalPrijs: '',
            verzendInfo: {
              naam: '',
              email: '',
              adres: '',
              postcode: '',
              plaats: '',
              land: '',
            }
          };
        },

        computed: {

          priceTogheter(){
            var price = 0;

            this.cart.forEach((item, i) => {
              var itemPrice = item.prijs.replace(',', '.');
              var prijsXaantal = itemPrice * item.aantalVanProduct;
              price = price + prijsXaantal;
            });

            this.subTotaal = '€' + String(price.toFixed(2)).replace('.', ',');
            return String(price.toFixed(2)).replace('.', ',');

          },

          taxPrice(){
            var taxPrice = this.priceTogheter.replace(',', '.')*0.21;
            this.taxPrijs = '€' + String(taxPrice.toFixed(2)).replace('.', ',');
            return String(taxPrice.toFixed(2)).replace('.', ',');
          },

          deliveryCosts(){
            var gewicht = 16;

            this.cart.forEach((item, i) => {
              var productGewicht = item.gewicht*parseFloat(item.aantalVanProduct);
              gewicht = gewicht + productGewicht;
            });

            var deliveryCosts = 0.95;

            if (this.verzendInfo.land == 'Nederland') {
            var increasePerWeightClass = 1;
          }else {
            var increasePerWeightClass = 2;
          }

            if (gewicht <= 20) {
              deliveryCosts = deliveryCosts + increasePerWeightClass;

            }else if (gewicht > 20 && gewicht <= 50) {
              deliveryCosts = deliveryCosts + increasePerWeightClass * 2;

            }else if (gewicht > 50 && gewicht <= 100) {
              deliveryCosts = deliveryCosts + increasePerWeightClass * 3;

            }else if (gewicht > 100 && gewicht <= 2000) {
              deliveryCosts = deliveryCosts + increasePerWeightClass * 4;
            }

            deliveryCosts = String(deliveryCosts).replace('.', ',');
            this.verzendKosten = '€' + deliveryCosts;
            return deliveryCosts;
          },

          totalPrice(){
            var totalPrice = parseFloat(this.priceTogheter.replace(',', '.')) + parseFloat(this.deliveryCosts.replace(',', '.'));
            this.totaalPrijs = '€' + String(totalPrice.toFixed(2)).replace('.', ',');
            return String(totalPrice.toFixed(2)).replace('.', ',');
          },

        },

        mounted(){
        window.scrollTo(0, 0);

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
          setPage(page, item){
            this.$emit('setPage', page, item);
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

          checkFields(){
            if (this.verzendInfo.naam != '' && this.verzendInfo.email != '' && this.verzendInfo.adres != '' && this.verzendInfo.postcode != '' &&
                this.verzendInfo.plaats != '' && this.verzendInfo.land != '') {
            this.showDialog = true;
          }else {
            this.alertDialog = true;
          }

          },

          priceXaantal(prijs, aantal){
            var totaal = parseFloat(prijs.replace(",", ".")) * aantal;
            return String(totaal.toFixed(2)).replace('.', ',');
          },

          bestelWinkelwagen(){
            this.showDialog = false;

            var optiesArray = [];

            this.cart.forEach((product, index) => {

              optiesArray[index] = [];

              if (product.opties == null) {
                optiesArray[index].push({'id': product.id ,'naam': 'geen', 'value': 'geen'})
              }else {
                product.opties.forEach((item, i) => {
                  optiesArray[index].push({'id': product.id ,'naam': product.optieNaam[i], 'value': product.selectedKeuzes[i]});
                });
              }

            });




            axios
            .post('/prepare-payment', {'cart': this.cart, 'prijs': this.totalPrice.replace(',', '.'), 'verzendInfo': this.verzendInfo, 'opties': optiesArray})
            .then(response => window.location.replace(response.data));

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
