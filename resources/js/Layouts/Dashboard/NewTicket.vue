<template>
  <div>


    <div class="modal-background cursor-pointer" v-if="modalVisible" @click="toggleValue('modalVisible', false)">
    </div>

    <div class="create-ticket-modal" v-if="modalVisible">

      <md-button @click="toggleValue('modalVisible', false)" class="close-modal-button"><md-icon  >close</md-icon> </md-button>
      <p class="md-title ta-center ma-t-70">Nieuw ticket aanmaken</p>
      <div class="modal-content">

      <div class="text-align-left">
        <md-field>
        <label for="type">Soort ticket</label>
        <md-select v-model="selectedType" name="type" id="type">
          <md-option value="Repair">Reparatie</md-option>
          <md-option value="Order">Bestelling</md-option>
        </md-select>
        </md-field>
      </div>

      <md-button @click="switchPage()">Volgende</md-button>

    </div>
    </div>

<md-button class="md-icon-button md-raised md-primary" @click="toggleValue('modalVisible', true)"><md-icon>add</md-icon></md-button>
    </div>
</template>

<script>

    export default {
        components: {
        },

        props:['textbox', 'toggleAddTicket'],

        data(){
          return{
            modalVisible: false,
            selectedType: 'Repair',
          }
        },

        mounted(){
            this.modalVisible = this.toggleAddTicket;
        },


        methods:{

          switchPage(){
            this.$emit(this.selectedType);
            this.modalVisible = false;
          },

          toggleValue(name, value){
            if(name == 'modalVisible'){
              this.type = 'search';
            }
            this[name] = value;
          },
        },
    }
</script>
