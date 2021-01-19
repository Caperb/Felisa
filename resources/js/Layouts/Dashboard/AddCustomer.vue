<template>
  <div>
    <md-card class="md-accent" md-with-hover>
      <md-card-header>
        <div class="card-icon">
          <md-icon>supervisor_account</md-icon>
        </div>
        <h3 class="md-title ta-right">Nieuwe klant aanmaken</h3>
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
                      v-model="newKlant.voornaam"
                      placeholder="Voornaam"
                      type="text"
                    ></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 mdli-r">
                  <md-field>
                    <label for="tussenvoegsel">Tussenvoegsel</label>
                    <md-input
                      name="tussenvoegsel"
                      placeholder="Tussenvoegsel"
                      v-model="newKlant.tussenvoegsel"
                      type="text"
                    />
                  </md-field>
                </div>
              </div>

              <md-field>
                <label>Achternaam</label>
                <md-input
                  v-model="newKlant.achternaam"
                  placeholder="Achternaam"
                  type="text"
                ></md-input>
              </md-field>

              <md-field>
                <label>Emailadres </label>
                <md-input
                  v-model="newKlant.emailAdres"
                  placeholder="Emailadres"
                  type="email"
                ></md-input>
              </md-field>

              <md-field>
                <label>Telefoonnummer </label>
                <md-input
                  v-model="newKlant.telefoonNummer"
                  placeholder="Telefoonnummer"
                  type="tel"
                ></md-input>
              </md-field>

              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100">
                  <md-field>
                    <label for="postcode">Postcode</label>
                    <md-input
                      name="postcode"
                      placeholder="Postcode"
                      v-model="newKlant.postcode"
                    />
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 mdli-r">
                  <md-field>
                    <label for="huisNummer">Huisnummer</label>
                    <md-input
                      name="huisNummer"
                      placeholder="Huisnummer"
                      v-model="newKlant.huisNummer"
                      type="number"
                    />
                  </md-field>
                </div>
              </div>

              <md-field>
                <label for="type">Soort ID</label>
                <md-select v-model="newKlant.soortID" name="type" id="type">
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
                  v-model="newKlant.IDnummer"
                  placeholder="ID Nummer"
                  type="number"
                ></md-input>
              </md-field>

              <md-field>
                <label>IBAN</label>
                <md-input
                  v-model="newKlant.IBAN"
                  placeholder="IBAN "
                  type="text"
                ></md-input>
              </md-field>

              <label for="dateofbirth">Geboortedatum</label>
              <md-datepicker
                name="dateofbirth"
                id="dateofbirth"
                v-model="newKlant.geboortedatum"
              />
            </div>

            <div class="input-wrapper ta-center">
            <md-button
              class="md-primary med-md-button"
              type="submit"
              @click="addKlant()"
              >Aanmaken</md-button
            >
          </div>

          </md-step>

          <!-- Personal info -->
          <!-- <md-step id="second" md-label="Telefoon &amp; Contract gegevens">
            <div class="input-wrapper ta-center">
              <md-field>
                <label>Merk</label>
                <md-input
                  v-model="newKlant.merk"
                  placeholder="Merk"
                  type="text"
                ></md-input>
              </md-field>

              <md-field>
                <label>Model</label>
                <md-input
                  v-model="newKlant.model"
                  placeholder="Model"
                  type="text"
                ></md-input>
              </md-field>

              <label for="Aanschafdatum">Aanschafdatum</label>
              <md-datepicker
                name="Aanschafdatum"
                id="Aanschafdatum"
                v-model="newKlant.aanschafdatum"
              />

              <md-field>
                <label>Provider</label>
                <md-input
                  v-model="newKlant.provider"
                  placeholder="Provider"
                  type="text"
                ></md-input>
              </md-field>

              <md-field>
                <label for="type">Contract type</label>
                <md-select
                  v-model="newKlant.type"
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
                v-model="newKlant.uitgeefDatumAbbonement"
              />

              <md-field>
                <label for="Duration">Duur contract</label>
                <md-select
                  v-model="newKlant.duurAbbonement"
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
                v-model="newKlant.verloopDatumAbbonement"
              />

              <md-field>
                <label>Maandelijkse kosten</label>
                <md-icon>euro_symbol</md-icon>
                <md-input
                  v-model="newKlant.maandelijkseKosten"
                  placeholder="Maandelijkse kosten"
                  type="number"
                ></md-input>
              </md-field>

              <md-field>
                <label for="GSM">Afgesloten via GSM brielle?</label>
                <md-select
                  v-model="newKlant.afgeslotenViaOns"
                  name="GSM"
                  id="GSM"
                  required
                >
                  <md-option value="0">Ja</md-option>
                  <md-option value="1">Nee</md-option>
                </md-select>
              </md-field>

              <md-button
                class="md-primary med-md-button"
                type="submit"
                @click="addKlant()"
                >Aanmaken</md-button
              >
            </div>
          </md-step> -->
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
      newKlant: {
        soortID: "",
        contractType: "",
        duurAbbonement: "",
        afgeslotenViaOns: "",
      },
      response: "",
    };
  },

  mounted() {},

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

    addKlant() {
      axios
        .post("/add-klant-dashboard", this.newKlant)
        .then((response) => (this.response = response.data))
        .catch((error) => (this.response = error.data));
    },
  },
};
</script>
