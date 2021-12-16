<template>
  <div class="row">
    <div class="col-md-12 mx-auto my-4 p-0">
      <v-card class="px-4 py-4 mt-3">
        <v-card-text>
          <FullCalendar :options="calendarOptions" />
        </v-card-text>
      </v-card>
    </div>
    <div class="col-md-12 mx-auto my-4 p-0">
      <v-expansion-panels>
        <v-expansion-panel>
          <v-expansion-panel-header>
            <h4>Utentes sem Registro de atividades</h4>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <v-dialog v-model="dialogCreateEvent" max-width="800">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        color="primary"
                        v-bind="attrs"
                        v-on="on"
                        :disabled="patientsSelected.length === 0"
                      >
                        <v-icon>mdi-plus</v-icon>
                        Atividade
                      </v-btn>
                    </template>
                    <v-card>
                      <v-card-title> Registrar atividade </v-card-title>
                      <v-card-text>
                        <div class="row">
                          <div class="col-md-12">
                            Registrando atividade para
                            {{ patientsSelected.length }} utentes
                          </div>
                          <div class="col-md-4">
                            <v-select
                              :items="daysOfWeek"
                              item-text="name"
                              item-value="id"
                              v-model="selectRepeatDays"
                              label="Repetir em quais dias ?"
                              multiple
                            >
                            </v-select>
                          </div>
                          <div class="col-md-4">
                            <v-menu
                              ref="menuDateStartActivity"
                              v-model="menuDateStartActivity"
                              :close-on-content-click="false"
                              transition="scale-transition"
                              offset-y
                              max-width="290px"
                              min-width="auto"
                            >
                              <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                  v-model="dateRecordStartActivityVm"
                                  label="Data de início"
                                  persistent-hint
                                  prepend-icon="mdi-calendar"
                                  v-bind="attrs"
                                  v-on="on"
                                ></v-text-field>
                              </template>
                              <v-date-picker
                                v-model="dateRecordStartActivity"
                                no-title
                                @input="menuDateStartActivity = false"
                              ></v-date-picker>
                            </v-menu>
                          </div>
                          <div class="col-md-4">
                            <v-menu
                              ref="menuDateEndActivity"
                              v-model="menuDateEndActivity"
                              :close-on-content-click="false"
                              transition="scale-transition"
                              offset-y
                              max-width="290px"
                              min-width="auto"
                            >
                              <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                  v-model="dateRecordEndActivityVm"
                                  label="Data final"
                                  persistent-hint
                                  prepend-icon="mdi-calendar"
                                  v-bind="attrs"
                                  v-on="on"
                                ></v-text-field>
                              </template>
                              <v-date-picker
                                v-model="dateRecordEndActivity"
                                no-title
                                @input="menuDateEndActivity = false"
                              ></v-date-picker>
                            </v-menu>
                          </div>
                          <div class="col-md-4">
                            <v-switch
                              v-model="allDay"
                              label="Marcar atividade para o dia inteiro ?"
                            ></v-switch>
                          </div>
                          <div class="col-md-4">
                            <v-menu
                              ref="menu"
                              v-model="menuStartActivity"
                              :close-on-content-click="false"
                              :nudge-right="40"
                              :return-value.sync="timeRecordStartActivity"
                              transition="scale-transition"
                              offset-y
                              max-width="290px"
                              min-width="290px"
                            >
                              <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                  v-model="timeRecordStartActivity"
                                  label="Início da atividade"
                                  prepend-icon="mdi-clock-time-four-outline"
                                  readonly
                                  v-bind="attrs"
                                  v-on="on"
                                ></v-text-field>
                              </template>
                              <v-time-picker
                                v-if="menuStartActivity"
                                v-model="timeRecordStartActivity"
                                full-width
                                @click:minute="
                                  $refs.menu.save(timeRecordStartActivity)
                                "
                                format="24hr"
                              ></v-time-picker>
                            </v-menu>
                          </div>
                          <div class="col-md-4" v-if="!allDay">
                            <v-menu
                              ref="menu2"
                              v-model="menuEndActivity"
                              :close-on-content-click="false"
                              :nudge-right="40"
                              :return-value.sync="timeRecordEndActivity"
                              transition="scale-transition"
                              offset-y
                              max-width="290px"
                              min-width="290px"
                            >
                              <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                  v-model="timeRecordEndActivity"
                                  label="Fim da consulta"
                                  prepend-icon="mdi-clock-time-four-outline"
                                  readonly
                                  v-bind="attrs"
                                  v-on="on"
                                ></v-text-field>
                              </template>
                              <v-time-picker
                                v-if="menuEndActivity"
                                v-model="timeRecordEndActivity"
                                full-width
                                @click:minute="
                                  $refs.menu2.save(timeRecordEndActivity)
                                "
                                format="24hr"
                              ></v-time-picker>
                            </v-menu>
                          </div>
                        </div>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                          color="blue darken-1"
                          text
                          @click="dialogCreateEvent = false"
                        >
                          Fechar
                        </v-btn>
                        <v-btn
                          color="blue darken-1"
                          text
                          @click="createRecordActivity()"
                        >
                          Salvar
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </div>
                <v-checkbox
                  v-model="patientsSelected"
                  ref="n"
                  v-for="item in patientWithoutActivityRecords"
                  :label="item.name"
                  v-bind:key="item.id"
                  :value="item.id"
                  class="col-md-3 col-12"
                ></v-checkbox>
              </div>
            </div>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
      <!-- PACIENTES SEM REGISTRO DE VACINA -->
      <v-expansion-panels
        class="mt-3"
      >
        <!-- PACIENTES COM REGISTRO DE VACINA -->
        <v-expansion-panel>
          <v-expansion-panel-header>
            <h4>Utentes com Registro de atividade</h4>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <div class="container">
              <div class="row">
                <div
                  class="col-md-3 col-12"
                  v-for="item in patientWithActivityRecords"
                  ref="x"
                  v-bind:key="item.event"
                >
                  <v-card>
                    <v-card-title>
                      <h5>{{ "Registro " + item.event }}</h5>
                    </v-card-title>

                    <v-card-subtitle>
                      {{ "Utente: " + item.name }}
                    </v-card-subtitle>

                    <v-card-actions>
                      <v-btn
                        color="primary"
                        text
                        @click="
                          idCurrentEvent = item.event;
                          editDialogEventDetails = true;
                        "
                      >
                        Gerenciar
                      </v-btn>
                      <v-btn
                        color="error"
                        text
                        @click="deleteDialogItem(item.event)"
                      >
                        Excluir
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </div>
              </div>
            </div>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>
    <v-snackbar v-model="alert" :timeout="alertTime">
      {{ alertMessage }}

      <template v-slot:action="{ attrs }">
        <v-btn color="blue" text v-bind="attrs" @click="alert = false">
          Fechar
        </v-btn>
      </template>
    </v-snackbar>
    <v-dialog v-model="confirmDialogDelete" persistent max-width="auto">
      <v-card>
        <v-card-title class="text-h5">
          Deletar registro de atividade
        </v-card-title>
        <v-card-text
          >Ao confirmar, sua decisão não poderá ser revertida e o registro será
          excluído permanentemente.
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error"
            text
            @click="
              confirmDialogDelete = false;
              this.deleteItemId = 0;
            "
          >
            Cancelar
          </v-btn>
          <v-btn color="success" text @click="deleteItem()"> Confirmar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-row justify="center">
      <v-dialog v-model="editDialogEventDetails" persistent max-width="auto">
        <activity-edit v-if="editDialogEventDetails" :id-current-activity="idCurrentActivity" :base-url-api="baseUrlApi" :id-current-event="idCurrentEvent" @listenEditEvent="listenEditEvent">
        </activity-edit>
      </v-dialog>
    </v-row>
  </div>
</template>

<script>
import "@fullcalendar/core/vdom";
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import ptBr from "@fullcalendar/core/locales/pt-br";

export default {
  name: "view",
  components: {
    FullCalendar, // make the <FullCalendar> tag available
  },
  props: ["idCurrentActivity", "baseUrlApi", "baseUrlApiPatient"],
  data: (vm) => ({
    alert: false,
    alertMessage: "",
    alertTime: 2000,
    daysOfWeek: [
      {
        id: 0,
        name: "Domingo",
      },
      {
        id: 1,
        name: "Segunda-Feira",
      },
      {
        id: 2,
        name: "Terça-Feira",
      },
      {
        id: 3,
        name: "Quarta-Feira",
      },
      {
        id: 4,
        name: "Quinta-Feira",
      },
      {
        id: 5,
        name: "Sexta-Feira",
      },
      {
        id: 6,
        name: "Sábado",
      },
    ],
    calendarOptions: {
      plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin],
      initialView: "dayGridMonth",
      locales: [ptBr],
      events: [],
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay",
      },
      editable: true,
      displayEventTime: true,
      selectable: true,
      selectMirror: true,
      dayMaxEvents: true,
      weekends: true,
    },
    selectRepeatDays: [],
    allDay: true,
    dialogMain: false,
    idCurrentEvent: null,
    dialogCreateEvent: false,
    editDialogEventDetails: false,
    confirmDialogDelete: false,
    confirmDelete: false,
    patientWithActivityRecords: [],
    patientWithoutActivityRecords: [],
    patientsSelected: [],
    menuDateStartActivity: false,
    menuDateEndActivity: false,
    menuEndActivity: false,
    menuStartActivity: false,
    timeRecordStartActivity: null,
    timeRecordEndActivity: null,
    dateRecordStartActivity: null,
    dateRecordStartActivityVm: vm.formatDate(null),
    dateRecordEndActivity: null,
    dateRecordEndActivityVm: vm.formatDate(null),
  }),
  methods: {
    getListPatients() {
      let settings = {
        headers: {
          Accept: "application/json",
          Authorization: this.$root.token(),
        },
      };
      axios.get(this.baseUrlApiPatient, settings).then((response) => {
        this.patientWithActivityRecords = [];
        this.patientWithoutActivityRecords = [];
        response.data.forEach((patient) => {
          if (patient.get_activities.length > 0) {
            patient.get_activities.forEach((activity) => {
              if (activity.activity == this.idCurrentActivity) {
                this.patientWithActivityRecords.push({
                  id: patient.id,
                  name: patient.name,
                  event: activity.id,
                });
              }
            });
          } else {
            this.patientWithoutActivityRecords.push({
              id: patient.id,
              name: patient.name,
            });
          }
        });
      });
    },
    getEvents() {
      let settings = {
        headers: {
          Accept: "application/json",
          Authorization: this.$root.token(),
        },
      };

      this.calendarOptions.events = [];

      axios.get(this.baseUrlApi, settings).then((response) => {
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
      listenEditEvent(cancel) {
      if (cancel) {
        this.editDialogEventDetails = false;
      } else {
        this.editDialogEventDetails = false;
        this.alert = true;
        this.alertMessage = "Registro de atividade atualizado com sucesso";
        this.getListPatients();
        this.getEvents();
      }
    },
    deleteDialogItem(id) {
      this.confirmDialogDelete = true;
      this.deleteItemId = id;
    },
    deleteItem() {
      let settings = {
        headers: {
          Accept: "application/json",
          Authorization: this.$root.token(),
        },
        data: {
          event: this.deleteItemId,
        },
      };

      axios
        .delete(
          this.baseUrlApi + "/" + this.deleteItemId,
          settings
        )
        .then((response) => {
          this.confirmDialogDelete = false;
          this.deleteItemId = 0;
          this.alert = true;
          this.alertMessage = "Registro deletado";
          this.getListPatients();
          this.getEvents();
        });
    },
    createRecordActivity() {
      let settings = {
        headers: {
          Accept: "application/json",
          Authorization: this.$root.token(),
        },
      };

      let data = {
        activity: this.idCurrentActivity,
        patient: this.patientsSelected,
        allDay: this.allDay,
        repeatDays: this.selectRepeatDays,
        date: this.dateRecordStartActivity,
        timeStart: this.allDay ? null : this.timeRecordStartActivity,
        timeEnd: this.allDay ? null : this.timeRecordEndActivity,
        end: this.dateRecordEndActivity,
      };

      axios.post(this.baseUrlApi, data, settings).then(
        (response) => {
          this.alert = true;
          this.alertMessage = "Atividades cadastradas com sucesso.";
          this.dialogCreateEvent = false;
          this.getListPatients();
          this.getEvents();
        },

        (error) => {
          this.alert = true;
          this.alertMessage = "Ocorreu um erro, tente novamente";
        }
      );
    },
    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
  },
  watch: {
    dateRecordStartActivity(val) {
      this.dateRecordStartActivityVm = this.formatDate(
        this.dateRecordStartActivity
      );
    },
    dateRecordEndActivity(val) {
      this.dateRecordEndActivityVm = this.formatDate(
        this.dateRecordEndActivity
      );
    },
  },
  mounted() {
    this.getListPatients();
    this.getEvents();
  },
};
</script>

<style scoped>
</style>
