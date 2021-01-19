<template>
  <div class="wrapper">


    <img src="/images/logo-25.svg" class="home-logo" />

    <p class="md-display-2 md-medium-hide">Ticket aanmaken</p>


    <div class="md-layout md-gutter md-alignment-top-center">
      <div class="input-wrapper">

                <KlantSelecteren @klantGeselecteerd="klantGeselecteerd" @setActivePage="klantAanmaken"/>

        <md-field>
          <label for="employee">Gehlopen door</label>
          <md-select v-model="newReparatie.geholpenDoor">
          <md-option v-for="(user, index) in this.allUsers" :value="user.id" v-bind:key="index">{{user.name}}</md-option>
          </md-select>
        </md-field>


    <md-field>
      <label>Beschrijving</label>
      <md-textarea v-model="newReparatie.beschrijving" placeholder="Beschrijving probleem" md-autogrow type="text"></md-textarea>
    </md-field>

      <md-field>
          <label>Kosten</label>
          <md-icon>euro_symbol</md-icon>
          <md-input v-model="newReparatie.prijs" placeholder="Kosten reparatie" type="number">€</md-input>
        </md-field>

      </div>

    </div>


    <div class="back-button-bottom " @click="setPage('ticketAanmaken')">
      <md-icon >arrow_back</md-icon>
    </div>

   <div class="continue-button-bottom">
<OverzichtReparatieGegevens @reparatieAangemaakt="reparatieAangemaakt" :newReparatie="newReparatie" :geselecteerdeKlant="this.geselecteerdeKlant"/>
    </div>
</div>
</template>

<script>
  import KlantSelecteren from '@/Layouts/KlantSelecteren'
  import OverzichtReparatieGegevens from '@/Layouts/OverzichtReparatieGegevens'

    export default {
        components: {
          KlantSelecteren,
          OverzichtReparatieGegevens,
        },
            name: 'SwitchHueColors',
    data: () => ({
      boolean: true
    }),

        props:['allUsers'],

        data(){
          return{
            newReparatie: {'geholpenDoor': '',},
            geselecteerdeKlant: {},
          }
        },

        methods:{
          reparatieAangemaakt(info){
            this.$emit('reparatieAangemaakt', info);
          },

          klantGeselecteerd(klant){
            this.geselecteerdeKlant = klant;
          },

          klantAanmaken(){
            this.$emit('klantAanmaken');
          },

          setPage(value){
            this.$emit('setPage', value);
          },
        },
    }
</script>
