<template>
  <div>


    <div class="modal-background cursor-pointer" v-if="modalVisible" @click="toggleValue('modalVisible', false)">
    </div>

    <div class="modal md-elevation-20" v-if="modalVisible">

      <!-- <p class="close-modal-button cursor-pointer" @click="toggleValue('modalVisible', false)">X</p> -->
      <p class="nomargin" @click="toggleValue('modalVisible', false)"><md-icon class="close-modal-button">close</md-icon></p>
      <p class="md-title">Overzicht gegevens</p>

      <div class="modal-content-box">

        <div class="input-wrapper">

      <md-field>
          <label>Naam</label>
          <md-input v-model="this.geselecteerdeKlant.voornaam + ' ' + this.geselecteerdeKlant.achternaam" readonly ></md-input>
      </md-field>

    <md-field>
      <label>Beschrijving</label>
      <md-textarea v-model="newReparatie.beschrijving" md-autogrow readonly ></md-textarea>
    </md-field>

    <md-field>
      <label>Kosten reparatie</label>
      <md-icon>euro_symbol</md-icon>
      <md-input v-model="newReparatie.prijs"></md-input>
    </md-field>

          <div class="row">
          <p class="md-subheading" style="margin-top:p8%;">Handtekening</p>
          </div>
          <VueSignaturePad class="reparatieOverzichtHandtekening" ref="signaturePad" />
      <div>
        <!-- <button @click="saveSign">Save</button> -->

      <md-button class="md-icon-button handtekening-undo-button md-primary" @click="undoSign">
        <md-icon>undo</md-icon>
      </md-button>
      </div>
        </div>

    </div>
    <div class="row d-contents">
    <md-button class="md-primary med-md-button"  @click="reparatieAanmaken()">Bevestigen</md-button>
  </div>
  </div>

    <div class="continue-button-bottom" @click="toggleValue('modalVisible', 'true')">
      <md-button class="md-primary med-md-button"  type="submit">Aanmaken</md-button>
    </div>
  </div>
</template>

<script>

    export default {
        components: {
        },

        props: ['newReparatie', 'geselecteerdeKlant'],

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
              this.$emit('reparatieAangemaakt', {'type': 'Reparatie', 'id': this.response, 'geselecteerdeKlant': this.geselecteerdeKlant, 'order': this.newReparatie});
            }
          },
        },

        methods:{

          undoSign() {
            this.$refs.signaturePad.undoSignature();
          },

          reparatieAanmaken(){

            const { isEmpty, data } = this.$refs.signaturePad.saveSignature();

            axios.post('reparatie-aanmaken', {
              'handtekening': data,
              'merk': this.newReparatie.merk,
              'model': this.newReparatie.model,
              'provider': this.newReparatie.provider,
              'eerderGerepareerd': this.newReparatie.eerderGerepareerd,
              'schades': this.newReparatie.schade,
              'beschrijving': this.newReparatie.beschrijving,
              'kosten': this.newReparatie.prijs,
              'userID': this.newReparatie.geholpenDoor,
              'klantID': this.geselecteerdeKlant.id,
            })
            .then(response => this.response = response.data)
            .catch(error => this.response = 'error');
          },

          setPage(page){

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
