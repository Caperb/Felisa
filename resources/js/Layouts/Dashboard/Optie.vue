<template>
  <div class="content margin-top-2">
    <EditOptie
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      :item="this.item"
      v-if="this.activePage == 'edit'"
    />
    <AddOptie
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
            <h1 class="md-title">Opties</h1>
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
          md-label="Geen optie gevonden"
          :md-description="`Geen optie gevonden voor deze zoekopdracht. Probeer een andere zoekterm of maak een nieuwe optie aan.`"
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
          <md-table-cell v-if="item.type == 'meerdereKeuzes'"
            md-label="Type"
            md-sort-by="type"
            md-numeric
            >Meerdere keuzes</md-table-cell
          >

          <md-table-cell v-else
            md-label="Type"
            md-sort-by="type"
            md-numeric
            >{{item.type}}</md-table-cell
          >

          <md-table-cell md-label="Acties" class="display-flex">

            <div
              @click="changeValue('activePage', 'edit', item)"
              class="display-flex"
            >
              <span class="material-icons table-icon">edit</span>
            </div>

            <div @click="deleteOptie(item.id, item.naam)" class="display-flex">
              <span class="material-icons table-icon">delete</span>
            </div>

          </md-table-cell>
        </md-table-row>
      </md-table>
    </div>
  </div>
</template>

<script>
import EditOptie from "@/Layouts/Dashboard/EditOptie";
import AddOptie from "@/Layouts/Dashboard/AddOptie";

export default {
  components: {
    EditOptie,
    AddOptie,
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
      .post("/all-opties")
      .then((response) => (this.paginationData = response.data));

      if(this.selectedSubPage == 'addOptie'){
           this.activePage = 'add';
         }
  },

  watch: {
    selectedSubPage(){
            if(this.selectedSubPage == 'addOptie'){
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

    search() {
      this.refreshData();
    },

    deleteOptie(id, naam) {
      let c = confirm("Weet je zeker dat je deze optie en alle onderliggende keuzes wilt verwijderen: " + naam + "?");

      if (c == true) {
        axios.post("delete-optie", { id: id});
        this.refreshData();
      }
    },

    refreshData() {
      axios
        .post("/all-opties", {searchInput: this.searchInput})
        .then((response) => (this.paginationData = response.data));
    },
  },
};
</script>
