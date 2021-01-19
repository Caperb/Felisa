<template>
  <div>
    <md-card class="md-accent" md-with-hover>

      <md-card-header>
        <div class="card-icon">
          <md-icon>shopping_cart</md-icon>
        </div>
        <h3 v-if="this.selectedOrder != {}" class="md-title ta-right">
          Bestelling # {{ this.selectedOrder.id }} -
          {{ this.selectedOrder.voornaam }}
          {{ this.selectedOrder.achternaam }} bewerken
        </h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Basic Info -->
          <md-step id="first" md-label="Algemene gegevens">
            <div class="input-wrapper">
              <KlantSelecteren @klantGeselecteerd="klantGeselecteerd" @setActivePage="setActivePage"/>

              <md-field>
                <label for="employee">Aangemaakt door</label>
                <md-select
                  v-model="selectedOrder.userID"
                  name="employee"
                  id="employee"
                >
                  <md-option
                    v-for="user in this.allUsers"
                    :value="user.id"
                    v-bind:key="user.id"
                    >{{ user.name }}</md-option
                  >
                </md-select>
              </md-field>

              <md-field>
                <label for="state">Status</label>
                <md-select
                  v-model="selectedOrder.state"
                  name="state"
                  id="state">
                  <md-option value="nieuw">Nieuw</md-option>
                  <md-option value="In progress">Actief</md-option>
                  <md-option value="Waiting for delivery">Klaar</md-option>
                  <md-option value="Due">Verlopen</md-option>
                  <md-option value="Done">Afgerond</md-option>
                </md-select>
              </md-field>

              <label for="due">Verwacht</label>
              <md-datepicker name="due" id="due" v-model="selectedOrder.due" />
            </div>
          </md-step>

          <!-- Order info -->
          <md-step v-if="this.selectedOrder.merk == null && this.selectedOrder.model == null && this.selectedOrder.model == null && this.selectedOrder.provider == null && this.selectedOrder.prijs == null" id="second" md-label="Bestelling">
<div class="input-wrapper ta-center">
            <div v-for="(number, index) in this.aantalExtraArtikelen" class="md-layout md-gutter" v-bind:key="number">
    <div class="md-layout-item">
      <md-field>
      <label>Artikel naam</label>
      <md-input v-model="extraArtikelen[index].naam" placeholder="Artikel naam" >€</md-input>
      </md-field>
    </div>

    <div class="md-layout-item md-size-30">
      <md-field>
      <label>Artikel prijs</label>
      <md-icon>euro_symbol</md-icon>
      <md-input v-model="extraArtikelen[index].prijs" placeholder="Artikel prijs" >€</md-input>
      </md-field>
    </div>

  </div>
  <md-button class="md-icon-button md-raised md-primary float-left" @click="addArtikel"><md-icon>add</md-icon></md-button>

              <h3 class="Subheading">Handtekening</h3>
              <img id="handtekeningImage" style="height: 150px" />
              <md-button
                class="md-primary med-md-button"
                type="submit"
                @click="editOrder()"
                >Bewerken</md-button>
            </div>
          </md-step>

          <md-step v-else id="second" md-label="Reparatie gegevens">
            <div class="input-wrapper ta-center">
              <md-field>
                <label for="type">Contract type</label>
                <md-select
                  v-model="selectedOrder.contractType"
                  name="type"
                  id="type">
                  <md-option value="SIM-only">SIM-only</md-option>
                  <md-option value="Abbonement">Abbonement</md-option>
                  <md-option value="N.v.t.">N.v.t.</md-option>
                </md-select>
              </md-field>

              <md-field>
                <label>Provider</label>
                <md-input
                  v-model="selectedOrder.provider"
                  type="text"
                ></md-input>
              </md-field>

              <md-field>
                <label>Merk</label>
                <md-input
                  v-model="selectedOrder.merk"
                  type="text"
                  required
                ></md-input>
              </md-field>

              <md-field>
                <label>Model</label>
                <md-input
                  v-model="selectedOrder.model"
                  type="text"
                  required
                ></md-input>
              </md-field>

              <md-field>
                <label>Prijs</label>
                <md-icon>euro_symbol</md-icon>
                <md-input v-model="selectedOrder.prijs" type="number" required
                  >€</md-input>
              </md-field>

              <h3 class="Subheading">Handtekening</h3>
              <img id="handtekeningImage" style="height: 150px" />
              <md-button
                class="md-primary med-md-button"
                type="submit"
                @click="editOrder()"
                >Bewerken</md-button>
            </div>
          </md-step>
        </md-steppers>
      </md-card-content>
      <md-card-actions class="in-between">
        <md-button class="" @click="back()">
      <md-icon>arrow_back</md-icon></md-button>
      </md-card-actions>

    </md-card>

  </div>
</template>

<script>
import KlantSelecteren from "@/Layouts/KlantSelecteren";

export default {
  components: {
    KlantSelecteren,
  },

  props: ["allUsers", "selectedOrder"],

  data() {
    return {
      paginationData: "",
      selectedPaginationPage: 1,
      response: "",
      geselecteerdeKlant: "",
      aantalExtraArtikelen: 0,
      extraArtikelen: [],
    };
  },

  mounted() {

    axios.post('get-extra-artikelen', {'id': this.selectedOrder.id})
        .then(response => this.extraArtikelen = response.data);

    if (this.selectedOrder.state == null) {
      this.selectedOrder.state = "";
    }

    if (this.selectedOrder.contractType == null) {
      this.selectedOrder.contractType = "";
    }

    axios({
      url: "/get-handtekening", //your url
      method: "POST",
      data: { id: this.selectedOrder.id },
      responseType: "blob", // important
    }).then((response) => {
      const image = window.URL.createObjectURL(new Blob([response.data]));
      const element = document.getElementById("handtekeningImage");
      element.setAttribute("src", image); //or any other extension
    });
  },

  watch: {
    extraArtikelen(){
            this.aantalExtraArtikelen = this.extraArtikelen.length;
          },

    response() {
      if (this.response == 1) {
        this.$emit("back");
      } else {
        alert("Er is iets mis gegaan met opslaan.");
      }
    },
  },

  methods: {

    setActivePage(page, subPage){
      this.$emit('setActivePage', page, subPage);
    },

    addArtikel(){
            if(this.aantalExtraArtikelen < 20){
              this.extraArtikelen.push({'naam': '', 'prijs': ''});
              this.aantalExtraArtikelen = this.aantalExtraArtikelen + 1;
            }else{
              alert('You\'ve added the max amount of items.');
            }
          },

    back() {
      this.$emit("back");
    },

    klantGeselecteerd(klant) {
      this.geselecteerdeKlant = klant;
    },

    editOrder() {
      axios
        .post("edit-order", {
          'klantID': this.geselecteerdeKlant.id,
          'merk': this.selectedOrder.merk,
          'model': this.selectedOrder.model,
          'prijs': this.selectedOrder.prijs,
          'userID': this.selectedOrder.userID,
          'contractType': this.selectedOrder.contractType,
          'provider': this.selectedOrder.provider,
          'due': this.selectedOrder.due,
          'state': this.selectedOrder.state,
          'id': this.selectedOrder.id,
          'extraArtikelen': this.extraArtikelen,
        })
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },
  },
};
</script>
