<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon><span class="material-icons">note_add</span></md-icon>
        </div>
        <h3 class="md-title ta-right margin-right-1vw">Nieuwe categorie toevoegen</h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Categorie toevoegen">
            <div class="input-wrapper ta-center">

              <md-field>
          <label for="categorie">Type categorie</label>
          <md-select v-model="item.type" name="categorie" id="categorie" @md-selected="clearValues()">
            <md-option value="main">Hoofd categorie</md-option>
            <md-option value="secondary">Secundaire categorie</md-option>
          </md-select>
        </md-field>

        <div v-if="item.type == 'main'">

          <md-field>
            <label>Naam</label>
            <md-input
              v-model="item.naam"
              placeholder="Naam"
              type="text"
            ></md-input>
          </md-field>

        </div>

        <div v-if="item.type == 'secondary'">

          <md-field>
      <label for="categorie">Hoofd categorie</label>
      <md-select v-model="item.hoofdCategorie" name="categorie" id="categorie">
        <md-option v-for="categorie in categories"  :key="categorie" :value="categorie.id">{{categorie.naam}}</md-option>
      </md-select>
    </md-field>

          <md-field>
            <label>Naam</label>
            <md-input
              v-model="item.naam"
              placeholder="Naam"
              type="text"
            ></md-input>
          </md-field>

        </div>



              <md-button
                class="md-primary med-md-button"
                type="submit"
                @click="addCategorie()"
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
        type: '',
        hoofdCategorie: '',
        naam: ''
      },
      response: "",
      categories: [],
    };
  },

  mounted() {
    axios
      .post("/all-main-categories")
      .then((response) => (this.categories = response.data))
      .catch((error) => (this.response = error.data));
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

    addCategorie() {
      axios
        .post("/add-categorie-dashboard", this.item)
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },

    clearValues(){
      this.item.hoofdCategorie = '';
    },
  },
};
</script>
