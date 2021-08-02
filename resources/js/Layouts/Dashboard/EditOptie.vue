<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>supervisor_account</md-icon>
        </div>
        <h3 class="md-title ta-right" v-if="this.item != {}">
          Optie # {{ this.item.id }} -
          {{ this.item.naam }} bewerken
        </h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Optie toevoegen">
            <div class="input-wrapper ta-center">

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
                class="md-primary med-md-button"
                type="submit"
                @click="editOptie()"
                >Bijwerken</md-button
              >


      </div>

          </md-step>

          <md-step v-if="this.item.type == 'keuze' || this.item.type == 'meerdereKeuzes'" id="second" md-label="Keuzes">
            <div class="input-wrapper ta-center pagina-content-editor">
              <div v-for="(keuze, index) in this.aantalKeuzes"  :key="keuze" class="md-layout md-gutter">
                <div class="md-layout-item md-size-90">
              <md-field>
                <label>Waarde keuze {{index + 1}}</label>
                <md-input
                  v-model="allKeuzes[index].value"
                  placeholder="Waarde"
                  type="text"
                ></md-input>
              </md-field>
            </div>

            <div class="md-layout-item md-size-10">
              <div @click="deleteKeuze(allKeuzes[index].id, allKeuzes[index].value)" class="display-flex">
                <span class="material-icons table-icon">delete</span>
              </div>
            </div>

          </div>
              <md-button
                class="md-icon-button md-raised md-primary float-left"
                @click="addKeuze()"
                ><md-icon>add</md-icon></md-button
              >

              <md-button
                class="md-primary md-raised"
                type="submit"
                @click="editOptie()"
                >Bijwerken</md-button
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
import UploadFile from "@/Layouts/Dashboard/UploadFile";

export default {
  components: {
    UploadFile,
  },

  props: ['item'],

  data() {
    return {
      paginationData: 'fresh',
      selectedPaginationPage: 1,
      response: "",
      allKeuzes: [],
      aantalKeuzes: 0,
    };
  },

  mounted() {
    axios
    .post('/get-keuzes', { id: this.item.id })
    .then((response) => (this.allKeuzes = response.data));
  },

  watch: {
    response() {
      if (this.response == 1) {
        this.$emit("back");
      } else {
        alert("Er is iets mis gegaan met opslaan.");
      }
    },

    allKeuzes(){
      this.aantalKeuzes = this.allKeuzes.length;
    },
  },

  methods: {

    refreshData() {
      axios
      .post('/get-keuzes', { id: this.item.id })
      .then((response) => (this.allKeuzes = response.data));
    },

    back() {
      this.$emit("back");
    },

    editOptie() {
      axios
        .post("edit-optie", {main: this.item, keuzes: this.allKeuzes})
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },

    deleteKeuze(id, value) {
      let c = confirm("Weet je zeker dat je deze optie wilt verwijderen: " + value + "?");

      if (c == true) {
        axios.post("delete-keuze", { id: id });
        this.refreshData();
      }
    },
  },
};
</script>
