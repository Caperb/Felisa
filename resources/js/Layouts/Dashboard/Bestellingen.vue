<template>
  <div class="content margin-top-2">
    <EditBestelling
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      :selectedBestelling="selectedBestelling"
      v-if="this.activePage == 'edit'"
    />
    <div v-if="this.activePage == 'main'">
      <md-table
        v-if="this.paginationData != 'fresh'"
        v-model="paginationData"
        md-sort="orderID"
        md-sort-order="desc"
        md-card
        md-fixed-header
      >
        <md-table-toolbar>
          <div class="md-toolbar-section-start">
            <h1 class="md-title">Bestellingen</h1>
          </div>

  <div class="md-layout md-gutter">
    <div class="md-layout-item">
      <md-field>
      <label for="movies">Geselecteerde status</label>
      <md-select v-model="selectedStatus" name="status" id="status" md-dense>
        <md-option value="">Geen</md-option>
        <md-option value="Nieuw">Nieuw</md-option>
        <md-option value="WorkingOn">Working on</md-option>
        <md-option value="BestellingLigtKlaar">Bestelling ligt klaar</md-option>
        <md-option value="BestellingVerstuurd">Verstuurd</md-option>
      </md-select>
    </md-field>
    </div>
    <div class="md-layout-item">
      <md-field md-clearable class="md-toolbar-section-end">
        <md-input
          placeholder="Zoeken..."
          v-model="searchInput"
          @keyup="search()"
          type="text"
        />
      </md-field>
    </div>
  </div>




        </md-table-toolbar>

        <md-table-empty-state
          md-label="Geen bestelling gevonden"
          :md-description="`Geen bestelling gevonden voor deze zoekopdracht. Probeer een andere zoekterm of wacht totdat er een bestelling wordt aangemaakt.`"
        >
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
          <md-table-cell md-label="orderID" md-sort-by="orderID" md-numeric>{{
            item.orderID
          }}</md-table-cell>

          <md-table-cell v-if="item.deliveryStatus == 'BestellingVerstuurd'"
            md-label="Betaling status"
            md-sort-by="status"
            md-numeric
            >Bestelling verstuurd</md-table-cell
          >

          <md-table-cell v-else-if="item.deliveryStatus == 'WorkingOn'"
            md-label="Betaling status"
            md-sort-by="status"
            md-numeric
            >Working on</md-table-cell
          >

          <md-table-cell v-else-if="item.deliveryStatus == 'BestellingLigtKlaar'"
            md-label="Betaling status"
            md-sort-by="status"
            md-numeric
            >Bestelling ligt klaar</md-table-cell
          >

          <md-table-cell v-else
            md-label="Status"
            md-sort-by="deliveryStatus"
            md-numeric
            >{{ item.deliveryStatus }}</md-table-cell
          >

          <md-table-cell
            md-label="Betaling status"
            md-sort-by="status"
            md-numeric
            >{{ item.status }}</md-table-cell
          >

          <md-table-cell md-label="Aangemaakt op" md-sort-by="created_at=">{{
            item.created_at
          }}</md-table-cell>

          <md-table-cell md-label="Acties" class="display-flex">
            <div
              @click="changeValue('activePage', 'edit', item)"
              class="display-flex"
            >
              <span class="material-icons table-icon">search</span>
            </div>
          </md-table-cell>
        </md-table-row>
      </md-table>
    </div>
  </div>
</template>

<script>
import EditBestelling from "@/Layouts/Dashboard/EditBestelling";

export default {
  components: {
    EditBestelling,
  },

  props:[],

  data() {
    return {
      activePage: "main",
      paginationData: 'fresh',
      searchInput: "",
      selectedProduct: {},
      selectedStatus: '',
    };
  },

  mounted() {
    axios
      .post("/all-bestellingen")
      .then((response) => (this.paginationData = response.data));
  },

  watch: {
    activePage() {
      if (this.activePage == "main") {
        this.refreshData();
      }
    },

    selectedStatus(){
      axios
      .post('get-bestelling-with-status', {'status': this.selectedStatus})
      .then(response => this.paginationData = response.data);
    },
  },

  methods: {
    changeValue(name, value, bestelling) {
      this[name] = value;

      if ((value = "edit")) {
        this.selectedBestelling = bestelling;
      }
    },

    search() {
      this.refreshData();
    },

    refreshData() {
      axios
        .post("all-bestellingen", {
          input: this.searchInput,
        })
        .then((response) => (this.paginationData = response.data));
    },
  },
};
</script>
