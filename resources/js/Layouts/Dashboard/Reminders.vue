<template>
  <div class="content">

<!-- <div class="display-flex" style="width: 150px">
    <md-icon>notification_important</md-icon><p class="md-title">Herinneringen</p>
</div> -->

  <!-- TOP ROW -->
    <div class="md-layout md-gutter top-row">
      <!-- active -->
    <div class="md-layout-item">


        <md-card class="md-accent big-md-card " md-with-hover>
        <md-card-header>
          <div class="card-icon">
            <md-icon>notification_important</md-icon>
          </div>
          <h3 class="md-title ta-right">Actief</h3>
        </md-card-header>

        <md-card-content st >

    <md-table>
      <md-table-row>
        <md-table-head>Titel</md-table-head>
        <md-table-head>Aangemaakt door</md-table-head>
        <md-table-head>Acties</md-table-head>
      </md-table-row>

      <md-table-row v-for="item in this.activePaginationData.data" v-bind:key="item.id">
        <md-table-cell ><p v-text="item.name"></p></md-table-cell>
        <md-table-cell ><p v-text="item.user"></p></md-table-cell>
        <md-table-cell><span class="material-icons cursor-pointer" @click="setDone(item.id)">check_box_outline_blank</span></md-table-cell>
      </md-table-row>
    </md-table>
        </md-card-content>
    </md-card>

    </div>

    <!-- Finished -->
    <div class="md-layout-item">

 <md-card class="md-accent big-md-card " md-with-hover>
        <md-card-header>
          <div class="card-icon">
            <md-icon>notification_important</md-icon>
          </div>
                    <h3 class="md-title ta-right">Afgerond</h3>
        </md-card-header>

        <md-card-content st >

    <md-table>
      <md-table-row>
        <md-table-head>Titel</md-table-head>
        <md-table-head>Afgerond door</md-table-head>
        <md-table-head>Afgerond op</md-table-head>
      </md-table-row>

      <md-table-row v-for="item in this.donePaginationData.data" v-bind:key="item.id">
        <md-table-cell><p v-text="item.name"></p></md-table-cell>
        <md-table-cell><p v-text="item.user"></p></md-table-cell>
        <md-table-cell><p v-text="'(' + item.updated_at + ')'"></p></md-table-cell>
      </md-table-row>
    </md-table>
        </md-card-content>
    </md-card>

    </div>
  </div>

<!-- BOTTOM ROW -->
    <div class="md-layout md-gutter">
    <!-- Recent -->
     <div class="md-layout-item">
<md-card class="md-accent big-md-card " md-with-hover>
        <md-card-header>
          <div class="card-icon">
            <md-icon>notification_important</md-icon>
          </div>
                    <h3 class="md-title ta-right">Onlangs aangemaakt</h3>
        </md-card-header>

        <md-card-content st >
    <md-table>
      <md-table-row>
        <md-table-head>Titel</md-table-head>
        <md-table-head>Aangemaakt door</md-table-head>
        <md-table-head>Acties</md-table-head>
      </md-table-row>

      <md-table-row v-for="item in this.recentData" v-bind:key="item.id">
        <md-table-cell><p v-text="item.name"></p></md-table-cell>
        <md-table-cell><p v-text="item.user"></p></md-table-cell>
        <md-table-cell><span class="material-icons" @click="deleteReminder(item.id, index)">close</span></md-table-cell>
      </md-table-row>
    </md-table>
        </md-card-content>
    </md-card>
    </div>

        <!-- New -->
  <div class="md-layout-item">
<md-card class="md-accent big-md-card " md-with-hover>
        <md-card-header>
          <div class="card-icon">
            <md-icon>add_alert</md-icon>
          </div>
          <h3 class="md-title ta-right">Nieuwe aanmaken</h3>
        </md-card-header>

        <md-card-content st >


          <div class="row">
          <p class="md-subheading">Aangemaakt door</p>
</div><div class="row">
      <select v-model="selectedUser" style="float: left;" class="input-field margin-bottom-5" type="text" >
        <option value="" disabled selected>Selecteer medewerker</option>
        <option v-for="user in this.allUsers.data" :value="user.name" v-text="user.name"></option>
      </select>
      </div>

          <md-field>
    <label>Taakomschrijving</label>
      <md-input class="reminders-text-input" type="text" v-model="input" v-on:keyup.enter="addReminder()"></md-input>
      </md-field>
            <p class="reminders-input-text reminders-add-button cursor-pointer" @click="addReminder()">Aanmaken</p>

        </md-card-content>
    </md-card>
    </div>
 </div>
</div>

</template>

<script>
export default {
  components: {},

  data() {
    return {
      activePaginationData: {},
      donePaginationData: {},
      recentData: {},
      data: {},
      input: "",
      selectedActivePaginationPage: 1,
      selectedDonePaginationPage: 1,
      response: "",
      allUsers: [],
      selectedUser: '',
    };
  },

  mounted() {
    axios
      .post("all-reminders", { page: 1 })
      .then((response) => (this.data = response.data));

      axios.post('/all-users', {'orderBy': 'id', 'orderByType': 'desc'})
      .then(response => this.allUsers = response.data);
  },

  watch: {
    response() {
      if (this.response != "") {
        if (this.response == 1) {
          this.selectedActivePaginationPage = 1;
          this.selectedDonePaginationPage = 1;
          this.response = "";
          this.input = "";
          this.refreshData();
        } else {
          alert("Er is iets mis gegaan met opslaan.");
        }
      }
    },

    data() {
      this.activePaginationData = this.data[0];
      this.donePaginationData = this.data[1];
      this.recentData = this.data[2];
    },
  },

  methods: {
    addReminder() {
      axios
        .post("add-reminder", { 'input': this.input, 'user': this.selectedUser })
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },

    setDone(id) {
      axios
        .post("change-reminder-status", { 'id': id })
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },

    donePageUp() {
      if (this.selectedDonePaginationPage < this.donePaginationData.last_page) {
        this.selectedDonePaginationPage = this.selectedDonePaginationPage + 1;
        this.refreshDoneData();
      }
    },

    donePageDown() {
      if (this.selectedDonePaginationPage > 1)
        this.selectedDonePaginationPage = this.selectedDonePaginationPage - 1;
      this.refreshDoneData();
    },

    activePageUp() {
      if (
        this.selectedActivePaginationPage < this.activePaginationData.last_page
      ) {
        this.selectedActivePaginationPage =
          this.selectedActivePaginationPage + 1;
        this.refreshActiveData();
      }
    },

    activePageDown() {
      if (this.selectedActivePaginationPage > 1)
        this.selectedActivePaginationPage =
          this.selectedActivePaginationPage - 1;
      this.refreshActiveData();
    },

    deleteReminder(id, index) {
      let c = confirm("Are you sure you want to delete this?");

      if (c == true) {
        axios.post("delete-reminder", { 'id': id });
        this.refreshData();
      }
    },

    refreshData() {
      axios
        .post("all-reminders")
        .then((response) => (this.data = response.data));
        this.splitArray();
    },

    splitArray(){
      this.activePaginationData = this.data[0];
      this.donePaginationData = this.data[1];
      this.recentData = this.data[2];
    },

    refreshDoneData() {
      axios
        .post("done-reminders", { 'page': this.selectedDonePaginationPage })
        .then((response) => (this.donePaginationData = response.data));
    },

    refreshActiveData() {
      axios
        .post("active-reminders", { 'page': this.selectedActivePaginationPage })
        .then((response) => (this.activePaginationData = response.data));
    },
  },
};
</script>
