<template>
  <div class="wrapper">
    <img src="/images/logo-25.svg" class="home-logo" />

    <p class="md-display-2 md-medium-hide">Klant aangemaakt!</p>

    <div class="homespacer"></div>
    <div class="md-layout md-gutter md-alignment-center-center">
      <div class="md-layout-item">
        <md-button class="big-md-button" @click="setPage('home')">Homescherm</md-button>
      </div>

      <div class="md-layout-item md-medium-hide"></div>

      <div class="md-layout-item">
        <md-button class="big-md-button" @click="setPage('ticketAanmaken')">Ticket aanmaken</md-button>
      </div>
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
