<template>
  <div>
    <UploadFile @refreshContracts="refreshContracts()" @closed="toggleModal(false)" :modalVisible="modalVisible" :selectedKlant="selectedKlant"/>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>supervisor_account</md-icon>
        </div>
        <h3 class="md-title ta-right" v-if="this.selectedKlant != {}">
          Klant # {{ this.selectedKlant.id }} -
          {{ this.selectedKlant.voornaam }}
          {{ this.selectedKlant.achternaam }} bewerken
        </h3>
      </md-card-header>

      <md-card-content st>
        <md-steppers md-alternative>
          <!-- Algemene Info -->
          <md-step id="first" md-label="Klantgegevens">
            <div class="input-wrapper ta-center">
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <label>Voornaam</label>
                    <md-input
                      v-model="selectedKlant.voornaam"
                      type="text"
                    ></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 mdli-r">
                  <md-field>
                    <label for="tussenvoegsel">Tussenvoegsel</label>
                    <md-input
                      name="tussenvoegsel"
                      v-model="selectedKlant.tussenvoegsel"
                      type="text"
                    />
                  </md-field>
                </div>
              </div>

              <md-field>
                <label>Achternaam</label>
                <md-input
                  v-model="selectedKlant.achternaam"
                  type="text"
                ></md-input>
              </md-field>

              <md-field>
                <label>Emailadres </label>
                <md-input
                  v-model="selectedKlant.emailAdres"
                  type="email"
                ></md-input>
              </md-field>

              <md-field>
                <label>Telefoonnummer </label>
                <md-input
                  v-model="selectedKlant.telefoonNummer"
                  type="tel"
                ></md-input>
              </md-field>

              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <label for="postcode">Postcode</label>
                    <md-input
                      name="postcode"
                      v-model="selectedKlant.postcode"
                    />
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 mdli-r">
                  <md-field>
                    <label for="huisNummer">Huisnummer</label>
                    <md-input
                      name="huisNummer"
                      v-model="selectedKlant.huisNummer"
                      type="number"
                    />
                  </md-field>
                </div>
              </div>

              <md-field>
                <label for="type">Soort ID</label>
                <md-select
                  v-model="selectedKlant.soortID"
                  name="type"
                  id="type"
                >
                  <md-option value="Rijbewijs">Rijbewijs</md-option>
                  <md-option value="Paspoort">Paspoort</md-option>
                  <md-option value="Verblijfsvergunning"
                    >Verblijfsvergunning</md-option
                  >
                  <md-option value="ID kaart">ID kaart</md-option>
                </md-select>
              </md-field>

              <md-field>
                <label>ID Nummer</label>
                <md-input
                  v-model="selectedKlant.IDnummer"
                  type="number"
                ></md-input>
              </md-field>

              <md-field>
                <label>IBAN</label>
                <md-input v-model="selectedKlant.IBAN" type="text"></md-input>
              </md-field>

              <label for="dateofbirth">Geboortedatum</label>
              <md-datepicker
                name="dateofbirth"
                id="dateofbirth"
                v-model="selectedKlant.geboortedatum"
              />
            </div>
          </md-step>

          <!-- Device & Contractinformation info -->
          <md-step id="second" md-label="Telefoon &amp; Contract gegevens">
            <div class="input-wrapper ta-center">
              <md-field>
                <label>Merk</label>
                <md-input v-model="selectedKlant.merk" type="text"></md-input>
              </md-field>

              <md-field>
                <label>Model</label>
                <md-input v-model="selectedKlant.model" type="text"></md-input>
              </md-field>

              <label for="Aanschafdatum">Aanschafdatum</label>
              <md-datepicker
                name="Aanschafdatum"
                id="Aanschafdatum"
                v-model="selectedKlant.aanschafdatum"
              />

              <md-field>
                <label>Provider</label>
                <md-input
                  v-model="selectedKlant.provider"
                  type="text"
                ></md-input>
              </md-field>

              <md-field>
                <label for="type">Contract type</label>
                <md-select
                  v-model="selectedKlant.type"
                  name="type"
                  id="type"
                  required
                >
                  <md-option value="SIM-only">SIM-only</md-option>
                  <md-option value="Abbonement">Abbonement</md-option>
                  <md-option value="N.v.t.">N.v.t.</md-option>
                </md-select>
              </md-field>

              <label for="uitgeefDatumAbbonement">Start datum contract</label>
              <md-datepicker
                name="uitgeefDatumAbbonement"
                id="uitgeefDatumAbbonement"
                v-model="selectedKlant.uitgeefDatumAbbonement"
              />

              <md-field>
                <label for="Duration">Duur contract</label>
                <md-select
                  v-model="selectedKlant.duurAbbonement"
                  name="Duration"
                  id="Duration"
                  required
                >
                  <md-option value="Geen">Geen</md-option>
                  <md-option value="Maandelijks">Maandelijks</md-option>
                  <md-option value="1 jaar">1 Jaar</md-option>
                  <md-option value="2 jaar">2 Jaar</md-option>
                </md-select>
              </md-field>

              <label for="verloopDatumAbbonement">Einddatum contract</label>
              <md-datepicker
                name="verloopDatumAbbonement"
                id="verloopDatumAbbonement"
                v-model="selectedKlant.verloopDatumAbbonement"
              />

              <md-field>
                <label>Maandelijkse kosten</label>
                <md-icon>euro_symbol</md-icon>
                <md-input
                  v-model="selectedKlant.maandelijkseKosten"
                  placeholder="Maandelijkse kosten"
                  type="number"
                ></md-input>
              </md-field>

              <md-field>
                <label for="GSM">Afgesloten via GSM brielle?</label>
                <md-select
                  v-model="selectedKlant.duurAbbonement"
                  name="GSM"
                  id="GSM"
                  required
                >
                  <md-option value="Ja">Ja</md-option>
                  <md-option value="Nee">Nee</md-option>
                </md-select>
              </md-field>

              <md-button
                class="md-primary med-md-button"
                type="submit"
                @click="editKlant()"
                >Aanmaken</md-button
              >
            </div>
          </md-step>

          <!-- Contract info -->
          <md-step id="third" md-label="Telefoon &amp; Contract gegevens">
            <div class="input-wrapper ta-center">
              <md-table
                v-if="this.paginationData != 'fresh'"
                v-model="paginationData.data"
                md-sort="id"
                md-sort-order="desc"
                md-card
              >
                <md-table-toolbar>
                  <h1 class="md-title">Contracten</h1>
                  <div class="add-contract-button cursor-pointer">
                  <h2 class="md-title">Contracten</h2>
                  <span class="material-icons add-contract-icon" @click="toggleModal(true)">control_point</span>
                </div>
                </md-table-toolbar>

                <md-table-row slot="md-table-row" slot-scope="{ item }">
                  <md-table-cell md-label="id" md-numeric>{{
                    item.id
                  }}</md-table-cell>
                  <md-table-cell md-label="name" md-sort-by="name">{{
                    item.name
                  }}</md-table-cell>
                  <md-table-cell md-label="Email" md-sort-by="size">{{
                    item.size
                  }}</md-table-cell>
                  <md-table-cell md-label="Gender" md-sort-by="created_at">{{
                    item.created_at
                  }}</md-table-cell>
                  <md-table-cell md-label="Acties" class="display-flex">
                    <div
                      @click="downloadContract(contract.name)"
                      class="display-flex"
                    >
                      <span class="material-icons table-icon"
                        >system_update_alt</span
                      >
                    </div>
                    <div @click="deleteContract(contract)" class="display-flex">
                      <span class="material-icons table-icon">delete</span>
                    </div>
                  </md-table-cell>
                </md-table-row>
              </md-table>
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
import UploadFile from "@/Layouts/Dashboard/UploadFile";

export default {
  components: {
    UploadFile,
  },

  props: ['selectedKlant'],

  data() {
    return {
      paginationData: 'fresh',
      selectedPaginationPage: 1,
      response: "",
      modalVisible: false,
    };
  },

  mounted() {
    if (this.selectedKlant.soortID == null) {
      this.selectedKlant.soortID = "";
    }

    if (this.selectedKlant.contractType == null) {
      this.selectedKlant.contractType = "";
    }

    if (this.selectedKlant.duurAbbonement == null) {
      this.selectedKlant.duurAbbonement = "";
    }

    if (this.selectedKlant.afgeslotenViaOns == null) {
      this.selectedKlant.afgeslotenViaOns = "";
    }

    axios
      .post("all-contracts", { userID: this.selectedKlant.id })
      .then((response) => (this.paginationData = response.data));
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
    toggleModal(value){
      this.modalVisible = value;
    },

    refreshContracts() {
      axios
        .post("all-contracts", { userID: this.selectedKlant.id })
        .then((response) => (this.paginationData = response.data));
    },

    back() {
      this.$emit("back");
    },

    editKlant() {
      if (
        this.originalExpireDate != this.selectedKlant.verloopDatumAbbonement
      ) {
        this.selectedKlant.contractStatus = null;
      }

      axios
        .post("edit-klant", this.selectedKlant)
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },

    downloadContract(name) {
      axios({
        url:
          "/download-contract?userID=" +
          this.selectedKlant.id +
          "&name=" +
          name, //your url
        method: "POST",
        responseType: "blob", // important
      }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", name); //or any other extension
        document.body.appendChild(link);
        link.click();
      });
    },

    pageUp() {
      if (this.selectedPaginationPage < this.paginationData.last_page) {
        this.selectedPaginationPage = this.selectedPaginationPage + 1;
        this.refreshData();
      }
    },

    pageDown() {
      if (this.selectedPaginationPage > 1)
        this.selectedPaginationPage = this.selectedPaginationPage - 1;
      this.refreshData();
    },

    deleteContract(contract, index) {
      let c = confirm("Are you sure you want to delete ID: " + contract.id);

      if (c == true) {
        axios.post("delete-contract", {
          id: contract.id,
          userID: contract.userID,
          name: contract.name,
        });
        this.refreshData();
      }
    },

    refreshData() {
      axios
        .post("all-contracts", {
          userID: this.selectedKlant.id,
          page: this.selectedPaginationPage,
        })
        .then((response) => (this.paginationData = response.data));
    },
  },
};
</script>
