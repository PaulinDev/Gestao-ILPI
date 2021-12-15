<template>
  <div>
    <v-card>
      <v-card-title> Editar atividade </v-card-title>
      <v-card-text>
        <div class="row">
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
                @click:minute="$refs.menu.save(timeRecordStartActivity)"
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
                  label="Fim da atividade"
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
                @click:minute="$refs.menu2.save(timeRecordEndActivity)"
                format="24hr"
              ></v-time-picker>
            </v-menu>
          </div>
        </div>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="dialogCreateEvent = false">
          Fechar
        </v-btn>
        <v-btn color="blue darken-1" text @click="createRecordActivity()">
          Salvar
        </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
export default {
  name: "view",
  props: [
    "idCurrentActivity",
    "baseUrlApi",
    "idCurrentEvent",
  ],
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
    selectRepeatDays: [],
    allDay: true,
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
    getEvent() {
      let settings = {
        headers: {
          Accept: "application/json",
          Authorization: this.$root.token(),
        },
      };

      axios
        .get(this.baseUrlApi + "/" + this.idCurrentEvent, settings)
        .then((response) => {
          this.allDay = response.allDay;
          this.selectRepeatDays = response.repeatDays;
          this.dateRecordStartActivity = response.date;
          this.timeRecordStartActivity = response.allDay ? null : response.timeStart;
          this.timeRecordEndActivity = response.allDay ? null : response.timeEnd;
          this.dateRecordEndActivity = response.end;
        });
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
    this.getEvent();
  },
};
</script>

<style scoped>
</style>
