<template>
<div>

   <!-- HEADER -->
   <md-content :md-tag="'header'">
   <md-toolbar class="md-accent" md-elevation="1">
      <h3 class="md-title" style="flex: 1">Title</h3>
      <md-button :href="'#voordelen'">Voordelen</md-button>
      <md-button :href="'#contact'">Contact</md-button>
      <md-button @click="newPayment()">Shop</md-button>
      <md-button>link</md-button>
      <md-button>link</md-button>
    </md-toolbar>
  </md-content>
   <!-- HERO IMAGE  -->

<md-content :md-tag="'section'" id="hero">
  <img src="https://picsum.photos/1920/1080"></img>
</md-content>

   <!-- USP/ VOORDELELEN OPSOMMING -->
   <md-content :md-tag="'section'" id="voordelen">
    <div class="md-layout md-gutter">
        <div class="md-layout-item">Voordeel1</div>
        <div class="md-layout-item">Voordeel2</div>
    </div>
  </md-content>

   <!-- CALLTOACTION / FORM -->
   <md-content :md-tag="'section'" id="contact">
    <div class="md-layout md-gutter">
        <div class="md-layout-item">
          <md-field>
            <label>Textarea</label>
            <md-textarea v-model="textarea"></md-textarea>
          </md-field>
        </div>
        <div class="md-layout-item">
          <md-field>
            <label>Naam</label>
            <md-input v-model="naam"></md-input>
            <span class="md-helper-text">Naam</span>
          </md-field>

          <md-field>
            <label>Email</label>
            <md-input v-model="email"></md-input>
            <span class="md-helper-text">Email</span>
          </md-field>

          <md-button class="md-primary" @click="sendMail">Submit</md-button>
        </div>
    </div>
  </md-content>
   <!-- FOOTER -->


     <md-content :md-tag="'footer'">Footer</md-content>

    </div>
</template>

<script>

    export default {
        components: {
        },

        data() {
            return {
              textarea: '',
              naam: '',
              email: '',
            }
        },

        methods: {
          sendMail(){
            axios.post('/send-mail');
          },

          newPayment(){
            axios.post('new-payment');
          },
        }
    }
</script>
