<template>
    <div>
        <v-card
            v-if="patients.length !== 0"
            class="mx-auto mb-4"
            max-width="auto"
            v-for="patient in patients"
            v-bind:key="patient.id"
        >
            <v-card-title class="pb-0 mb-2"> {{ patient.name }}</v-card-title>

            <v-card-text class="text--primary">
                <div>{{ patient.nick }}</div>

                <div>Data de admissão: {{ datetimeToDate(patient.admission) }}</div>
            </v-card-text>

            <v-card-actions>
                <v-dialog
                    v-model="dialogDataPatient"
                    max-width="auto"
                    width="1200"
                    height="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on" color="primary" class="ml-1 align-self-center" text>
                            Ver Ficha
                        </v-btn>
                    </template>

                    <relative-patient-info
                        v-if="dialogDataPatient"
                        class="col-md-12"
                        :id-current-patient="patient.id"
                        :url-base-api="urlBaseApiPatient"
                        :url-base-api-genders="urlBaseApiGenders"
                        :url-base-api-civil="urlBaseApiCivil"
                        :url-base-api-country="urlBaseApiCountry"
                        :url-base-api-education="urlBaseApiEducation"
                        :url-base-api-occupation="urlBaseApiOccupation"
                        :url-base-api-inventory-type="urlBaseApiInventoryType"
                        :url-base-api-pathology="urlBaseApiPathology"
                        :url-base-api-therapy="urlBaseApiTherapy"
                    ></relative-patient-info>

                </v-dialog>

                        <v-btn color="primary" class="ml-1 align-self-center" text @click="getEvents(patient.id); dialogActivityPatient = true">
                            Ver Atividades
                        </v-btn>


                <v-btn color="orange" text :href="urlPageViewPatient+'/'+patient.id"> Cameras</v-btn>
            </v-card-actions>
        </v-card>
        <v-card
            class="mx-auto mb-4 px-3 py-3"
            max-width="auto"
            v-if="patients.length === 0"
        >
            <v-card-title class="pb-0 mb-2"> No momento você não está associado a nenhum utente.</v-card-title>
        </v-card>

        <v-dialog
            v-model="dialogActivityPatient"
            max-width="auto"
            width="1200"
            height="100%"
        >
            <v-card class="px-3 py-3">
                <v-card-text v-if="!loadingEvents">
                    <FullCalendar :options="calendarOptions"/>
                </v-card-text>
            </v-card>

        </v-dialog>
    </div>
</template>
<script>
import '@fullcalendar/core/vdom'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import ptBr from '@fullcalendar/core/locales/pt-br'

export default {
    name: "list",
    props: [
        "idCurrentUser",
        "urlBaseApi",
        "urlBaseApiPatient",
        "urlPageViewPatient",
        'urlBaseApiTherapy',
        'urlBaseApiInventoryType',
        'urlBaseApiPathology',
        "urlBaseApiGenders",
        "urlBaseApiCivil",
        "urlBaseApiCountry",
        "urlBaseApiEducation",
        "urlBaseApiOccupation",
        "idCurrentPatient",
        "urlBaseApiGetEventPatient"
    ],
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            patients: [],
            dialogDataPatient: false,
            dialogActivityPatient: false,
            loadingEvents: true,
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin],
                initialView: 'dayGridMonth',
                locales: [ptBr],
                events: [],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                editable: true,
                displayEventTime: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                weekends: true,
            }
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
                    console.log(response.data);
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
                    console.log(this.patients);
                });
        },
        getEvents(patientId) {
            let settings = {
                headers: {
                    Accept: "application/json",
                    Authorization: this.$root.token(),
                },
            };
            this.calendarOptions.events = [];
            axios
                .get(this.urlBaseApiGetEventPatient + "/" + patientId, settings)
                .then((response) => {
                    this.loadingEvents = false;
                    response.data.forEach((e) => {
                        this.calendarOptions.events.push({
                            title: e.title,
                            start: e.date + "T" + e.timeStart,
                            end: e.end + "T" + e.timeEnd,
                            allDay: e.allDay !== 0,
                            daysOfWeek: JSON.parse(e.repeatDays),
                        });
                    });
                });
        },
    },
    mounted() {
        this.getPatientsByUser();
    },
};
</script>
