<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>build</md-icon>
        </div>
        <h3 class="md-title ta-right">Nieuwe reparatie aanmaken</h3>
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
                  v-model="newRepair.geholpenDoor"
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
                <md-select v-model="newRepair.state" name="state" id="state">
                  <md-option value="nieuw">Nieuw</md-option>
                  <md-option value="In progress">Actief</md-option>
                  <md-option value="Waiting for delivery">Klaar</md-option>
                  <md-option value="due">Verlopen</md-option>
                  <md-option value="done">Afgerond</md-option>
                </md-select>
              </md-field>

              <label for="due">Gereed op</label>
              <md-datepicker name="due" id="due" v-model="newRepair.due" />
            </div>
          </md-step>

          <md-step id="second" md-label="Reparatie gegevens">
            <!-- Repair information -->
            <div class="input-wrapper ta-center">
              <md-field>
                <label>Beschrijving</label>
                <md-textarea
                  v-model="newRepair.beschrijving"
                  placeholder="Beschrijving"
                  md-autogrow
                  type="text"
                ></md-textarea>
              </md-field>

              <md-field>
                <label>Kosten</label>
                <md-icon>euro_symbol</md-icon>
                <md-input
                  v-model="newRepair.prijs"
                  placeholder="Kosten"
                  type="number"
                ></md-input>
              </md-field>
              <md-button
                class="md-primary med-md-button"
                type="submit"
                @click="addRepair()"
                >Aanmaken</md-button
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

  props: ["allUsers"],

  data() {
    return {
      newRepair: { geholpenDoor: "", state: "" },
      paginationData: "",
      selectedPaginationPage: 1,
      response: "",
      geselecteerdeKlant: "",
    };
  },

  mounted() {},

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

    addRepair() {
      axios
        .post("add-repair", {
          klantID: this.geselecteerdeKlant.id,
          merk: this.newRepair.merk,
          model: this.newRepair.model,
          prijs: this.newRepair.prijs,
          geholpenDoor: this.newRepair.geholpenDoor,
          provider: this.newRepair.provider,
          due: this.newRepair.due,
          state: this.newRepair.state,
          beschrijving: this.newRepair.beschrijving,
          schades: this.newRepair.schades,
          eerderGerepareerd: this.newRepair.eerderGerepareerd,
        })
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },
  },
};
</script>
