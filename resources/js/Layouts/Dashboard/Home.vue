<template>
<div class="content">

<!-- TOP ROW -->
  <div class="md-layout md-gutter top-row">


    <!-- Ticket general -->
      <div class="md-layout-item">
        <md-card class="md-accent" md-with-hover>

            <md-card-header>
              <div class="card-icon">
                <md-icon>shopping_cart</md-icon>
              </div>
              <div class="md-subhead ta-right">Nieuwe bestellingen</div>
              <h3 class="md-title ta-right" v-text="this.data[18]"></h3>
            </md-card-header>

            <md-card-content st>
            </md-card-content>

            <hr>

            <md-card-actions>
            <div class="card-footer ">
                  <div class="stats" @click="setActivePage('bestellingen')">

                    <i class="material-icons text-danger">warning</i>
                    <a href="#"><p v-text="this.data[1]" class="d-contents"></p>
                    verlopen nieuwe bestellingen</a>
                  </div>
                </div>
            </md-card-actions>
        </md-card>

        </div>

<!-- Ticket general -->
  <div class="md-layout-item">
    <md-card class="md-accent" md-with-hover>

        <md-card-header>
          <div class="card-icon">
            <md-icon>build</md-icon>
          </div>
          <div class="md-subhead ta-right">Bestellingen in progress</div>
          <h3 class="md-title ta-right" v-text="this.data[22]"></h3>
        </md-card-header>

        <md-card-content st>
        </md-card-content>

        <hr>

        <md-card-actions>
        <div class="card-footer ">
              <div class="stats" @click="setActivePage('bestellingen')">

                <i class="material-icons text-danger">warning</i>
                <a href="#"><p v-text="this.data[23]" class="d-contents"></p>
                verlopen bestellingen in progress</a>
              </div>
            </div>
        </md-card-actions>
    </md-card>

    </div>

    <!--  REPAIRS -->
    <div class="md-layout-item">
    <md-card class="md-accent" md-with-hover>

        <md-card-header>
          <div class="card-icon">
            <md-icon>done</md-icon>
          </div>
          <div class="md-subhead ta-right">Klaar liggende bestellingen</div>
          <h3 class="md-title ta-right" v-text="this.data[24]"></h3>
        </md-card-header>

        <md-card-content st>

        </md-card-content>

        <hr>

        <md-card-actions>
        <div class="card-footer ">
              <div class="stats" @click="setActivePage('bestellingen')">
                <i class="material-icons text-danger">warning</i>
                <a href="#"><p v-text="this.data[25]" class="d-contents"></p>
                verlopen klaarliggende bestellingen</a>
              </div>
            </div>
        </md-card-actions>
    </md-card>
    </div>

    <!-- ORDERS -->
    <div class="md-layout-item">
          <md-card class="md-accent " md-with-hover>

        <md-card-header>
          <div class="card-icon">
            <md-icon>paid</md-icon>
          </div>
          <div class="md-subhead ta-right">Verzonden bestellingen</div>
          <h3 class="md-title ta-right" v-text="this.data[26]"></h3>
        </md-card-header>

        <md-card-content st >

        </md-card-content>

    </md-card>
    </div>
  </div>

<!-- SECOND ROW -->
  <div class="md-layout md-gutter ">

<!-- REMINDERS -->
    <div class="md-layout-item">
    <md-card class="md-accent big-md-card " md-with-hover>

        <md-card-header>
          <div class="card-icon">
            <md-icon>notification_important</md-icon>
          </div>
         <div class="md-subhead ta-right">Herinneringen</div>
          <h3 class="md-title ta-right">{{ this.reminderCount }}</h3>
        </md-card-header>

        <md-card-content st >
    <md-table>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Naam</md-table-head>
        <md-table-head>Acties</md-table-head>
      </md-table-row>

      <md-table-row v-for="item in this.reminderData.data"  v-bind:key="item.id">
        <md-table-cell md-numeric>{{item.id}}</md-table-cell>
        <md-table-cell ><p v-text="item.name"></p></md-table-cell>
        <md-table-cell><span class="material-icons cursor-pointer" @click="setDone(item.id)">check_box_outline_blank</span></md-table-cell>

      </md-table-row>
    </md-table>


        </md-card-content>
    </md-card>
    </div>

<!-- CONTRACTS -->
    <!-- <div class="md-layout-item">
          <md-card class="md-accent big-md-card" md-with-hover>

        <md-card-header>
          <div class="card-icon">
            <md-icon>insert_drive_file</md-icon>
          </div>
        <div class="md-subhead ta-right">Contracten</div>
          <h3 class="md-title ta-right" v-text="this.data[16].data"></h3>
        </md-card-header>

        <md-card-content st>


 <md-table>
      <md-table-row>
        <md-table-head >Voornaam</md-table-head>
        <md-table-head>Achternaam</md-table-head>
        <md-table-head>verloopdatum</md-table-head>
        <md-table-head>Acties</md-table-head>
      </md-table-row>

      <md-table-row v-for="item in this.contractData.data"  v-bind:key="item.id">
        <md-table-cell ><p v-bind:class="{ 'color-red': calcDateExpired(item.verloopDatumAbbonement) }" v-text="item.voornaam"></p></md-table-cell>
        <md-table-cell ><p v-bind:class="{ 'color-red': calcDateExpired(item.verloopDatumAbbonement) }" v-text="item.achternaam"></p></md-table-cell>
        <md-table-cell ><p v-bind:class="{ 'color-red': calcDateExpired(item.verloopDatumAbbonement) }" v-text="item.verloopDatumAbbonement"></p></md-table-cell>
        <md-table-cell><span class="material-icons cursor-pointer" @click="setContractDone(item.id)">check_box_outline_blank</span></md-table-cell>
      </md-table-row>
    </md-table>
        </md-card-content>
    </md-card>
    </div> -->
  </div>

</div>
</template>



<script>
import {MDCRipple} from '@material/ripple';

    export default {
        components: {
        },

        data(){
          return{
            data: {},
            response: '',
            reminderData: {},
            contractData: {},
            reminderCount: 0,
            date: '',
            handtekening: '',
          }
        },

        mounted(){
          const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));
        },

        watch:{
          response(){
            if(this.response != ''){
              if(this.response == 1){
                  this.response = '';
                  this.refreshReminderData();
                  // this.refreshcontractData();
              }else{
                alert('Er is iets mis gegaan met opslaan.');
              }
            }
          },

          data(){
            this.reminderData = this.data[15];
            this.contractData = this.data[16];
            this.date = this.data[17];
            this.reminderCount = this.data[21];
          }
        },

        mounted(){
          axios.get('all-home-data')
          .then(response => this.data = response.data);



        },


        methods:{

          setActivePage(page, subPage){
            this.$emit('setActivePage', page, subPage);
          },


          calcDateExpired(date){
            if(date < this.date){
              return true;
            }else{
              return false;
            }
          },

          setContractDone(id){
            axios.post('change-contract-status', {'id': id})
            .then(response => this.response = response.data)
            .catch(error => this.response = error.data);
          },

          setDone(id){
            axios.post('change-reminder-status', {'id': id})
            .then(response => this.response = response.data)
            .catch(error => this.response = error.data);
          },

          refreshReminderData(){
            axios.get('home-refresh-reminders')
            .then(response => this.reminderData = response.data);
            this.refreshReminderCount();
          },

          refreshReminderCount(){
            axios.get('home-refresh-reminder-count')
            .then(response => this.reminderCount = response.data);
          },

          refreshcontractData(){
            axios.get('home-refresh-contracts')
            .then(response => this.contractData = response.data);
          },


        },
    }
</script>
