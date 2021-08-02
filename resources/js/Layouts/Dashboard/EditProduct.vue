<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon><span class="material-icons">note_add</span></md-icon>
        </div>
        <h3 class="md-title ta-right margin-right-1vw">Product bijwerken</h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Product naam & beschrijving">
            <div class="input-wrapper ta-center">

                  <md-field>
                    <label>Naam</label>
                    <md-input
                      v-model="selectedProduct.naam"
                      placeholder="Naam"
                      type="text"
                    ></md-input>
                  </md-field>


              <md-field>
                <label>Beschrijving</label>
                <md-textarea
                  v-model="selectedProduct.beschrijving"
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
        <md-select v-model="selectedProduct.categorie" name="categorie" id="categorie">
          <md-option v-for="categorie in allCategories"  :key="categorie" :value="categorie.id">{{categorie.naam}}</md-option>
        </md-select>
      </md-field>

      <md-field v-if="selectedProduct.categorie != ''">
  <label for="sub categorie">sub Categorie</label>
  <md-select v-model="selectedProduct.subCategorie" name="sub categorie" id="sub categorie">
    <md-option value="none">Geen</md-option>
    <md-option v-for="categorie in allSubCategories"  :key="categorie" :value="categorie.id">{{categorie.naam}}</md-option>
  </md-select>
</md-field>

      <md-field>
       <label for="opties">Opties</label>
       <md-select v-model="selectedProduct.opties" name="opties" id="opties" multiple>
         <md-option v-for="optie in allOpties"  :key="optie" :value="optie.id">{{optie.naam}}</md-option>
       </md-select>
     </md-field>

            <md-field>
              <label>Prijs</label>
              <md-input
                v-model="selectedProduct.prijs"
                placeholder="Prijs"
                type="number"
              ></md-input>
            </md-field>

            <md-field>
              <label>Gewicht</label>
              <md-input
                v-model="selectedProduct.gewicht"
                placeholder="Gewicht"
                type="number"
              ></md-input>
            </md-field>

          </div>
            </md-step>

        <md-step id="third" md-label="Product foto">
            <div class="input-wrapper ta-center pagina-content-editor">

  <md-field>
    <label>Foto</label>
    <md-file @md-change="handleFileUpload($event)"/>
  </md-field>

  <div class="container-uploading-image">
    <img :src="this.selectedProduct.foto" class="uploading-image"/>
  </div>

  <md-button
    class="md-primary md-raised"
    type="submit"
    @click="editProduct()"
    >Bijwerken</md-button
  >

</div>
    </md-step>

    <md-step id="fourth" md-label="Product foto 2">
        <div class="input-wrapper ta-center pagina-content-editor">

<md-field>
<label>Foto 2</label>
<md-file @md-change="handleFileUpload2($event)"/>
</md-field>

<div class="container-uploading-image">
<img :src="this.selectedProduct.foto2" class="uploading-image"/>
</div>

<md-button
class="md-primary md-raised"
type="submit"
@click="editProduct()"
>Bijwerken</md-button
>

</div>
</md-step>

<md-step id="fifth" md-label="Product foto 3">
    <div class="input-wrapper ta-center pagina-content-editor">

<md-field>
<label>Foto 3</label>
<md-file @md-change="handleFileUpload3($event)"/>
</md-field>

<div class="container-uploading-image">
<img :src="this.selectedProduct.foto3" class="uploading-image"/>
</div>

<md-button
class="md-primary md-raised"
type="submit"
@click="editProduct()"
>Bijwerken</md-button
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

  props: ["activePage", 'selectedProduct'],

  data() {
    return {
      oudeFotoNaam: '',
      newFotoNaam: '',
      oudeFotoNaam2: '',
      newFotoNaam2: '',
      oudeFotoNaam3: '',
      newFotoNaam3: '',
      allOpties: [],
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

      axios
      .post('/get-subs', {id: this.selectedProduct.categorie})
      .then((response) => (this.allSubCategories = response.data));

      var str = this.selectedProduct.opties;
      var res = str.split(",");
      var newArray = [];
      var number = 0;

      res.forEach((item, i) => {
        number = parseInt(item);
        newArray.push(number);
      });

      this.selectedProduct.opties = newArray;

      this.oudeFotoNaam = this.selectedProduct.foto;
      this.newFotoNaam = this.selectedProduct.foto;

      this.oudeFotoNaam2 = this.selectedProduct.foto2;
      this.newFotoNaam2 = this.selectedProduct.foto2;

      this.oudeFotoNaam3 = this.selectedProduct.foto3;
      this.newFotoNaam3 = this.selectedProduct.foto3;

      if (this.selectedProduct.opties[0] != this.selectedProduct.opties[0]) {
          this.selectedProduct.opties.shift();
      }
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

    editProduct() {

        if (this.oudeFotoNaam == this.newFotoNaam && this.oudeFotoNaam2 == this.newFotoNaam2 && this.oudeFotoNaam3 == this.newFotoNaam3) {

          axios
          .post('edit-product', {foto: 'none', foto2: 'none', foto3: 'none', id: this.selectedProduct.id, naam: this.selectedProduct.naam, beschrijving: this.selectedProduct.beschrijving, categorie: this.selectedProduct.categorie,
                                  subCategorie: this.selectedProduct.subCategorie, opties: this.selectedProduct.opties, prijs: this.selectedProduct.prijs.replace('.', ','), gewicht: this.selectedProduct.gewicht.toString().replace(',', '.')})
          .then((response) => (this.response = response.data));

        }else if (this.oudeFotoNaam != this.newFotoNaam && this.oudeFotoNaam2 == this.newFotoNaam2 && this.oudeFotoNaam3 == this.newFotoNaam3) {

          this.oudeFotoNaam = this.oudeFotoNaam.replace("/product_fotos/", "");

          let formData = new FormData();
          formData.append('id', this.selectedProduct.id);
          formData.append('foto', this.selectedProduct.foto);
          formData.append('foto2', 'none');
          formData.append('foto3', 'none');
          formData.append('newFotoNaam', this.newFotoNaam);
          formData.append('oudeFotoNaam', this.oudeFotoNaam);
          formData.append('categorie', this.selectedProduct.categorie);
          formData.append('naam', this.selectedProduct.naam);
          formData.append('beschrijving', this.selectedProduct.beschrijving);
          formData.append('prijs', this.selectedProduct.prijs.replace('.', ','));
          formData.append('subCategorie', this.selectedProduct.subCategorie);
          formData.append('opties', this.selectedProduct.opties);
          formData.append('gewicht', this.selectedProduct.gewicht.toString().replace(',', '.'));

              axios.post( '/edit-product',
                  formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
              ).then((response) => (this.response = response.data))
              .catch((error) => (this.response = error.data));

        }else if (this.oudeFotoNaam == this.newFotoNaam && this.oudeFotoNaam2 != this.newFotoNaam2 && this.oudeFotoNaam3 == this.newFotoNaam3) {

          this.oudeFotoNaam2 = this.oudeFotoNaam2.replace("/product_fotos/", "");

          let formData = new FormData();
          formData.append('id', this.selectedProduct.id);
          formData.append('foto', 'none');
          formData.append('foto2', this.selectedProduct.foto2);
          formData.append('foto3', 'none');
          formData.append('newFotoNaam2', this.newFotoNaam2);
          formData.append('oudeFotoNaam2', this.oudeFotoNaam2);
          formData.append('categorie', this.selectedProduct.categorie);
          formData.append('naam', this.selectedProduct.naam);
          formData.append('beschrijving', this.selectedProduct.beschrijving);
          formData.append('prijs', this.selectedProduct.prijs.replace('.', ','));
          formData.append('subCategorie', this.selectedProduct.subCategorie);
          formData.append('opties', this.selectedProduct.opties);
          formData.append('gewicht', this.selectedProduct.gewicht.toString().replace(',', '.'));

              axios.post( '/edit-product',
                  formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
              ).then((response) => (this.response = response.data))
              .catch((error) => (this.response = error.data));

        }else if (this.oudeFotoNaam == this.newFotoNaam && this.oudeFotoNaam2 == this.newFotoNaam2 && this.oudeFotoNaam3 != this.newFotoNaam3) {

          this.oudeFotoNaam3 = this.oudeFotoNaam3.replace("/product_fotos/", "");

          let formData = new FormData();
          formData.append('id', this.selectedProduct.id);
          formData.append('foto', 'none');
          formData.append('foto2', 'none');
          formData.append('foto3', this.selectedProduct.foto3);
          formData.append('newFotoNaam3', this.newFotoNaam3);
          formData.append('oudeFotoNaam3', this.oudeFotoNaam3);
          formData.append('categorie', this.selectedProduct.categorie);
          formData.append('naam', this.selectedProduct.naam);
          formData.append('beschrijving', this.selectedProduct.beschrijving);
          formData.append('prijs', this.selectedProduct.prijs.replace('.', ','));
          formData.append('subCategorie', this.selectedProduct.subCategorie);
          formData.append('opties', this.selectedProduct.opties);
          formData.append('gewicht', this.selectedProduct.gewicht.toString().replace(',', '.'));

              axios.post( '/edit-product',
                  formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
              ).then((response) => (this.response = response.data))
              .catch((error) => (this.response = error.data));

        }else if (this.oudeFotoNaam != this.newFotoNaam && this.oudeFotoNaam2 != this.newFotoNaam2 && this.oudeFotoNaam3 == this.newFotoNaam3) {

          this.oudeFotoNaam = this.oudeFotoNaam.replace("/product_fotos/", "");
          this.oudeFotoNaam2 = this.oudeFotoNaam2.replace("/product_fotos/", "");

          let formData = new FormData();
          formData.append('id', this.selectedProduct.id);
          formData.append('foto', this.selectedProduct.foto);
          formData.append('foto2', this.selectedProduct.foto2);
          formData.append('foto3', 'none');
          formData.append('newFotoNaam', this.newFotoNaam);
          formData.append('oudeFotoNaam', this.oudeFotoNaam);
          formData.append('newFotoNaam2', this.newFotoNaam2);
          formData.append('oudeFotoNaam2', this.oudeFotoNaam2);
          formData.append('categorie', this.selectedProduct.categorie);
          formData.append('naam', this.selectedProduct.naam);
          formData.append('beschrijving', this.selectedProduct.beschrijving);
          formData.append('prijs', this.selectedProduct.prijs.replace('.', ','));
          formData.append('subCategorie', this.selectedProduct.subCategorie);
          formData.append('opties', this.selectedProduct.opties);
          formData.append('gewicht', this.selectedProduct.gewicht.toString().replace(',', '.'));

              axios.post( '/edit-product',
                  formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
              ).then((response) => (this.response = response.data))
              .catch((error) => (this.response = error.data));

        }else if (this.oudeFotoNaam != this.newFotoNaam && this.oudeFotoNaam2 == this.newFotoNaam2 && this.oudeFotoNaam3 != this.newFotoNaam3) {

          this.oudeFotoNaam = this.oudeFotoNaam.replace("/product_fotos/", "");
          this.oudeFotoNaam3 = this.oudeFotoNaam3.replace("/product_fotos/", "");

          let formData = new FormData();
          formData.append('id', this.selectedProduct.id);
          formData.append('foto', this.selectedProduct.foto);
          formData.append('foto2', 'none');
          formData.append('foto3', this.selectedProduct.foto3);
          formData.append('newFotoNaam', this.newFotoNaam);
          formData.append('oudeFotoNaam', this.oudeFotoNaam);
          formData.append('newFotoNaam3', this.newFotoNaam3);
          formData.append('oudeFotoNaam3', this.oudeFotoNaam3);
          formData.append('categorie', this.selectedProduct.categorie);
          formData.append('naam', this.selectedProduct.naam);
          formData.append('beschrijving', this.selectedProduct.beschrijving);
          formData.append('prijs', this.selectedProduct.prijs.replace('.', ','));
          formData.append('subCategorie', this.selectedProduct.subCategorie);
          formData.append('opties', this.selectedProduct.opties);
          formData.append('gewicht', this.selectedProduct.gewicht.toString().replace(',', '.'));

              axios.post( '/edit-product',
                  formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
              ).then((response) => (this.response = response.data))
              .catch((error) => (this.response = error.data));

        }else if (this.oudeFotoNaam == this.newFotoNaam && this.oudeFotoNaam2 != this.newFotoNaam2 && this.oudeFotoNaam3 != this.newFotoNaam3) {

          this.oudeFotoNaam2 = this.oudeFotoNaam2.replace("/product_fotos/", "");
          this.oudeFotoNaam3 = this.oudeFotoNaam3.replace("/product_fotos/", "");

          let formData = new FormData();
          formData.append('id', this.selectedProduct.id);
          formData.append('foto', 'none');
          formData.append('foto2', this.selectedProduct.foto2);
          formData.append('foto3', this.selectedProduct.foto3);
          formData.append('newFotoNaam2', this.newFotoNaam2);
          formData.append('oudeFotoNaam2', this.oudeFotoNaam2);
          formData.append('newFotoNaam3', this.newFotoNaam3);
          formData.append('oudeFotoNaam3', this.oudeFotoNaam3);
          formData.append('categorie', this.selectedProduct.categorie);
          formData.append('naam', this.selectedProduct.naam);
          formData.append('beschrijving', this.selectedProduct.beschrijving);
          formData.append('prijs', this.selectedProduct.prijs.replace('.', ','));
          formData.append('subCategorie', this.selectedProduct.subCategorie);
          formData.append('opties', this.selectedProduct.opties);
          formData.append('gewicht', this.selectedProduct.gewicht.toString().replace(',', '.'));

              axios.post( '/edit-product',
                  formData,
                  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
                }
              ).then((response) => (this.response = response.data))
              .catch((error) => (this.response = error.data));

        }else {

          this.oudeFotoNaam = this.oudeFotoNaam.replace("/product_fotos/", "");
          this.oudeFotoNaam2 = this.oudeFotoNaam2.replace("/product_fotos/", "");
          this.oudeFotoNaam3 = this.oudeFotoNaam3.replace("/product_fotos/", "");

          let formData = new FormData();
          formData.append('id', this.selectedProduct.id);
          formData.append('foto', this.selectedProduct.foto);
          formData.append('foto2', this.selectedProduct.foto2);
          formData.append('foto3', this.selectedProduct.foto3);
          formData.append('newFotoNaam', this.newFotoNaam);
          formData.append('oudeFotoNaam', this.oudeFotoNaam);
          formData.append('newFotoNaam2', this.newFotoNaam2);
          formData.append('oudeFotoNaam2', this.oudeFotoNaam2);
          formData.append('newFotoNaam3', this.newFotoNaam3);
          formData.append('oudeFotoNaam3', this.oudeFotoNaam3);
          formData.append('categorie', this.selectedProduct.categorie);
          formData.append('naam', this.selectedProduct.naam);
          formData.append('beschrijving', this.selectedProduct.beschrijving);
          formData.append('prijs', this.selectedProduct.prijs.replace('.', ','));
          formData.append('subCategorie', this.selectedProduct.subCategorie);
          formData.append('opties', this.selectedProduct.opties);
          formData.append('gewicht', this.selectedProduct.gewicht.toString().replace(',', '.'));

              axios.post( '/edit-product',
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
      this.newFotoNaam = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.selectedProduct.foto = e.target.result;
       };
    },

    handleFileUpload2(e){
      this.newFotoNaam2 = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.selectedProduct.foto2 = e.target.result;
       };
    },

    handleFileUpload3(e){
      this.newFotoNaam3 = e[0].name;
      const image = e[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
      this.selectedProduct.foto3 = e.target.result;
       };
    },

  },
};
</script>
