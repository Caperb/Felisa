<template>
  <div class="content margin-top-2">
    <EditUser
      @back="changeValue('activePage', 'main')"
      :activePage="activePage"
      :selectedUser="selectedUser"
      v-if="this.activePage == 'edit'"
    />
    <AddUser
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
            <h1 class="md-title">Medewerkers</h1>
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
          md-label="Geen medewerker gevonden"
          :md-description="`Geen medewerker gevonden voor deze zoekopdracht. Probeer een andere zoekterm of maak een nieuwe medewerker aan.`"
        >
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
          <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{
            item.id
          }}</md-table-cell>
          <md-table-cell md-label="Naam" md-sort-by="Naam" type="text">{{
            item.name
          }}</md-table-cell>
          <md-table-cell md-label="Role" md-sort-by="Role">{{
            item.role
          }}</md-table-cell>
          <md-table-cell
            md-label="Telefoonnummer"
            md-sort-by="tel"
            md-numeric
            >{{ item.telefoonNummer }}</md-table-cell
          >
          <md-table-cell md-label="Email" md-sort-by="Email" type="email">{{
            item.email
          }}</md-table-cell>
          <md-table-cell md-label="Acties" class="display-flex">
            <div
              @click="changeValue('activePage', 'edit', item)"
              class="display-flex"
            >
              <span class="material-icons table-icon">edit</span>
            </div>
            <div @click="deleteUser(item.id, index)" class="display-flex">
              <span class="material-icons table-icon">delete</span>
            </div>
          </md-table-cell>
        </md-table-row>
      </md-table>
    </div>
  </div>
</template>

<script>
import EditUser from "@/Layouts/Dashboard/EditUser";
import AddUser from "@/Layouts/Dashboard/AddUser";

export default {
  components: {
    EditUser,
    AddUser,
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
      selectedUser: {},
    };
  },

  mounted() {
    axios
      .post("all-users", {
        orderBy: this.orderBy,
        orderByType: this.orderByType,
        page: this.selectedPaginationPage,
      })
      .then((response) => (this.paginationData = response.data));

      if(this.selectedSubPage == 'addUser'){
        this.activePage = 'add';
      };
  },

  watch: {
    activePage() {
      if (this.activePage == "main") {
        this.refreshData();
      }
    },
  },

  methods: {
    changeValue(name, value, user) {
      this[name] = value;
      if ((value = "edit")) {
        this.selectedUser = user;
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

    deleteUser(id, index) {
      let c = confirm("Are you sure you want to delete ID: " + id);

      if (c == true) {
        axios.post("delete-user", { id: id });
        this.paginationData.data.splice(index, 1);
      }
    },

    refreshData() {
      axios
        .post("user-search", {
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
