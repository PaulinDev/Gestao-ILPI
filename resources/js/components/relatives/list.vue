<template>
  <div>
    <v-card
      class="mx-auto mb-4"
      max-width="auto"
      v-for="patient in patients"
      v-bind:key="patient.id"
    >
      <v-card-title class="pb-0 mb-2"> {{ patient.name }} </v-card-title>

      <v-card-text class="text--primary">
        <div>{{ patient.nick }}</div>

        <div>Data de admissão: {{datetimeToDate(patient.admission)}}</div>
      </v-card-text>

      <v-card-actions>
        <patient-pdf :url-base-api="urlBaseApiPatient" :id-current-patient="patient.id"></patient-pdf>

        <v-btn color="orange" text> VER  </v-btn>

        <v-btn color="orange" text> ACESSAR QUARTO </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  name: "list",
  props: ["idCurrentUser", "urlBaseApi", "urlBaseApiPatient"],
  data() {
    return {
      patients: [],
    };
  },
  methods: {
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
    getPatientsByUser() {
      let settings = {
        headers: {
          Accept: "application/json",
          Authorization: this.$root.token(),
        },
      };
      axios
        .get(this.urlBaseApi + "/" + this.idCurrentUser, settings)
        .then((response) => {
          response.data.get_patients.forEach((x) => {
            this.getPatient(x.patientId);
          });
        });
    },
    getPatient(patientId) {
      let settings = {
        headers: {
          Accept: "application/json",
          Authorization: this.$root.token(),
        },
      };
      axios
        .get(this.urlBaseApiPatient + "/" + patientId, settings)
        .then((response) => {
          this.patients.push(response.data);
        });
    },
  },
  mounted() {
    this.getPatientsByUser();
  },
};
</script>
