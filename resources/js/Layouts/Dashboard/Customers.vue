<template>
  <div class="content margin-top-2">
    <EditCustomer
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      :selectedKlant="selectedKlant"
      v-if="this.activePage == 'edit'"
    />
    <AddCustomer
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      v-if="this.activePage == 'add'"
    />
    <div v-if="this.activePage == 'main'">
      <md-table
        v-if="this.paginationData != 'fresh'"
        v-model="paginationData.data"
        md-sort="name"
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
            <h1 class="md-title">Klanten</h1>
          </div>

          <md-field md-clearable class="md-toolbar-section-end">
            <md-input
              placeholder="Zoeken..."
              v-model="searchInput"
              @keyup="search()"
              type="text"
            />
          </md-field>
        </md-table-toolbar>

        <md-table-empty-state
          md-label="Geen klant gevonden"
          :md-description="`Geen klant gevonden voor deze zoekopdracht. Probeer een andere zoekterm of maak een nieuwe klant aan.`"
        >
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
          <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{
            item.id
          }}</md-table-cell>
          <md-table-cell
            v-if="item.tussenvoegsel == '' || item.tussenvoegsel == null"
            md-label="Naam"
            md-sort-by="voornaam"
            >{{ item.voornaam + " " + item.achternaam }}</md-table-cell
          >
          <md-table-cell v-else md-label="Naam" md-sort-by="voornaam">{{
            item.voornaam + " " + item.tussenvoegsel + " " + item.achternaam
          }}</md-table-cell>
          <md-table-cell
            md-label="Telefoonnummer"
            md-sort-by="tel"
            md-numeric
            >{{ item.telefoonNummer }}</md-table-cell
          >
          <md-table-cell
            md-label="Geboortedatum"
            md-sort-by="geboortedatum"
            md-numeric
            >{{ item.geboortedatum }}</md-table-cell
          >
          <md-table-cell md-label="E-mail" md-sort-by="emailAdres">{{
            item.emailAdres
          }}</md-table-cell>
          <md-table-cell md-label="Acties" class="display-flex">
            <div
              @click="changeValue('activePage', 'edit', item)"
              class="display-flex"
            >
              <span class="material-icons table-icon">edit</span>
            </div>
            <div @click="deleteKlant(item.id, index)" class="display-flex">
              <span class="material-icons table-icon">delete</span>
            </div>
          </md-table-cell>
        </md-table-row>
      </md-table>
    </div>
  </div>
</template>

<script>
import EditCustomer from "@/Layouts/Dashboard/EditCustomer";
import AddCustomer from "@/Layouts/Dashboard/AddCustomer";

export default {
  components: {
    EditCustomer,
    AddCustomer,
  },

  props:['selectedSubPage'],

  data() {
    return {
      activePage: "main",
      paginationData: 'fresh',
      searchInput: "",
      selectedPaginationPage: 1,
      orderBy: "id",
      orderByType: "desc",
      selectedKlant: {},
    };
  },

  mounted() {
    axios
      .post("all-klanten", {
        orderBy: this.orderBy,
        orderByType: this.orderByType,
      })
      .then((response) => (this.paginationData = response.data));

      if(this.selectedSubPage == 'addCustomer'){
           this.activePage = 'add';
         }
  },

  watch: {
    selectedSubPage(){
            if(this.selectedSubPage == 'addCustomer'){
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
    changeValue(name, value, klant) {
      this[name] = value;

      if ((value = "edit")) {
        this.selectedKlant = klant;
      }
    },

    search() {
      this.selectedPaginationPage = 1;
      this.refreshData();
    },

    setOrderBy(name, type) {
      if (this.orderBy != name || this.orderByType != type) {
        this.selectedPaginationPage = 1;
        this.orderBy = name;
        this.orderByType = type;
        this.refreshData();
      }
    },

    pageUp() {
      if (this.selectedPaginationPage < this.paginationData.last_page) {
        this.selectedPaginationPage = this.selectedPaginationPage + 1;
        this.refreshData();
      }
    },

    pageDown() {
      if (this.selectedPaginationPage > 1)
        this.selectedPaginationPage = this.selectedPaginationPage - 1;
      this.refreshData();
    },

    deleteKlant(id, index) {
      let c = confirm("Are you sure you want to delete ID: " + id);

      if (c == true) {
        axios.post("delete-klant", { id: id });
        this.paginationData.data.splice(index, 1);
      }
    },

    refreshData() {
      axios
        .post("dashboard-customer-search", {
          orderBy: this.orderBy,
          orderByType: this.orderByType,
          input: this.searchInput,
          page: this.selectedPaginationPage,
        })
        .then((response) => (this.paginationData = response.data));
    },
  },
};
</script>
