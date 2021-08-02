<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon><span class="material-icons">note_add</span></md-icon>
        </div>
        <h3 class="md-title ta-right margin-right-1vw">Nieuwe optie toevoegen</h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Optie toevoegen">
            <div class="input-wrapper ta-center pagina-content-editor">

              <md-field>
                <label>Naam optie</label>
                <md-input
                  v-model="item.naam"
                  placeholder="Naam"
                  type="text"
                ></md-input>
              </md-field>

              <md-field>
          <label for="type optie">Type optie</label>
          <md-select v-model="item.type" name="type optie" id="type optie">
            <md-option value="tekst">Tekst</md-option>
            <md-option value="keuze">Enkele keuze</md-option>
            <md-option value="meerdereKeuzes">Meerdere keuzes</md-option>
          </md-select>
        </md-field>



              <md-button v-if="this.item.type == 'tekst'"
                class="md-primary md-raised"
                type="submit"
                @click="addOptie()"
                >Aanmaken</md-button
              >


      </div>

          </md-step>

          <md-step v-if="this.item.type == 'keuze' || this.item.type == 'meerdereKeuzes'" id="second" md-label="Keuzes">
            <div class="input-wrapper ta-center pagina-content-editor">

              <md-field v-for="(keuze, index) in this.aantalKeuzes"  :key="keuze">
                <label>Waarde keuze {{index + 1}}</label>
                <md-input
                  v-model="item.keuzes[index]"
                  placeholder="Waarde"
                  type="text"
                ></md-input>
              </md-field>

              <md-button
                class="md-icon-button md-raised md-primary float-left"
                @click="addKeuze()"
                ><md-icon>add</md-icon></md-button
              >

              <md-button
                class="md-primary md-raised"
                type="submit"
                @click="addOptie()"
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
export default {
  components: {},

  props: ["activePage"],

  data() {
    return {
      item: {
        naam: '',
        type: '',
        keuzes: [],
      },
      aantalKeuzes: 1,
      response: "",
      categories: [],
    };
  },

  mounted() {
  },

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
    back() {
      this.$emit("back");
    },

    addOptie() {
      axios
        .post("/add-optie", this.item)
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },

    addKeuze(){
      this.aantalKeuzes = this.aantalKeuzes + 1;
    },

  },
};
</script>
