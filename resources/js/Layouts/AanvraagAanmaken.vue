<template>
  <div class="wrapper">
    <img src="/images/logo-25.svg" class="home-logo" />

    <p class="md-display-2 md-medium-hide">Order aanmaken</p>

    <div class="md-layout md-gutter md-alignment-center-center">
      <div class="input-wrapper">
        <KlantSelecteren
          @klantGeselecteerd="klantGeselecteerd"
          @setActivePage="klantAanmaken"
        />

        <!-- <md-field>
          <label for="ordertype">Soort order</label>
          <md-select v-model="orderType" name="ordertype" id="ordertype">
            <md-option value="tell">Telefoon</md-option>
            <md-option value="artikelen">Artikelen</md-option>
          </md-select>
        </md-field> -->

        <md-field>
          <label for="employee">Geholpen door</label>
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

        <div v-if="orderType == 'tell'">
          <md-field>
            <label for="contract">Contract type</label>
            <md-select
              v-model="newOrder.contractType"
              name="contract"
              id="contract"
            >
              <md-option value="" disabled selected
                >Selecteer een type</md-option
              >
              <md-option value="Sim-only">Sim-Only</md-option>
              <md-option value="Abbonement">Abbonement</md-option>
              <md-option value="Abbonement">N.v.t.</md-option>
            </md-select>
          </md-field>

          <md-field>
            <label>Merk</label>
            <md-input
              v-model="newOrder.merk"
              placeholder="Merk"
              type="text"
              required
            ></md-input>
          </md-field>

          <md-field>
            <label>Model</label>
            <md-input
              v-model="newOrder.model"
              placeholder="Model"
              type="text"
              required
            ></md-input>
          </md-field>

          <md-field>
            <label>Provider</label>
            <md-input
              v-model="newOrder.provider"
              placeholder="Provider"
              type="text"
              required
            ></md-input>
          </md-field>

          <md-field>
            <label>Kosten reparatie</label>
            <md-icon>euro_symbol</md-icon>
            <md-input
              v-model="newOrder.prijs"
              placeholder="Prijs"
              type="number"
              required
            ></md-input>
          </md-field>
        </div>

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
      </div>

      <div class="back-button-bottom" @click="setPage('ticketAanmaken')">
        <md-icon>arrow_back</md-icon>
      </div>

      <div class="continue-button-bottom">
        <OverzichtAanvraagGegevens
          class="md-primary"
          @aanvraagAangemaakt="aanvraagAangemaakt"
          :geselecteerdeKlant="geselecteerdeKlant"
          :newOrder="newOrder"
          :aantalExtraArtikelen="aantalExtraArtikelen"
          :extraArtikelen="extraArtikelen"
          :orderType="orderType"
        />
      </div>
    </div>
  </div>
</template>

<script>
import KlantSelecteren from "@/Layouts/KlantSelecteren";
import OverzichtAanvraagGegevens from "@/Layouts/OverzichtAanvraagGegevens";

export default {
  components: {
    KlantSelecteren,
    OverzichtAanvraagGegevens,
  },

  props: ["allUsers"],

  data() {
    return {
      geselecteerdeKlant: "",
      newOrder: { contractType: "", geholpenDoor: "" },
      aantalExtraArtikelen: 0,
      extraArtikelen: [],
      orderType: "artikelen",
    };
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

    klantGeselecteerd(klant) {
      this.geselecteerdeKlant = klant;
    },

    klantAanmaken() {
      this.$emit("klantAanmaken");
    },

    aanvraagAangemaakt(info) {
      this.$emit("aanvraagAangemaakt", info);
    },

    setPage(value) {
      this.$emit("setPage", value);
    },
  },
};
</script>
