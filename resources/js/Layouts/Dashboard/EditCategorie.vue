<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>supervisor_account</md-icon>
        </div>
        <h3 class="md-title ta-right" v-if="this.selectedKlant != {}">
          Categorie # {{ this.item.positie }} -
          {{ this.item.naam }} bewerken
        </h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Main categorie info">
            <div class="input-wrapper ta-center">
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <label>Naam</label>
                    <md-input
                      v-model="item.naam"
                      type="text"
                    ></md-input>
                  </md-field>
                </div>
            </div>
          </div>
          </md-step>

          <!-- Sub categories -->
          <md-step id="second" md-label="Sub categorieën">
            <div class="input-wrapper ta-center pagina-content-editor">
              <div class="md-layout md-gutter" v-for="sub in this.allSubs"  :key="sub">
                <div class="md-layout-item md-size-85">
                  <md-field>
                    <label>Naam</label>
                    <md-input
                      v-model="sub.naam"
                      type="text"
                    ></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-size-5">
                  <div @click="moveUp(sub.positie, sub.id, sub.type, sub.hoofdCategorie)" class="display-flex">
                    <span class="material-icons table-icon">arrow_circle_up</span>
                  </div>

                  <div @click="moveDown(sub.positie, sub.id, sub.type, sub.hoofdCategorie)" class="display-flex">
                    <span class="material-icons table-icon">arrow_circle_down</span>
                  </div>
                </div>

                <div class="md-layout-item md-size-5">
                  <div @click="deleteCategorie(sub.naam, sub.id, sub.type, sub.hoofdCategorie)" class="display-flex">
                    <span class="material-icons table-icon">delete</span>
                  </div>
                </div>
                </div>

              <md-button
                class="md-primary md-raised"
                type="submit"
                @click="editCategorie()"
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
      allSubs: [],
    };
  },

  mounted() {
    axios
    .post('/get-subs', { id: this.item.id })
    .then((response) => (this.allSubs = response.data));
  },

  watch: {
    response() {
      if (this.response == 1) {
        this.$emit("back");
      } else {
        alert("Er is iets mis gegaan met opslaan.");
      }
    },
  },

  methods: {

    moveUp(positie, id, type, hoofdCategorie){
      if (positie > 1) {
        axios.post('/move-categorie-up', {positie: positie, id: id, type: type, hoofdCategorie: hoofdCategorie});
        this.refreshData();
      }
    },

    moveDown(positie, id, type, hoofdCategorie){
      if (positie < this.allSubs.length) {
        axios.post('/move-categorie-down', {positie: positie, id: id, type: type, hoofdCategorie: hoofdCategorie});
        this.refreshData();
      }
    },

    refreshData() {
      axios
      .post('/get-subs', { id: this.item.id })
      .then((response) => (this.allSubs = response.data));
    },

    back() {
      this.$emit("back");
    },

    editCategorie() {
      axios
        .post("edit-categorie", {main: this.item, subs: this.allSubs})
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },

    deleteCategorie(naam, id, type, hoofdCategorie) {
      let c = confirm("Weet je zeker dat je deze sub categorie wilt verwijderen: " + naam + "?");

      if (c == true) {
        axios.post("delete-categorie", { id: id, type: type, hoofdCategorie: hoofdCategorie });
        this.refreshData();
      }
    },
  },
};
</script>
