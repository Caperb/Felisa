<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>supervised_user_circle</md-icon>
        </div>
        <h3 class="md-title ta-right">Nieuwe medewerker aanmaken</h3>
      </md-card-header>

      <md-card-content st>
        <div class="input-wrapper ta-center">
          <md-field>
            <label>Naam</label>
            <md-input
              v-model="newUser.name"
              placeholder="Naam"
              type="text"
            ></md-input>
          </md-field>

          <md-field>
            <label for="role">Role</label>
            <md-select
              v-model="newUser.role"
              name="role"
              id="role"
              type="textt"
            >
              <md-option value="admin">Admin</md-option>
              <md-option value="stagaire">Stagaire</md-option>
            </md-select>
          </md-field>

          <md-field>
            <label>Telefoonnummer </label>
            <md-input
              v-model="newUser.telefoonNummer"
              placeholder="Telefoonnummer"
              type="tel"
            ></md-input>
          </md-field>

          <md-field>
            <label>Emailadres </label>
            <md-input
              v-model="newUser.email"
              placeholder="Emailadres"
              type="email"
            ></md-input>
          </md-field>

          <md-field>
            <label>Wachtwoord</label>
            <md-input
              v-model="newUser.password"
              placeholder="Wachtwoord"
              type="password"
            ></md-input>
          </md-field>

          <md-field>
            <label>Bevestig wachtwoord</label>
            <md-input
              v-model="newUser.confirmPassword"
              placeholder="Bevestig achtwoord"
              type="password"
            ></md-input>
          </md-field>
          <md-button
            class="md-primary med-md-button"
            type="submit"
            @click="addUser()"
            >Aanmaken</md-button
          >
        </div>
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
export default {
  components: {},

  data() {
    return {
      newUser: { role: "" },
      paginationData: "",
      selectedPaginationPage: 1,
      response: "",
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
    back() {
      this.$emit("back");
    },

    addUser() {
      if (this.newUser.password == this.newUser.confirmPassword) {
        axios
          .post("add-user", this.newUser)
          .then((response) => (this.response = response.data))
          .catch((error) => (this.response = error.data));
      } else {
        alert("The given passwords don't match.");
      }
    },
  },
};
</script>
