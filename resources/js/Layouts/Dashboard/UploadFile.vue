<template>
  <div>


    <div class="modal-background" v-if="modalVisible" @click="closeModal()">
    </div>

    <div class="upload-file-modal" v-if="modalVisible">

      <h2 class="close-modal-button cursor-pointer" @click="closeModal()">X</h2>
      <h2 class="input-titel text-align-left margin-left-1-5vw">Upload file</h2>

      <input class="modal-hidden-file-input" type="file" @change="addFile($event)"></input>
      <div class="modal-content-box upload-box">
        <span class="material-icons upload-file-icon">cloud_upload</span>
        <p>Drag and Drop je bestand</p>
        <p>of klik hier om</p>
        <p>tussen je bestanden te browsen</p>
      </div>

      <div class="row" style="height: 15%;">
      <div class="margin-auto" v-if="this.uploadedFile == ''">
      <p class="text-uploaded-file">No file uploaded</p>
      </div>
      <div class="margin-auto" v-else>
      <p class="text-uploaded-file display-flex"><span class="material-icons">check_circle</span>{{this.uploadedFile.name}}</p>
      <p class="text-uploaded-file">{{this.fileSize}}</p>
      </div>
    </div>

      <div class="row">
      <h2 class="margin-auto input-titel cursor-pointer" @click="uploadFile()">Bevestigen</h2>
    </div>

    </div>

  </div>
</template>

<script>

    export default {
        components: {
        },

        props: ['selectedKlant', 'modalVisible'],

        data(){
          return{
            response: '',
            uploadedFile: '',
            fileSize: 0,
          }
        },

        watch:{
          uploadedFile(){
            let fileSize = (this.uploadedFile.size/1024).toFixed(2);
            if(fileSize > 1024){
              this.fileSize = (fileSize/1024).toFixed(2) + ' MB';
            }else{
              this.fileSize = fileSize + ' KB';
            }
          },

          response(){
            console.log(this.response);
            if(this.response != ''){
            if(this.response == 1){
              this.$emit('closed');
              this.$emit('refreshContracts');
              this.response = '';
            } else if (this.response == 'Exists'){
              alert('Er bestaat al een bestand met deze naam.');
            }
            else{
              alert('Er is iets mis gegaan met opslaan.');
            }
          }
          },
        },

        methods:{
          closeModal(){
            this.$emit('closed');
          },

          addFile(e){
            this.uploadedFile = e.target.files[0];
          },

          uploadFile(){
            var formData = new FormData();
            formData.append("file", this.uploadedFile);
            formData.append("name", this.uploadedFile.name);
            formData.append("size", this.fileSize);
            formData.append("userID", this.selectedKlant.id);
            axios.post('upload-contract', formData, {
              headers: {
      'Content-Type': 'multipart/form-data'
      }
    }).then(response => this.response = response.data);

          },

          klantAanmaken(){
            this.$emit('klantAanmaken');
          },

          toggleValue(name, value){
            this[name] = value;
            if(name == 'modalVisible' && value == false){
              this.uploadedFile = '';
            }
          },
        },
    }
</script>
