<template>
  <div>


    <div class="modal-background" v-if="modalVisible" @click="toggleValue('modalVisible', false)">
    </div>

    <div class="modal md-elevation-20" v-if="modalVisible">

      <h2 class="close-modal-button cursor-pointer" @click="toggleValue('modalVisible', false)">X</h2>
      <p class="md-title">Overzicht gegevens</p>

      <div class="modal-content-box" >

    <div class="input-wrapper">
      <md-field>
          <label>Naam</label>
          <md-input v-model="this.geselecteerdeKlant.voornaam + ' ' + this.geselecteerdeKlant.achternaam" readonly ></md-input>
      </md-field>

        <md-field v-if="this.orderType == 'tell'">
          <label for="contract">Contract type</label>
          <md-input v-model="newOrder.contractType"  readonly></md-input>
        </md-field>

      <md-field v-if="this.orderType == 'tell'">
          <label>Merk</label>
          <md-input v-model="newOrder.merk" readonly></md-input>
      </md-field>

      <md-field v-if="this.orderType == 'tell'">
          <label>Model</label>
          <md-input v-model="newOrder.model" readonly></md-input>
        </md-field>

      <md-field v-if="this.orderType == 'tell'">
          <label>Provider</label>
          <md-input v-model="newOrder.provider" readonly></md-input>
        </md-field>

      <md-field v-if="this.orderType == 'tell'">
          <label>Kosten reparatie</label>
          <md-icon>euro_symbol</md-icon>
          <md-input v-model="newOrder.prijs" readonly></md-input>
         </md-field>


        <h2 class="md-subheading text-align-left">Handtekening</h2>
        <VueSignaturePad class="reparatieOverzichtHandtekening" ref="signaturePad" />
    <div>
      <md-button class="md-icon-button handtekening-undo-button md-primary" @click="undoSign">
        <md-icon>undo</md-icon>
      </md-button>
    </div>

    <md-table v-if="this.aantalExtraArtikelen > 0" v-model="this.extraArtikelen" md-card md-fixed-header>


        <md-table-row slot="md-table-row">
          <md-table-head class="md-sortable" md-label="ID" md-sort-by="ticket.id" md-numeric >ID</md-table-head>
          <md-table-head class="md-sortable" md-label="Naam" md-sort-by="ticket.voornaam"  >Naam</md-table-head>
          <md-table-head class="md-sortable" md-label="Type" md-sort-by="ticket.type" >Prijs</md-table-head>
        </md-table-row>


        <md-table-row slot="md-table-row" slot-scope="{ item }">
          <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ extraArtikelen.indexOf(item) }}</md-table-cell>
          <md-table-cell md-label="Naam" md-sort-by="voornaam" md-numeric>{{ item.naam }}</md-table-cell>
          <md-table-cell md-label="Type" md-sort-by="type" md-numeric>{{ item.prijs }}</md-table-cell>
        </md-table-row>
      </md-table>

        </div>
      </div>
    <div class="row d-contents">
    <md-button class="md-primary med-md-button"  @click="aanvraagAanmaken()">Bevestigen</md-button>
  </div>
    </div>

    <!-- <div class="home-button cursor-pointer" @click="toggleValue('modalVisible', 'true')">
      <h2>Aanmaken</h2>
    </div> -->

    <div class="continue-button-bottom" @click="toggleValue('modalVisible', 'true')">
      <md-button class="md-primary med-md-button"  type="submit">Aanmaken</md-button>
    </div>
  </div>
</template>

<script>

    export default {
        components: {
        },

        props: ['geselecteerdeKlant', 'newOrder', 'aantalExtraArtikelen', 'extraArtikelen', 'orderType'],

        data(){
          return{
            modalVisible: false,
            response: '',
          }
        },

        watch:{
          response(){
            if(this.response == 'error'){
                alert('Er is iets mis gegaan met opslaan.');
            }else{
                this.$emit('aanvraagAangemaakt', {'type': 'Aanvraag', 'id': this.response, 'geselecteerdeKlant': this.geselecteerdeKlant, 'order': this.newOrder});
            }
          },
        },

        methods:{

          undoSign() {
            this.$refs.signaturePad.undoSignature();
          },

          aanvraagAanmaken(){
            const { isEmpty, data } = this.$refs.signaturePad.saveSignature();


              axios.post('aanvraag-aanmaken', {
                'handtekening': data,
                'klantID': this.geselecteerdeKlant.id,
                'userID': this.newOrder.geholpenDoor,
                'merk': this.newOrder.merk,
                'model': this.newOrder.model,
                'prijs': this.newOrder.prijs,
                'provider': this.newOrder.provider,
                'contractType': this.newOrder.contractType,
                'extraArtikelen': this.extraArtikelen,
              })
              .then(response => this.response = response.data)
              .catch(error => this.response = 'error');



          },

          klantAanmaken(){
            this.$emit('klantAanmaken');
          },

          toggleValue(name, value){
            this[name] = value;
          },
        },
    }
</script>
