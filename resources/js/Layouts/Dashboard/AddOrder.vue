<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>shopping_cart</md-icon>
        </div>
        <h3 class="md-title ta-right">Nieuwe bestelling aanmaken</h3>
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
                  v-model="newOrder.geholpenDoor"
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
                <md-select v-model="newOrder.state" name="state" id="state">
                  <md-option value="nieuw">Nieuw</md-option>
                  <md-option value="In progress">Actief</md-option>
                  <md-option value="Waiting for delivery">Klaar</md-option>
                  <md-option value="due">Verlopen</md-option>
                  <md-option value="done">Afgerond</md-option>
                </md-select>
              </md-field>

              <label for="due">Verwacht</label>
              <md-datepicker name="due" id="due" v-model="newOrder.due" />
            </div>
          </md-step>

          <!-- Order info -->
          <md-step id="second" md-label="Bestelling">
            <div class="input-wrapper ta-center">

              <div
                v-for="(number, index) in this.aantalExtraArtikelen"
                class="md-layout md-gutter"
                v-bind:key="number"
              >
                <div class="md-layout-item">
                  <md-field>
                    <label>Artikel naam</label>
                    <md-input
                      v-model="extraArtikelen[index].naam"
                      placeholder="Artikel naam"
                      >€</md-input
                    >
                  </md-field>
                </div>

                <div class="md-layout-item md-size-30">
                  <md-field>
                    <label>Artikel prijs</label>
                    <md-icon>euro_symbol</md-icon>
                    <md-input
                      v-model="extraArtikelen[index].prijs"
                      placeholder="Artikel prijs"
                      >€</md-input
                    >
                  </md-field>
                </div>
              </div>

              <md-button
                class="md-icon-button md-raised md-primary float-left"
                @click="addArtikel"
                ><md-icon>add</md-icon></md-button
              >

              <md-button
                class="md-primary med-md-button"
                type="submit"
                @click="addOrder()"
                >Aanmaken</md-button
              >
            </div>
          </md-step>
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
import KlantSelecteren from "@/Layouts/KlantSelecteren";

export default {
  components: {
    KlantSelecteren,
  },

  props: ["allUsers"],

  data() {
    return {
      newOrder: { contractType: "", geholpenDoor: "", state: "" },
      paginationData: "",
      selectedPaginationPage: 1,
      response: "",
      geselecteerdeKlant: "",
      aantalExtraArtikelen: 0,
      extraArtikelen: [],
    };
  },

  mounted() {},

  watch: {
    response() {
      if (Number.isInteger(this.response)) {
        this.$emit("back");
      } else {
        alert("Er is iets mis gegaan met opslaan.");
      }
    },
  },

  methods: {

    addArtikel() {
      if (this.aantalExtraArtikelen < 20) {
        this.extraArtikelen.push({ naam: "", prijs: "" });
        this.aantalExtraArtikelen = this.aantalExtraArtikelen + 1;
      } else {
        alert("You've added the max amount of items.");
      }
    },

    setActivePage(page, subPage){
      this.$emit('setActivePage', page, subPage);
    },

    back() {
      this.$emit("back");
    },

    klantGeselecteerd(klant) {
      this.geselecteerdeKlant = klant;
    },

    addOrder() {
      axios
        .post("add-order", {
          klantID: this.geselecteerdeKlant.id,
          merk: this.newOrder.merk,
          model: this.newOrder.model,
          prijs: this.newOrder.prijs,
          geholpenDoor: this.newOrder.geholpenDoor,
          contractType: this.newOrder.contractType,
          provider: this.newOrder.provider,
          due: this.newOrder.due,
          state: this.newOrder.state,
          extraArtikelen: this.extraArtikelen,
        })
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },
  },
};
</script>
