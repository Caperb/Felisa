<template>
  <div class="content margin-top-2">
    <AddHappyCustomer
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      v-if="this.activePage == 'add'"
    />
    <div v-if="this.activePage == 'main'">
      <md-table
        v-if="this.paginationData != 'fresh'"
        v-model="paginationData"
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
            <h1 class="md-title">Happy customers</h1>
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
          md-label="Geen happy customers gevonden"
          :md-description="`Geen happy customers gevonden voor deze zoekopdracht. Probeer een andere zoekterm of maak een nieuwe happy customers aan.`"
        >
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
          <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{
            item.id
          }}</md-table-cell>

          <md-table-cell
            md-label="Naam"
            md-sort-by="naam"
            md-numeric
            >{{ item.naam }}</md-table-cell
          >

          <md-table-cell md-label="Type" md-sort-by="type">{{
            item.type
          }}</md-table-cell>

          <md-table-cell v-if="item.type == 'tekst'" md-label="Tekst/Foto" md-sort-by="">{{
            item.tekst
          }}</md-table-cell>

          <md-table-cell v-if="item.type == 'foto'" md-label="Tekst/Foto" md-sort-by="">{{
            item.fotoNaam
          }}</md-table-cell>

          <md-table-cell md-label="Acties" class="display-flex">

            <div @click="deleteHappyCustomer(item.id, item.fotoNaam)" class="display-flex">
              <span class="material-icons table-icon">delete</span>
            </div>
          </md-table-cell>
        </md-table-row>
      </md-table>
    </div>
  </div>
</template>

<script>
import AddHappyCustomer from "@/Layouts/Dashboard/AddHappyCustomer";

export default {
  components: {
    AddHappyCustomer,
  },

  props:['selectedSubPage'],

  data() {
    return {
      activePage: "main",
      paginationData: 'fresh',
      searchInput: "",
      selectedProduct: {},
    };
  },

  mounted() {
    axios
      .post("/get-happy-customers")
      .then((response) => (this.paginationData = response.data));

      if(this.selectedSubPage == 'addProduct'){
           this.activePage = 'add';
         }
  },

  watch: {
    selectedSubPage(){
            if(this.selectedSubPage == 'addProduct'){
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
    changeValue(name, value, product) {
      this[name] = value;

      if ((value = "edit")) {
        this.selectedProduct = product;
      }
    },

    search() {
      this.refreshData();
    },

    deleteHappyCustomer(id, fotoNaam) {
      let c = confirm("Weet je zeker dat je de happy customer met de id: " + id + ' wilt verwijderen?');

      if (c == true) {
        axios.post("delete-happy-customer", { 'id': id , 'fotoNaam': fotoNaam});
        this.refreshData();
      }
    },

    refreshData() {
      axios
        .post("/get-happy-customers", {'searchInput': this.searchInput})
        .then((response) => (this.paginationData = response.data));
    },
  },
};
</script>
