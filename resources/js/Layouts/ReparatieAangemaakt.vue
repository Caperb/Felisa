<template>
  <div class="wrapper">

    <img src="/images/logo-25.svg" class="home-logo" />

    <p class="md-display-2 md-medium-hide">Ticket aangemaakt!</p>

    <div class="homespacer"></div>
    <div class="md-layout md-gutter md-alignment-center-center">
      <div class="md-layout-item">
        <md-button class="big-md-button" @click="setPage('home')">Homescherm</md-button>
      </div>

      <div class="md-layout-item md-medium-hide"></div>

      <div class="md-layout-item">
        <md-button class="big-md-button" @click="printBon()">Print bon</md-button>
      </div>
    </div>

    </div>
</template>

<script>

    export default {
        components: {
        },

        props:['info'],

        data(){
          return{
          }
        },

        methods:{
          setPage(value){
            this.$emit('setPage', value);
          },

          printBon(){
            let a = confirm('Pinnen?');

            if(a == true){
              axios({
                url: '/print-bon', //your url
                data: {
                  'id': this.info.id,
                  'geholpenDoor': this.info.order.geholpenDoor,
                  'prijs': this.info.order.prijs,
                  'type': this.info.type,
                  'merk': this.info.order.merk,
                  'model': this.info.order.model,
                  'betalingsType': 'Pinnen',
              },
                method: 'POST',
                responseType: 'blob', // important
              }).then((response) => {
                //Create a Blob from the PDF Stream
                const file = new Blob(
                [response.data],
                {type: 'application/pdf'});
                //Build a URL from the file
                const fileURL = URL.createObjectURL(file);
                //Open the URL on new Window
                window.open(fileURL);
              });
            }else{
              axios({
                url: '/print-bon', //your url
                data: {
                  'id': this.info.id,
                  'geholpenDoor': this.info.order.geholpenDoor,
                  'prijs': this.info.order.prijs,
                  'type': this.info.type,
                  'merk': this.info.order.merk,
                  'model': this.info.order.model,
                  'betalingsType': 'Contant',
              },
                method: 'POST',
                responseType: 'blob', // important
              }).then((response) => {
                //Create a Blob from the PDF Stream
                const file = new Blob(
                [response.data],
                {type: 'application/pdf'});
                //Build a URL from the file
                const fileURL = URL.createObjectURL(file);
                //Open the URL on new Window
                window.open(fileURL);
              });
            }
          },
        },
    }
</script>
