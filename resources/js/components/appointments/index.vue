<template>
    <div>
        <v-dialog
            v-model="dialogNewAppointment"
            persistent
            max-width="auto"
        >
            <template v-slot:activator="{ on, attrs }">
                <div class="col-md-10 px-0 py-0">
                    <v-btn
                        color="primary"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <i class="fas fa-plus"></i> Consulta
                    </v-btn>
                </div>
            </template>
            <appointments-new
                :url-base-api-patients="urlBaseApiPatients"
                :url-base-api-appointments="urlBaseApiAppointments"
                @listenNewAppointment="listenNewAppointment"
            ></appointments-new>
        </v-dialog>

        <v-card
            class="px-4 py-4 mt-3"
        >
            <v-card-text>
                <FullCalendar :options="calendarOptions"/>
            </v-card-text>
        </v-card>
        <v-snackbar
            v-model="alert"
            :timeout="alertTime"
        >
            {{ alertMessage }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    color="blue"
                    text
                    v-bind="attrs"
                    @click="alert = false"
                >
                    Fechar
                </v-btn>
            </template>
        </v-snackbar>
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
    name: "index",
    props: [
        'urlBaseApiPatients',
        'urlBaseApiAppointments'
    ],
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            alert: false,
            alertTime: 2000,
            alertMessage: '',
            dialogNewAppointment: false,
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
        }
    },
    methods: {
        handleDateClick: function (arg) {
            alert('date click! ' + arg.dateStr)
        },
        listenNewAppointment(cancel){
            if (cancel) {
                this.dialogNewAppointment = false;
            } else {
                this.dialogNewAppointment = false;
                this.getAppointments();
                this.alert = true;
                this.alertMessage = 'Agendamentos registrados com sucesso';
            }
        },
        getAppointments(){
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiAppointments, settings).then(
                (response) => {
                    this.calendarOptions.events = [];
                    response.data.forEach((item) => {
                        this.calendarOptions.events.push(
                            {
                                title: item.title,
                                start: item.dateAppointment+'T'+item.startAppointment,
                                end: item.dateAppointment+'T'+item.endAppointment,
                                description: item.additional
                            }
                        )
                        console.log(this.calendarOptions.events);
                    });
                    this.loadingPatients = false;
                }
            )
        }
    },
    mounted() {
        this.getAppointments();
    }
}
</script>

<style scoped>

</style>
