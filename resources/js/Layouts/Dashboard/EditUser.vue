<template>
<div>

<md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>supervised_user_circle</md-icon>
        </div>
        <h3 v-if="this.selectedUser != {}" class="md-title ta-right">Medewerker # {{this.selectedUser.id}} - {{this.selectedUser.name}} bewerken</h3>
      </md-card-header>

      <md-card-content st>
        <div class="input-wrapper ta-center pagina-content-editor">
          <md-field>
            <label>Naam</label>
            <md-input
              v-model="selectedUser.name"
              type="text"
            ></md-input>
          </md-field>

          <md-field>
            <label for="role">Role</label>
            <md-select
              v-model="selectedUser.role"
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
              v-model="selectedUser.telefoonNummer"
              type="tel"
            ></md-input>
          </md-field>

          <md-field>
            <label>Emailadres </label>
            <md-input
              v-model="selectedUser.email"
              type="email"
            ></md-input>
          </md-field>

          <md-field>
            <label>Nieuw wachtwoord</label>
            <md-input
              v-model="selectedUser.newPassword"
              type="password"
            ></md-input>
          </md-field>

          <md-field>
            <label>Bevestig wachtwoord</label>
            <md-input
              v-model="selectedUser.confirmPassword"
              type="password"
            ></md-input>
          </md-field>
          <md-button
            class="md-primary md-raised"
            type="submit"
            @click="editUser()"
            >Bevestigen</md-button
          >
        </div>
      </md-card-content>
      <md-card-actions class="in-between">
        <md-button class="" @click="back()"
          ><md-icon>arrow_back</md-icon></md-button
        >
      </md-card-actions>
    </md-card>


  <!-- <h2 class="klant-input-terug-button cursor-pointer" @click="back()"><- Back</h2>

<div class="dashboard-content-header">
<h2 v-if="this.selectedUser != {}" class="dashboard-content-titel" v-text=""><span class="material-icons">supervised_user_circle</span>Medewerker # {{this.selectedUser.id}} - {{this.selectedUser.name}}</h2>
</div>

<div class="dashboard-klant-input-container">
  <div class="row">
    <div class="dashboard-klant-input-box">
    <h2 class="klant-input-titel">Name</h2>
    <input class="dashboard-klant-input-field" type="text" v-model="selectedUser.name"></input>
    </div>
    <div class="dashboard-klant-input-box">
    <h2 class="klant-input-titel">Role</h2>
    <select value="" class="dashboard-klant-input-field" type="text" v-model="selectedUser.role">
    <option value="" disabled selected>Selecteer role</option>
    <option value="admin">Admin</option>
    <option value="stagaire">Stagaire</option>
    </select>
    </div>
    <div class="dashboard-klant-input-box">
      <h2 class="klant-input-titel">Telefoonnummer</h2>
    <input class="dashboard-klant-input-field" type="text" v-model="selectedUser.telefoonNummer"></input>
    </div>
    <div class="dashboard-klant-input-box">
      <h2 class="klant-input-titel">Email</h2>
    <input class="dashboard-klant-input-field" type="text" v-model="selectedUser.email"></input>
    </div>
  </div>
  <div class="row">
    <div class="dashboard-klant-input-box">
    <h2 class="klant-input-titel">New password</h2>
    <input class="dashboard-klant-input-field" type="password" v-model="selectedUser.newPassword"></input>
    </div>
    <div class="dashboard-klant-input-box">
    <h2 class="klant-input-titel">Confirm password</h2>
    <input class="dashboard-klant-input-field" type="password" v-model="selectedUser.confirmPassword"></input>
    </div>
  </div>
    <div class="dashboard-klant-input-box">
    <h2 class="klant-input-save-button cursor-pointer" @click="editUser()">Bevestigen</h2>
    </div>
  </div> -->

</div>
</template>

<script>

    export default {
        components: {
        },

        props:['selectedUser'],

        data(){
          return{
            paginationData: '',
            selectedPaginationPage: 1,
            response: '',
          }
        },

        mounted(){
        },

        watch:{
          response(){
            if(this.response == 1){
                this.$emit('back');
            }else{
              alert('Er is iets mis gegaan met opslaan.');
            }
          },
        },

        methods:{

          back(){
            this.$emit('back');
          },

          editUser(){
            if(this.selectedUser.newPassword == this.selectedUser.confirmPassword){
              axios.post('edit-user', this.selectedUser)
              .then(response => this.response = response.data)
              .catch(error => this.response = error.data);
            }else{
              alert('The given passwords don\'t match.');
            }

          },
        },
    }
</script>
