<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon><span class="material-icons">note_add</span></md-icon>
        </div>
        <h3 class="md-title ta-right margin-right-1vw">Nieuw product toevoegen</h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Product naam & beschrijving">
            <div class="input-wrapper ta-center">

                  <md-field>
                    <label>Naam</label>
                    <md-input
                      v-model="item.naam"
                      placeholder="Naam"
                      type="text"
                    ></md-input>
                  </md-field>


              <md-field>
                <label>Beschrijving</label>
                <md-textarea
                  v-model="item.beschrijving"
                  placeholder="Beschrijving"
                  type="text"
                  md-clearable='true'
                ></md-textarea>
              </md-field>

      </div>

          </md-step>

          <md-step id="second" md-label="Product gegevens">
              <div class="input-wrapper ta-center">

            <md-field>
        <label for="categorie">Categorie</label>
        <md-select v-model="selectedCategorie" name="categorie" id="categorie">
          <md-option v-for="categorie in allCategories"  :key="categorie" :value="categorie.id">{{categorie.naam}}</md-option>
        </md-select>
      </md-field>

      <md-field v-if="this.selectedCategorie != ''">
  <label for="sub categorie">sub Categorie</label>
  <md-select v-model="item.selectedSubCategorie" name="sub categorie" id="sub categorie">
    <md-option value="none">Geen</md-option>
    <md-option v-for="categorie in allSubCategories"  :key="categorie" :value="categorie.id">{{categorie.naam}}</md-option>
  </md-select>
</md-field>

      <md-field>
       <label for="opties">Opties</label>
       <md-select v-model="item.selectedOpties" name="opties" id="opties" multiple>
         <md-option v-for="optie in allOpties"  :key="optie" :value="optie.id">{{optie.naam}}</md-option>
       </md-select>
     </md-field>

            <md-field>
              <label>Prijs</label>
              <md-input
                v-model="item.prijs"
                placeholder="Prijs"
                type="number"
              ></md-input>
            </md-field>

            <md-field>
              <label>Gewicht</label>
              <md-input
                v-model="item.gewicht"
                placeholder="Gewicht"
                type="number"
              ></md-input>
            </md-field>

          </div>
            </md-step>

        <md-step id="third" md-label="Product foto">
            <div class="input-wrapper ta-center dashboard-edit-container">

  <md-field>
    <label>Foto</label>
    <md-file @md-change="handleFileUpload($event)"/>
  </md-field>

  <div class="container-uploading-image">
    <img :src="this.item.foto" class="uploading-image"/>
  </div>

  <md-button
    class="md-primary md-raised"
    type="submit"
    @click="addProduct()"
    >Aanmaken</md-button
  >

</div>
    </md-step>

    <md-step id="fourth" md-label="Product foto 2">
        <div class="input-wrapper ta-center dashboard-edit-container">

<md-field>
<label>Foto</label>
<md-file @md-change="handleFileUpload2($event)"/>
</md-field>

<div class="container-uploading-image">
<img :src="this.item.foto2" class="uploading-image"/>
</div>

<md-button
class="md-primary md-raised"
type="submit"
@click="addProduct()"
>Aanmaken</md-button
>

</div>
</md-step>

<md-step id="fifth" md-label="Product foto 3">
    <div class="input-wrapper ta-center dashboard-edit-container">

<md-field>
<label>Foto</label>
<md-file @md-change="handleFileUpload3($event)"/>
</md-field>

<div class="container-uploading-image">
<img :src="this.item.foto3" class="uploading-image"/>
</div>

<md-button
class="md-primary md-raised"
type="submit"
@click="addProduct()"
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
        naam: "",
        beschrijving: "",
        prijs: "",
        gewicht: undefined,
        foto: '',
        fotoNaam: '',
        foto2: '',
        fotoNaam2: '',
        foto3: '',
        fotoNaam3: '',
        selectedSubCategorie: '',
        selectedOpties: [],
      },
      allOpties: [],
      selectedCategorie: '',
      allCategories: [],
      allSubCategories: [],
      response: "",
    };
  },

  mounted() {

      axios
      .post('/all-main-categories')
      .then((response) => (this.allCategories = response.data));

      axios
      .post('/all-opties')
      .then((response) => (this.allOpties = response.data));

  },

  watch: {
    response() {
      if (this.response == 1) {
        this.$emit("back");
      } else {
        alert("Er is iets mis gegaan met opslaan.");
      }
    },

    selectedCategorie(){
      axios
      .post('/get-subs', {id: this.selectedCategorie})
      .then((response) => (this.allSubCategories = response.data));
    },
  },

  methods: {
    back() {
      this.$emit("back");
    },

    addProduct() {
        let formData = new FormData();

        formData.append('foto', this.item.foto);
        formData.append('fotoNaam', this.item.fotoNaam);
        formData.append('foto2', this.item.foto2);
        formData.append('fotoNaam2', this.item.fotoNaam2);
        formData.append('foto3', this.item.foto3);
        formData.append('fotoNaam3', this.item.fotoNaam3);
        formData.append('selectedCategorie', this.selectedCategorie);
        formData.append('naam', this.item.naam);
        formData.append('beschrijving', this.item.beschrijving);
        formData.append('prijs', this.item.prijs.replace('.', ','));
        formData.append('selectedSubCategorie', this.item.selectedSubCategorie);
        formData.append('selectedOpties', this.item.selectedOpties);
        formData.append('gewicht', this.item.gewicht.replace(',', '.'));

            axios.post( '/add-product',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            ).then((response) => (this.response = response.data))
            .catch((error) => (this.response = error.data));
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

    handleFileUpload2(e){
      this.item.fotoNaam2 = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.item.foto2 = e.target.result;
       };
    },

    handleFileUpload3(e){
      this.item.fotoNaam3 = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.item.foto3 = e.target.result;
       };
    },

  },
};
</script>
