<template>
  <div class="content margin-top-2">
    <EditCategorie
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      :item="this.item"
      v-if="this.activePage == 'edit'"
    />
    <AddCategorie
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      v-if="this.activePage == 'add'"
    />
    <div v-if="this.activePage == 'main'">
      <md-table
        v-if="this.paginationData != 'fresh'"
        v-model="this.paginationData"
        md-sort="positie"
        md-sort-order="asc"
        md-card
        md-fixed-header
      >
        <md-table-toolbar>
          <div class="md-toolbar-section-start">
            <md-button
              class="md-icon-button md-raised md-primary"
              @click="changeValue('activePage', 'add')"
              ><md-icon>add</md-icon></md-button
            >
            <h1 class="md-title">Categorieën</h1>
          </div>

          <md-field md-clearable class="md-toolbar-section-end">
            <md-input
              placeholder="Zoeken op naam..."
              v-model="searchInput"
              @keyup="search()"
              type="text"
            />
          </md-field>
        </md-table-toolbar>

        <md-table-empty-state
          md-label="Geen categorie gevonden"
          :md-description="`Geen categorie gevonden voor deze zoekopdracht. Probeer een andere zoekterm of maak een nieuwe categorie aan.`"
        >
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
          <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{
            item.id
          }}</md-table-cell>
          <md-table-cell
            md-label="Naam"
            md-sort-by="naam"
            >{{item.naam}}</md-table-cell
          >
          <md-table-cell
            md-label="Positie"
            md-sort-by="positie"
            md-numeric
            >{{item.positie}}</md-table-cell
          >

          <md-table-cell md-label="Acties" class="display-flex">

            <div
              @click="changeValue('activePage', 'edit', item)"
              class="display-flex"
            >
              <span class="material-icons table-icon">edit</span>
            </div>

            <div @click="moveUp(item.positie, item.id, item.type, item.hoofdCategorie)" class="display-flex">
              <span class="material-icons table-icon">arrow_circle_up</span>
            </div>

            <div @click="moveDown(item.positie, item.id, item.type, item.hoofdCategorie)" class="display-flex">
              <span class="material-icons table-icon">arrow_circle_down</span>
            </div>

            <div @click="deleteCategorie(item.naam, item.id, item.type, item.hoofdCategorie)" class="display-flex">
              <span class="material-icons table-icon">delete</span>
            </div>

          </md-table-cell>
        </md-table-row>
      </md-table>
    </div>
  </div>
</template>

<script>
import EditCategorie from "@/Layouts/Dashboard/EditCategorie";
import AddCategorie from "@/Layouts/Dashboard/AddCategorie";

export default {
  components: {
    EditCategorie,
    AddCategorie,
  },

  props:['selectedSubPage'],

  data() {
    return {
      activePage: "main",
      paginationData: 'fresh',
      searchInput: '',
      item: {},
    };
  },

  mounted() {
    axios
      .post("/all-main-categories")
      .then((response) => (this.paginationData = response.data));

      if(this.selectedSubPage == 'addCategorie'){
           this.activePage = 'add';
         }
  },

  watch: {
    selectedSubPage(){
            if(this.selectedSubPage == 'addCategorie'){
              this.activePage = 'add';
            }else{
              this.activePage = 'main';
            }
          },

    activePage() {
      if (this.activePage == "main") {
        this.refreshData();
      }
    },
  },

  methods: {
    changeValue(name, value, item) {
      this[name] = value;

      if ((value = "edit")) {
        this.item = item;
      }
    },

    moveUp(positie, id, type, hoofdCategorie){
      if (positie > 1) {
        axios.post('/move-categorie-up', {positie: positie, id: id, type: type, hoofdCategorie: hoofdCategorie});
        this.refreshData();
      }
    },

    moveDown(positie, id, type, hoofdCategorie){
      if (positie < this.paginationData.length) {
        axios.post('/move-categorie-down', {positie: positie, id: id, type: type, hoofdCategorie: hoofdCategorie});
        this.refreshData();
      }
    },

    search() {
      this.refreshData();
    },

    deleteCategorie(naam, id, type, hoofdCategorie) {
      let c = confirm("Weet je zeker dat je deze categorie en alle onderliggende categorieën wilt verwijderen: " + naam + "?");

      if (c == true) {
        axios.post("delete-categorie", { id: id, type: type, hoofdCategorie: hoofdCategorie });
        this.refreshData();
      }
    },

    refreshData() {
      axios
        .post("/all-main-categories", {searchInput: this.searchInput})
        .then((response) => (this.paginationData = response.data));
    },
  },
};
</script>
