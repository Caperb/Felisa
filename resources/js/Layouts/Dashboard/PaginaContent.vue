<template>
  <div class="content margin-top-2">

    <md-steppers id="page-content-editor" md-alternative>
      <md-step id="first" md-label="Header content">
        <div class="input-wrapper ta-center pagina-content-editor">
          <md-card-header>
          <div class="md-title">Header aanpassen</div>
        </md-card-header>
        <md-field>
        <label>Header tekst</label>
        <md-textarea v-model="content.headerText"></md-textarea>
      </md-field>

    <md-field>
      <label>Header foto</label>
      <md-file v-model="content.headerFotoNaam" accept="image/*"  @md-change="handleFileUpload($event)"/>
    </md-field>

    <img :src="content.headerFoto" alt="headerFoto">

    <md-button class="md-raised md-primary margin-auto" @click='editContent()'>Bijwerken</md-button>

      </div>
    </md-step>

      <md-step id="second" md-label="About tekst">
        <div class="input-wrapper ta-center pagina-content-editor">

        <md-card-header>
          <div class="md-title">About aanpassen</div>
        </md-card-header>

          <md-field>
      <label>About titel</label>
      <md-input v-model="content.aboutTitel"></md-input>
    </md-field>

    <md-field>
      <label>About tekst</label>
      <md-textarea v-model="content.aboutTekst"></md-textarea>
    </md-field>

    <md-card-header>
      <div class="md-title">About en contact achtergrond kleur</div>
    </md-card-header>
      <input class="margin-top-2vh" type="color" v-model="content.cssKleur">




        </div>

        <div class="input-wrapper ta-center pagina-content-editor margin-top-2vh">
          <md-button class="md-raised md-primary margin-auto" @click='editContent()'>Bijwerken</md-button>
        </div>

      </md-step>

      <md-step id="third" md-label="About foto">
        <div class="input-wrapper ta-center pagina-content-editor">

        <md-card-header>
          <div class="md-title">About Foto</div>
        </md-card-header>

        <md-field>
          <label>About foto</label>
          <md-file v-model="content.aboutFotoNaam" accept="image/*"  @md-change="handleFileUpload2($event)"/>
        </md-field>

        <img :src="content.aboutFoto" class="aboutFoto" alt="headerFoto">

        </div>

        <div class="input-wrapper ta-center pagina-content-editor margin-top-2vh">
          <md-button class="md-raised md-primary margin-auto" @click='editContent()'>Bijwerken</md-button>
        </div>

      </md-step>


    </md-steppers>

    <md-dialog-alert
      :md-active.sync="showSavingDialog"
      md-content="We zijn bezig de nieuwe content op te slaan, dit kan even duren en de pagina zal niet reageren terwijl de content aangepast wordt."
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
      content: [],
      showSavingDialog: false,
      showSavedDialog: false,
      showErrorDialog: false,
      response: '',
    };
  },

  mounted() {
    axios
    .get('get-homepage-content')
    .then(response => this.content = response.data);
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

    editContent(){
      this.showSavingDialog = true;
      if (this.content.oudeAboutFotoNaam == this.content.aboutFotoNaam && this.content.oudeHeaderFotoNaam == this.content.headerFotoNaam) {
        axios.post('save-homepage-content-no-foto', {'headerText': this.content.headerText, 'aboutTekst': this.content.aboutTekst,
                                             'aboutTitel': this.content.aboutTitel, 'cssKleur': this.content.cssKleur})
        .then(response => this.response = response.data);
      }else {
        let formData = new FormData();

        formData.append('headerFoto', this.content.headerFoto);
        formData.append('headerFotoNaam', this.content.headerFotoNaam);
        formData.append('oudeHeaderFotoNaam', this.content.oudeHeaderFotoNaam);
        formData.append('aboutFoto', this.content.aboutFoto);
        formData.append('aboutFotoNaam', this.content.aboutFotoNaam);
        formData.append('oudeAboutFotoNaam', this.content.oudeAboutFotoNaam);
        formData.append('headerText', this.content.headerText);
        formData.append('aboutTekst', this.content.aboutTekst);
        formData.append('aboutTitel', this.content.aboutTitel);
        formData.append('cssKleur', this.content.cssKleur);

            axios.post( '/save-homepage-content',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            ).then(response => this.response = response.data);
      }

    },

    handleFileUpload(e){
      this.content.headerFotoNaam = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.content.headerFoto = e.target.result;
       };
    },

    handleFileUpload2(e){
      this.content.aboutFotoNaam = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.content.aboutFoto = e.target.result;
       };
    },
  },
};
</script>
