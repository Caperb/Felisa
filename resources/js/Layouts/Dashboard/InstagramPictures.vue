<template>
  <div class="content margin-top-2">

    <md-steppers id="page-content-editor" md-alternative>
      <md-step id="first" md-label="Instagram foto's">
        <div class="input-wrapper ta-center pagina-content-editor">

          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-33 margin-bottom-2vh" v-for="instagramPicture in this.instagramPictures"  :key="instagramPicture">
              <img :src="instagramPicture" alt="">
            </div>
          </div>

    <md-button class="md-raised md-primary margin-auto" @click='refreshInstagram()'>Refresh</md-button>
    <md-button class="md-raised md-primary margin-auto" @click='saveNewPictures()'>Save</md-button>
      </div>
    </md-step>

    </md-steppers>

    <md-dialog-alert
      :md-active.sync="showWorkingOnDialog"
      md-content="We zijn bezig de nieuwe foto's op te halen. Dit kan een minuut of 2 duren."
      md-confirm-text="Okay!" />

    <md-dialog-alert
      :md-active.sync="showSavingDialog"
      md-content="We zijn bezig de nieuwe foto's op te slaan, dit kan even duren en de pagina zal niet reageren terwijl de content aangepast wordt."
      md-confirm-text="Okay!" />

    <md-dialog-alert
      :md-active.sync="showSavedDialog"
      md-content="De nieuwe content is opgeslagen."
      md-confirm-text="Okay!" />

    <md-dialog-alert
      :md-active.sync="showErrorDialog"
      md-content="Er is iets fout gegaan. Als dit blijft gebeuren stuur dan een email naar casperbosma@gmail.com met de details."
      md-confirm-text="Okay" />

  </div>
</template>

<script>

export default {
  components: {
  },

  props:['selectedSubPage'],

  data() {
    return {
      instagramPictures: [],
      showWorkingOnDialog: false,
      showSavingDialog: false,
      showErrorDialog: false,
      showSavedDialog: false,
      response: '',
    };
  },

  mounted() {
    axios
    .get('get-instagram-pictures')
    .then(response => this.instagramPictures = response.data);
  },

  watch: {
    response(){
      if (this.response == 'saved') {
        this.showSavedDialog = true;
      }else {
        this.showErrorDialog = true;
      }
    }
  },

  methods: {
    changeValue(name, value, product) {
      this[name] = value;
    },

    saveNewPictures(){
      this.showSavingDialog = true;

      axios
      .post('save-new-instagram-pictures', {'foto1': this.instagramPictures[0], 'foto2': this.instagramPictures[1],
      'foto3': this.instagramPictures[2], 'foto4': this.instagramPictures[3], 'foto5': this.instagramPictures[4],
      'foto6': this.instagramPictures[5]})
      .then(response => this.response = response.data);
    },

    refreshInstagram(){
      this.showWorkingOnDialog = true;

      axios
      .get('get-new-instagram-pictures')
      .then(response => this.instagramPictures = response.data);
    },
  },
};
</script>
