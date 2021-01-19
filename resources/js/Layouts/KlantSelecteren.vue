<template>
  <div>
    <div
      class="modal-background cursor-pointer"
      v-if="modalVisible"
      @click="toggleValue('modalVisible', false)"
    ></div>

    <div class="select-modal" v-if="modalVisible">
      <!-- Client search -->
      <md-button
        @click="toggleValue('modalVisible', false)"
        class="close-modal-button"
        ><md-icon>close</md-icon>
      </md-button>

      <div class="input-wrapper-modal" v-if="type == 'search'">
        <md-field>
          <label>Voor- of achternaam</label>
          <md-input
            v-model="nameInput"
            v-on:keyup.enter="searchKlanten()"
            placeholder="Voor- of achternaam"
          ></md-input>
        </md-field>

        <md-field>
          <label>Telefoonnummer</label>
          <md-input
            v-model="numberInput"
            v-on:keyup.enter="searchKlanten()"
            placeholder="Telefoonnummer"
          ></md-input>
        </md-field>

        <md-button class="md-primary med-md-button" @click="searchKlanten()"
          >Bevestigen</md-button
        >
        <md-button @click="setActivePage('customers','addCustomer')"
          >Klant niet gevonden? Klant aanmaken</md-button
        >
      </div>

      <!-- Search results -->
      <div class="table-wrapper" v-if="type == 'results'">
        <table class="modal-table">
          <tr>
            <th>Naam</th>
            <th>Postcode</th>
            <th>Telefoonnummer</th>
            <th>Selecteer</th>
          </tr>

          <tr
            class="scrollable"
            v-for="result in this.results"
            v-bind:key="result"
          >
            <td v-text="result.voornaam + ' ' + result.achternaam"></td>
            <td v-text="result.postcode"></td>
            <td v-text="result.telefoonNummer"></td>
            <td class="cursor-pointer" @click="selectKlant(result)">
              <p>selecteer</p>
            </td>
          </tr>
        </table>
        <p
          class="text-align-center margin-top-5 cursor-pointer"
          @click="toggleValue('type', 'search')"
        >
          Terug
        </p>
      </div>
    </div>

    <md-button
      v-if="this.textbox == true"
      @click="toggleValue('modalVisible', true)"
      v-text="geselecteerdeKlant"
      >Aanmaken</md-button
    >
    <md-button
      v-else
      @click="toggleValue('modalVisible', true)"
      v-text="geselecteerdeKlant"
      >Aanmaken</md-button
    >
  </div>
</template>

<script>
export default {
  components: {},

  props: ["textbox"],

  data() {
    return {
      nameInput: '',
      numberInput: '',
      modalVisible: false,
      type: 'search',
      results: [],
      geselecteerdeKlant: 'Klant selecteren',
    };
  },

  watch: {},

  methods: {
    setActivePage(page, subPage){
      this.$emit('setActivePage', page, subPage);
    },

    searchKlanten() {
      if (this.nameInput != "" || this.numberInput != "") {
        this.type = "results";
        axios
          .post("/klant-zoeken", {
            nameInput: this.nameInput,
            numberInput: this.numberInput,
          })
          .then((response) => (this.results = response.data));
      } else {
        alert("Please enter something to search for");
      }
    },

    selectKlant(klant) {
      if (klant.tussenvoegsel != null) {
        this.geselecteerdeKlant =
          klant.voornaam + " " + klant.tussenvoegsel + " " + klant.achternaam;
      } else {
        this.geselecteerdeKlant = klant.voornaam + " " + klant.achternaam;
      }

      this.$emit("klantGeselecteerd", klant);
      this.modalVisible = false;
    },

    klantAanmaken() {
      this.$emit("klantAanmaken");
    },

    toggleValue(name, value) {
      if (name == "modalVisible") {
        this.type = "search";
      }
      this[name] = value;
    },
  },
};
</script>
