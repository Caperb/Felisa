<template>
  <div class="content margin-top-2">
    <EditProduct
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      :selectedProduct="selectedProduct"
      v-if="this.activePage == 'edit'"
    />
    <AddProduct
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
            <h1 class="md-title">Producten</h1>
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
          md-label="Geen product gevonden"
          :md-description="`Geen product gevonden voor deze zoekopdracht. Probeer een andere zoekterm of maak een nieuwe product aan.`"
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

          <!-- <md-table-cell
            md-label="Beschrijving"
            md-sort-by="beschrijving"
            md-numeric
            >{{ item.beschrijving }}</md-table-cell
          > -->

          <md-table-cell md-label="Categorie" md-sort-by="categorie">{{
            item.categorieNaam
          }}</md-table-cell>

          <!-- <md-table-cell md-label="Opties" md-sort-by="opties">{{
            item.opties
          }}</md-table-cell> -->

          <md-table-cell md-label="Prijs" md-sort-by="prijs">{{
            item.prijs
          }}</md-table-cell>

          <md-table-cell md-label="Acties" class="display-flex">
            <div
              @click="changeValue('activePage', 'edit', item)"
              class="display-flex"
            >
              <span class="material-icons table-icon">edit</span>
            </div>
            <div @click="deleteProduct(item.id, item.naam, item.foto)" class="display-flex">
              <span class="material-icons table-icon">delete</span>
            </div>
          </md-table-cell>
        </md-table-row>
      </md-table>
    </div>
  </div>
</template>

<script>
import EditProduct from "@/Layouts/Dashboard/EditProduct";
import AddProduct from "@/Layouts/Dashboard/AddProduct";

export default {
  components: {
    EditProduct,
    AddProduct,
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
      .post("/all-products")
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

    deleteProduct(id, naam, foto) {
      let c = confirm("Weet je zeker dat je het product met de naam: " + naam + ' wilt verwijderen?');

      if (c == true) {
        foto = foto.replace("/product_fotos/", "");
        axios.post("delete-product", { id: id , foto: foto});
        this.refreshData();
      }
    },

    refreshData() {
      axios
        .post("all-products", {
          input: this.searchInput,
        })
        .then((response) => (this.paginationData = response.data));
    },
  },
};
</script>
