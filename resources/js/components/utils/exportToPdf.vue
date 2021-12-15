<template>
  <div>
    <section ref="content-pdf">
      <div class="row">
        <!-- div class="col-md-6">
          <v-card class="pt-6 mx-auto" flat>
            <v-card-text>
              <img src="https://cdn.vuetifyjs.com/images/lists/2.jpg" />
              <h3 class="text-h5 mb-2">
                {{ patientInfo.name }}
              </h3>
              <div class="blue--text mb-2">
                {{ patientInfo.nick }}
              </div>
              <div class="blue--text subheading font-weight-bold">
                {{ this.datetimeToDate(patientInfo.birthdate) }}
              </div>
            </v-card-text>
            <v-divider></v-divider>
            <v-row class="text-left" tag="v-card-text">
              <v-col class="text-right mr-4 mb-2" tag="strong" cols="5">
                Data de admissão:
              </v-col>
              <v-col>{{ this.datetimeToDate(patientInfo.admission) }}</v-col>
              <v-col class="text-right mr-4 mb-2" tag="strong" cols="5">
                Gênero:
              </v-col>
              <v-col>
                {{ patientInfo.get_gender.description }}
              </v-col>
              <v-col class="text-right mr-4 mb-2" tag="strong" cols="5">
                Estado civil:
              </v-col>
              <v-col>{{ patientInfo.get_civil.description }}</v-col>
            </v-row>
          </v-card>
        </!-->
      </div>
    </section>

    <v-btn :disabled="loadingPatient"> FICHA </v-btn>
  </div>
</template>

<script>
import { jsPDF } from "jspdf";

export default {
  props: ["urlBaseApi", "idCurrentPatient"],
  data() {
    return {
      patientInfo: {
        name: "",
        nick: "",
        birthdate: "",
        gender: "",
        photo: "",
        civil: "",
        education: "",
        occupation: "",
        admission: "",
        country: "",
        situation: "",
      },
      loadingPatient: true,
    };
  },
  methods: {
    getPatient() {
      let settings = {
        headers: {
          Accept: "application/json",
          Authorization: this.$root.token(),
        },
      };
      axios
        .get(this.urlBaseApi + "/" + this.idCurrentPatient, settings)
        .then((response) => {
          this.patientInfo = response.data;
          this.loadingPatient = false;
        });
    },

    datetimeToDate: function (date) {
      let getDate = new Date(date),
        day = getDate.getDate(),
        month = getDate.getMonth(),
        year = getDate.getFullYear(),
        monthNames = [
          "Janeiro",
          "Fevereiro",
          "Março",
          "Abril",
          "Maio",
          "Junho",
          "Julho",
          "Agosto",
          "Setembro",
          "Outubro",
          "Novembro",
          "Dezembro",
        ];

      return day + " de " + monthNames[month] + " de " + year;
    },
  },
  mounted() {
    this.getPatient();
  },
};
</script>
