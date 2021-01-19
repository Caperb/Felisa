<template>
  <div class="wrapper">

    <img src="/images/logo-25.svg" class="home-logo" />

    <p class="md-display-2 md-medium-hide">Wat voor ticket wil je aanmaken?</p>

        <div class="homespacer"></div>
    <div class="md-layout md-gutter md-alignment-center-center">
      <div class="md-layout-item">
        <md-button class="big-md-button" @click="setPage('reparatieAanmaken')">Ticket</md-button>
      </div>

      <div class="md-layout-item md-medium-hide"></div>

      <div class="md-layout-item">
        <md-button class="big-md-button" @click="setPage('aanvraagAanmaken')">Aankoop</md-button>
      </div>
    </div>

    <div class="back-button-bottom" @click="setPage('home')">
      <md-icon >arrow_back</md-icon>
    </div>


    </div>
</template>

<script>

    export default {
        components: {
        },

        data(){
          return{
          }
        },

        methods:{

          setPage(value){
            this.$emit('setPage', value);
          },
        },
    }
</script>
