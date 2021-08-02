<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon><span class="material-icons">note_add</span></md-icon>
        </div>
        <h3 class="md-title ta-right margin-right-1vw">Nieuwe happy customer toevoegen</h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Happy customer info">
            <div class="input-wrapper ta-center dashboard-edit-container">

              <md-field>
                <label for="Type happy customer">Type happy customer</label>
                <md-select v-model="item.type" name="type" id="type" md-dense>
            <md-option value="tekst">Tekst</md-option>
            <md-option value="foto">Foto</md-option>
            </md-select>
        </md-field>

                  <md-field>
                    <label>Naam</label>
                    <md-input
                      v-model="item.naam"
                      placeholder="Naam"
                      type="text"
                    ></md-input>
                  </md-field>



              <md-field v-if="this.item.type == 'tekst'">
                <label>Tekst</label>
                <md-textarea
                  v-model="item.tekst"
                  placeholder="Tekst..."
                  type="text"
                  md-clearable='true'
                ></md-textarea>
              </md-field>

              <span v-if="this.item.type == 'foto'">
              <md-field>
                <label>Foto</label>
                <md-file @md-change="handleFileUpload($event)"/>
              </md-field>

              <div class="container-uploading-image-happy-customer">
                <img :src="this.item.foto" class="uploading-image"/>
              </div>
              </span>

              <md-button
              class="md-primary md-raised"
              type="submit"
              @click="addHappyCustomer()"
              >Aanmaken</md-button
              >

      </div>

          </md-step>


        </md-steppers>
      </md-card-content>
      <md-card-actions class="in-between">
        <md-button class="" @click="back()"
          ><md-icon>arrow_back</md-icon></md-button
        >
      </md-card-actions>
    </md-card>

  </div>
</template>

<script>
export default {
  components: {},

  props: ["activePage"],

  data() {
    return {
      item: {
        naam: '',
        tekst: '',
        foto: '',
        fotoNaam: '',
        type: '',
      },
      response: "",
    };
  },

  mounted() {

  },

  watch: {
    response() {
      if (this.response == 1) {
        this.$emit("back");
      } else {
        alert("Er is iets mis gegaan met opslaan.");
      }
    },
  },

  methods: {
    back() {
      this.$emit("back");
    },

    addHappyCustomer() {
        if (this.item.type == 'tekst') {

          axios
          .post('/add-happy-customer', {'naam': this.item.naam, 'tekst': this.item.tekst, 'type': this.item.type})
          .then((response) => (this.response = response.data))
          .catch((error) => (this.response = error.data));

        }else {

          let formData = new FormData();
          formData.append('foto', this.item.foto);
          formData.append('fotoNaam', this.item.fotoNaam);
          formData.append('type', this.item.type);
          formData.append('naam', this.item.naam);
          formData.append('tekst', this.item.tekst);

              axios.post( '/add-happy-customer-picture',
                  formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
              ).then((response) => (this.response = response.data))
              .catch((error) => (this.response = error.data));
        }
    },

    handleFileUpload(e){
      this.item.fotoNaam = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.item.foto = e.target.result;
       };
    },

  },
};
</script>
