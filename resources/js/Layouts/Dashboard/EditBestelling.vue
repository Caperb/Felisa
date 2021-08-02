<template>
  <div id="EditBestelling">
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon><span class="material-icons">note_add</span></md-icon>
        </div>
        <h3 class="md-title ta-right margin-right-1vw">Bestelling bekijken</h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Bestelling info">
            <div class="ta-center">
              <md-toolbar class="order-toolbar">
                <div class="md-layout md-gutter">

                  <div class="md-layout-item">
                    <md-field>
                      <label for="orderStatus">Order Status</label>
                      <md-select v-model="selectedBestelling.deliveryStatus" @md-selected="statusChange(selectedBestelling.id,
                        selectedBestelling.deliveryStatus)" name="deliveryStatus" id="deliveryStatus" md-dense>
                        <md-option value="Nieuw">Nieuw</md-option>
                        <md-option value="WorkingOn">Working on</md-option>
                        <md-option value="BestellingLigtKlaar">Bestelling ligt klaar</md-option>
                        <md-option value="BestellingVerstuurd">Bestelling verstuurd</md-option>
                      </md-select>
                    </md-field>
                  </div>

                  <div class="md-layout-item">
                    <p>Totaal gewicht: {{calcTotalWeight}} gr, {{deliveryCosts}}</p>
                  </div>

                  <div class="md-layout-item">
                    <p>Betaling status: {{this.selectedBestelling.status}}</p>
                  </div>

                  <div class="md-layout-item" v-if="this.selectedBestelling.status == 'Betaald' || this.selectedBestelling.status == 'Refunded'">
                    <md-button class="md-raised md-primary" @click='openRefundWindow()'>Refund</md-button>
                  </div>

                  <div class="md-layout-item" v-if="this.selectedBestelling.status == 'Betaald' || this.selectedBestelling.status == 'Refunded'">
                    <p v-if="this.selectedBestelling.refunded == null">Totaal refunded: €0,-</p>
                    <p v-else>Totaal refunded: €{{this.selectedBestelling.refunded}}</p>
                  </div>

                </div>
              </md-toolbar>

              <div class="md-layout md-gutter">
                <div class="md-layout-item">Foto</div>
                <div class="md-layout-item">Product ID</div>
                <div class="md-layout-item">Naam</div>
                <div class="md-layout-item">Aanpassingen</div>
                <div class="md-layout-item">Prijs</div>
                <div class="md-layout-item">Aantal</div>
                <div class="md-layout-item">Gewicht</div>
                <div class="md-layout-item">Gemaakt</div>
              </div>

              <div class="md-layout md-gutter margin-top-2vh" v-for="(product, index) in this.allProducten[2]"  :key="product">

                <div class="md-layout-item margin-auto-top-bottom"><img :src="product[0].foto" :alt="product[0].naam"></div>
                <div class="md-layout-item margin-auto-top-bottom">{{product[0].id}}</div>
                <div class="md-layout-item margin-auto-top-bottom">{{product[0].naam}}</div>
                <div class="md-layout-item margin-auto-top-bottom" v-if="product[0].opties != null">
                  <span v-for="(optie, index) in allProducten[1][index]"  :key="">
                    <span v-if="optie.value != null">
                      {{optie.naam}}: {{optie.value}}<br>
                    </span>

                    <span v-else>
                      {{optie.naam}}: Geen<br>
                    </span>
                  </span>
                </div>
                <div class="md-layout-item margin-auto-top-bottom" v-else>
                  <p>Geen opties</p>
                </div>

                <div class="md-layout-item margin-auto-top-bottom">{{product[0].prijs}}</div>
                <div class="md-layout-item margin-auto-top-bottom">{{allProducten[0][index].amount}}</div>
                <div class="md-layout-item margin-auto-top-bottom">{{product[0].gewicht}}</div>
                <div class="md-layout-item margin-auto-top-bottom">
                  <md-checkbox v-model="allProducten[0][index].done" value="1" @change="changeProductStatus(allProducten[0][index].id,
                    allProducten[0][index].done)"></md-checkbox>
                </div>
              </div>

      </div>

          </md-step>

          <md-step id="second" md-label="Klant gegevens">
            <md-toolbar class="order-toolbar">
              <div class="md-layout md-gutter">

                <div class="md-layout-item">
                  <md-field>
                    <label for="orderStatus">Order Status</label>
                    <md-select v-model="selectedBestelling.deliveryStatus" @md-selected="statusChange(selectedBestelling.id,
                      selectedBestelling.deliveryStatus)" name="deliveryStatus" id="deliveryStatus" md-dense>
                      <md-option value="Nieuw">Nieuw</md-option>
                      <md-option value="WorkingOn">Working on</md-option>
                      <md-option value="BestellingLigtKlaar">Bestelling ligt klaar</md-option>
                      <md-option value="BestellingVerstuurd">Bestelling verstuurd</md-option>
                    </md-select>
                  </md-field>
                </div>

                <div class="md-layout-item">
                  <p>Totaal gewicht: {{calcTotalWeight}} gr, {{deliveryCosts}}</p>
                </div>

                <div class="md-layout-item">
                  <p>Betaling status: {{this.selectedBestelling.status}}</p>
                </div>

              </div>
            </md-toolbar>
              <div class="input-wrapper ta-center">

                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-size 50">
                    <md-field>
                    <label>Voor + achternaam</label>
                    <md-input v-model="selectedBestelling.naam" readonly></md-input>
                  </md-field>
                  </div>

                  <div class="md-layout-item md-size 50">
                    <md-field>
                    <label>Email</label>
                    <md-input v-model="selectedBestelling.email" readonly></md-input>
                  </md-field>
                  </div>

                  <div class="md-layout-item md-size 50">
                    <md-field>
                    <label>Adres</label>
                    <md-input v-model="selectedBestelling.adres" readonly></md-input>
                  </md-field>
                  </div>

                  <div class="md-layout-item md-size 50">
                    <md-field>
                    <label>Postcode</label>
                    <md-input v-model="selectedBestelling.postcode" readonly></md-input>
                  </md-field>
                  </div>

                  <div class="md-layout-item md-size 50">
                    <md-field>
                    <label>Plaats</label>
                    <md-input v-model="selectedBestelling.plaats" readonly></md-input>
                  </md-field>
                  </div>

                  <div class="md-layout-item md-size 50">
                    <md-field>
                    <label>Land</label>
                    <md-input v-model="selectedBestelling.land" readonly></md-input>
                  </md-field>
                  </div>
                </div>

          </div>
            </md-step>

            <md-dialog-confirm
      :md-active.sync="showRefundWindow"
      md-title="Weet je zeker dat je een deel van deze bestelling wilt terugstorten?"
      md-confirm-text="Terugstorten"
      md-cancel-text="Cancel"
      @md-cancel="showRefundWindowCancel"
      @md-confirm="showRefundWindowConfirm" />


      <md-dialog :md-active.sync="showRefundingWindow">
      <md-dialog-title>Hoeveel wil je terug storen?</md-dialog-title>

      <md-tabs md-dynamic-height>
        <md-tab md-label="Hoeveelheid €">
          <div class="input-wrapper ta-center">
          <md-field>
      <md-input v-model="refundAmount" type="number"></md-input>
    </md-field>
  </div>
        </md-tab>
      </md-tabs>

      <md-dialog-actions>
        <md-button class="md-primary" @click="showRefundingWindow = false">Cancel</md-button>
        <md-button class="md-primary" @click="refundNow()">Terugstorten</md-button>
      </md-dialog-actions>
    </md-dialog>

        </md-steppers>
      </md-card-content>
      <md-card-actions class="in-between">
        <md-button class="" @click="back()"
          ><md-icon>arrow_back</md-icon></md-button
        >

      </md-card-actions>
    </md-card>

  </div>
</template>

<script>
export default {
  components: {},

  props: ["activePage", 'selectedBestelling'],

  data() {
    return {
      allProducten: [],
      response: "",
      showRefundWindow: false,
      showRefundingWindow: false,
      refundAmount: null,
    };
  },

  computed:{
    calcTotalWeight(){
      var weight = 16;

      if (this.allProducten[2] != undefined) {
        this.allProducten[2].forEach((item, i) => {
          weight = weight + item[0].gewicht;
        });
      }

      return weight;
    },

    deliveryCosts(){
      var gewicht = this.calcTotalWeight;
      var aantalPostzegels = 0;

      if (this.selectedBestelling.land == 'Nederland') {
      var increasePerWeightClass = 1;
    }else {
      var increasePerWeightClass = 2;
    }

      if (gewicht <= 20) {
        aantalPostzegels = increasePerWeightClass + ' postzegels';

      }else if (gewicht > 20 && gewicht <= 50) {
        aantalPostzegels = increasePerWeightClass * 2 + ' postzegels';

      }else if (gewicht > 50 && gewicht <= 100) {
        aantalPostzegels = increasePerWeightClass * 3 + ' postzegels';

      }else if (gewicht > 100 && gewicht <= 350) {
        aantalPostzegels = increasePerWeightClass * 4 + ' postzegels';
      }else if (gewicht > 350) {
        aantalPostzegels = ' Pakketje';
      }

      return aantalPostzegels;
    },
  },

  mounted() {

      axios
      .post('/get-bestelling-info', {'bestelling': this.selectedBestelling.orderID})
      .then((response) => (this.allProducten = response.data));

  },

  watch: {
    response() {
      if (this.response == 1) {
        this.$emit("back");
      } else {
        alert("Er is iets mis gegaan met opslaan.");
      }
    },

    selectedCategorie(){
      axios
      .post('/get-subs', {id: this.selectedCategorie})
      .then((response) => (this.allSubCategories = response.data));
    },
  },

  methods: {
    back() {
      this.$emit("back");
    },

    refundNow(){
      this.showRefundingWindow = false;


      axios
      .post('refund-payment', {'paymentID': this.selectedBestelling.paymentID, 'amount': parseFloat(this.refundAmount.replace(',', '.')).toFixed(2)});
    },

    showRefundWindowConfirm(){
      this.showRefundWindow = false;
      this.showRefundingWindow = true;
    },

    showRefundWindowCancel(){
      this.showRefundWindow = false;
    },

    openRefundWindow(){
      this.showRefundWindow = true;
    },

    sendWorkingOnEmail(){
      axios
      .post('email-working-on-order', {'email': this.selectedBestelling.email});
    },

    sendDeliveryEmail(email){
      axios
      .post('email-order-send', {'email': this.selectedBestelling.email});
    },

    changeProductStatus(id, status){
      axios
      .post('change-ordered-product-status', {'id': id, 'status': status});
    },

    statusChange(id, deliveryStatus){
      axios
      .post('change-bestelling-status', {'id': id, 'deliveryStatus': deliveryStatus});

      if (deliveryStatus == 'WorkingOn') {
        this.sendWorkingOnEmail();
      }else if (deliveryStatus == 'BestellingVerstuurd') {
        this.sendDeliveryEmail();
      }
    },

    editProduct() {

        if (this.oudeFotoNaam == this.newFotoNaam) {

          axios
          .post('edit-product', {foto: 'none', id: this.selectedProduct.id, naam: this.selectedProduct.naam, beschrijving: this.selectedProduct.beschrijving, categorie: this.selectedProduct.categorie,
                                  subCategorie: this.selectedProduct.subCategorie, opties: this.selectedProduct.opties, prijs: this.selectedProduct.prijs, gewicht: this.selectedProduct.gewicht})
          .then((response) => (this.response = response.data));

        }else {

          this.oudeFotoNaam = this.oudeFotoNaam.replace("/product_fotos/", "");

          let formData = new FormData();
          formData.append('id', this.selectedProduct.id);
          formData.append('foto', this.selectedProduct.foto);
          formData.append('categorie', this.selectedProduct.categorie);
          formData.append('naam', this.selectedProduct.naam);
          formData.append('beschrijving', this.selectedProduct.beschrijving);
          formData.append('prijs', this.selectedProduct.prijs);
          formData.append('newFotoNaam', this.newFotoNaam);
          formData.append('oudeFotoNaam', this.oudeFotoNaam);
          formData.append('subCategorie', this.selectedProduct.subCategorie);
          formData.append('opties', this.selectedProduct.opties);
          formData.append('gewicht', this.selectedProduct.gewicht);

              axios.post( '/edit-product',
                  formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
              ).then((response) => (this.response = response.data))
              .catch((error) => (this.response = error.data));

        }


    },

    handleFileUpload(e){
      this.newFotoNaam = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.selectedProduct.foto = e.target.result;
       };
    },

  },
};
</script>
