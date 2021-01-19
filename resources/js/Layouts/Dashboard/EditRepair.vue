<template>
  <div class="content">
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>build</md-icon>
        </div>
        <h3 v-if="this.selectedRepair != {}" class="md-title ta-right">
          Reparatie # {{ this.selectedRepair.id }} -
          {{ this.selectedRepair.voornaam }}
          {{ this.selectedRepair.achternaam }} bewerken
        </h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Basic information -->
          <md-step id="first" md-label="Algemene gegevens">
            <div class="input-wrapper">
              <KlantSelecteren @klantGeselecteerd="klantGeselecteerd" @setActivePage="setActivePage"/>


              <md-field>
                <label for="employee">Aangemaakt door</label>
                <md-select
                  v-model="selectedRepair.userID"
                  name="employee"
                  id="employee"
                >
                  <md-option
                    v-for="user in this.allUsers"
                    :value="user.id"
                    v-bind:key="user.id"
                    >{{ user.name }}</md-option
                  >
                </md-select>
              </md-field>

              <md-field>
                <label for="state">Status</label>
                <md-select
                  v-model="selectedRepair.state"
                  name="state"
                  id="state"
                >
                  <md-option value="nieuw">Nieuw</md-option>
                  <md-option value="In progress">Actief</md-option>
                  <md-option value="Waiting for delivery">Klaar</md-option>
                  <md-option value="due">Verlopen</md-option>
                  <md-option value="done">Afgerond</md-option>
                </md-select>
              </md-field>

              <label for="due">Gereed op</label>
              <md-datepicker name="due" id="due" v-model="selectedRepair.due" />
            </div>
          </md-step>

          <md-step id="second" md-label="Reparatie gegevens">
            <!-- Repair information -->
            <div class="input-wrapper ta-center">
            <md-field>
                <label>Beschrijving</label>
                <md-textarea
                  v-model="selectedRepair.beschrijving"
                  md-autogrow
                  type="text"
                ></md-textarea>
              </md-field>

              <md-field>
                <label>Kosten</label>
                <md-icon>euro_symbol</md-icon>
                <md-input
                  v-model="selectedRepair.prijs"
                  type="number"
                ></md-input>
              </md-field>
              <h3 class="Subheading">Handtekening</h3>
              <img id="handtekeningImage" style="height: 150px" />

              <md-button
                class="md-primary med-md-button"
                type="submit"
                @click="editRepair()"
                >Bewerken</md-button
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
import KlantSelecteren from "@/Layouts/KlantSelecteren";

export default {
  components: {
    KlantSelecteren,
  },

  props: ["allUsers", "selectedRepair"],

  data() {
    return {
      paginationData: "",
      selectedPaginationPage: 1,
      response: "",
      geselecteerdeKlant: "",
    };
  },

  mounted() {

    if (this.selectedOrder.state == null) {
      this.selectedOrder.state = "";
    }

    if (this.selectedOrder.contractType == null) {
      this.selectedOrder.contractType = "";
    }

    this.selectedOrder.contractType = "";

    axios({
      url: "/get-handtekening", //your url
      method: "POST",
      data: { id: this.selectedRepair.id },
      responseType: "blob", // important
    }).then((response) => {
      const image = window.URL.createObjectURL(new Blob([response.data]));
      const element = document.getElementById("handtekeningImage");
      element.setAttribute("src", image); //or any other extension
    });
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
    setActivePage(page, subPage){
      this.$emit('setActivePage', page, subPage);
    },

    back() {
      this.$emit("back");
    },

    klantGeselecteerd(klant) {
      this.geselecteerdeKlant = klant;
    },

    editRepair() {
      axios
        .post("edit-repair", {
          'id': this.selectedRepair.id,
          'klantID': this.geselecteerdeKlant.id,
          'merk': this.selectedRepair.merk,
          'model': this.selectedRepair.model,
          'prijs': this.selectedRepair.prijs,
          'userID': this.selectedRepair.userID,
          'provider': this.selectedRepair.provider,
          'due': this.selectedRepair.due,
          'state': this.selectedRepair.state,
          'beschrijving': this.selectedRepair.beschrijving,
          'schades': this.selectedRepair.schades,
          'eerderGerepareerd': this.selectedRepair.eerderGerepareerd,
        })
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },
  },
};
</script>
