<template>
  <div class="wrapper">
    <img src="/images/logo-25.svg" class="home-logo" />

    <p class="md-display-2 md-medium-hide">Klant aanmaken</p>

    <div class="input-wrapper">
      <div class="input-row">
        <md-field>
          <label>Voornaam</label>
          <md-input v-model="voornaam" placeholder="Voornaam" required></md-input>
        </md-field>
      </div>

      <div class="input-row">
        <md-field>
          <label>Tussenvoegsel</label>
          <md-input v-model="tussenvoegsel" placeholder="Tussenvoegsel" ></md-input>
        </md-field>
      </div>

      <div class="input-row">
        <md-field>
          <label>Achternaam</label>
          <md-input v-model="achternaam" placeholder="Achternaam" required ></md-input>
        </md-field>
      </div>

      <div class="input-row">
        <md-field>
          <label>Telefoonnummer </label>
          <md-input v-model="telefoonNummer" placeholder="Telefoonnummer" required type="tel"></md-input>
        </md-field>
      </div>

      <div class="input-row">
        <md-field>
          <label>Emailadres </label>
          <md-input v-model="emailAdres" placeholder="Emailadres" type="email"></md-input>
        </md-field>
      </div>

      <div class="input-row">
 <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="postcode">Postcode</label>
                <md-input name="postcode" placeholder="Postcode" v-model="postcode" required/>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="huisNummer">Huisnummer</label>
                <md-input name="huisNummer" placeholder="Huisnummer" v-model="huisNummer" type="number" required/>
              </md-field>
            </div>
          </div>
      </div>

    </div>

    <div class="back-button-bottom" @click="setPage('home')">
      <md-icon >arrow_back</md-icon>
    </div>

    <div class="continue-button-bottom" @click="klantAanmaken()">
      <md-button class="md-primary med-md-button"  type="submit">Aanmaken</md-button>
    </div>
  </div>
</template>

<script>
export default {
  components: {},

  data() {
    return {
      voornaam: "",
      tussenvoegsel: "",
      achternaam: "",
      telefoonNummer: "",
      emailAdres: "",
      postcode: "",
      huisNummer: "",
      response: "",
    };
  },

  watch: {
    response() {
      if (this.response == 1) {
        this.setPage("klantAangemaakt");
      } else {
        alert("Er is iets mis gegaan met opslaan.");
      }
    },
  },

  methods: {
    klantAanmaken() {
      axios
        .post("/klant-aanmaken", {
          voornaam: this.voornaam,
          tussenvoegsel: this.tussenvoegsel,
          achternaam: this.achternaam,
          telefoonNummer: this.telefoonNummer,
          emailAdres: this.emailAdres,
          postcode: this.postcode,
          huisNummer: this.huisNummer,
        })
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.message));
    },

    setPage(value) {
      this.$emit("setPage", value);
    },
  },
};
</script>
