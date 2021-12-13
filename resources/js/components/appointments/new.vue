<template>
    <div>
        <v-card class="px-5 py-3">

            <v-form class="mt-5" ref="formValidate" lazy-validation v-model="formValidate">

                <v-card-title>
                    <span class="text-h5">Cadastrar nova consulta</span>
                </v-card-title>
                    <div class="row">
                        <div class="col-md-4">
                            <v-text-field
                                v-model="appointment.title"
                                label="Título"
                            >
                            </v-text-field>
                        </div>
                        <div class="col-md-4">
                            <v-combobox
                                v-model="selectPatients"
                                :loading="loadingPatients"
                                item-text="text"
                                item-value="value"
                                :items="patients"
                                label="Utentes"
                                multiple
                            >
                                <template v-slot:selection="{index}">
                                    <span v-if="index === 0">
                                        {{selectPatients.length}} Utentes selecionados
                                    </span>
                                </template>
                            </v-combobox>
                        </div>
                        <div class="col-md-4">
                            <v-menu
                                ref="menuDateAppointment"
                                v-model="menuDateAppointment"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="dateAppointmentVm"
                                        label="Data da consulta"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="dateAppointment"
                                    no-title
                                    @input="menuDateAppointment = false"
                                ></v-date-picker>
                            </v-menu>
                        </div>
                        <div class="col-md-4">
                            <v-menu
                                ref="menu"
                                v-model="menuStartAppointment"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                :return-value.sync="appointment.startAppointment"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="appointment.startAppointment"
                                        label="Início da consulta"
                                        prepend-icon="mdi-clock-time-four-outline"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-time-picker
                                    v-if="menuStartAppointment"
                                    v-model="appointment.startAppointment"
                                    full-width
                                    @click:minute="$refs.menu.save(appointment.startAppointment)"
                                    format="24hr"
                                ></v-time-picker>
                            </v-menu>
                        </div>
                        <div class="col-md-4">
                            <v-menu
                                ref="menu2"
                                v-model="menuEndAppointment"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                :return-value.sync="appointment.endAppointment"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="appointment.endAppointment"
                                        label="Fim da consulta"
                                        prepend-icon="mdi-clock-time-four-outline"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-time-picker
                                    v-if="menuEndAppointment"
                                    v-model="appointment.endAppointment"
                                    full-width
                                    @click:minute="$refs.menu2.save(appointment.endAppointment)"
                                    format="24hr"
                                ></v-time-picker>
                            </v-menu>
                        </div>
                        <div class="col-md-4">
                            <v-text-field
                                v-model="appointment.additional"
                                label="Informações adicionais"
                            >

                            </v-text-field>
                        </div>
                        <div class="col-md-4">
                            <v-switch
                                v-model="appointment.internal"
                                label="Consulta Externa"
                                v-if="appointment.internal"
                            ></v-switch>
                            <v-switch
                                v-model="appointment.internal"
                                label="Consulta Interna"
                                v-if="!appointment.internal"
                            ></v-switch>
                        </div>
                    </div>
                <v-card-text>

                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="$emit('listenNewAppointment', true)"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="success"
                        text
                        @click="requestNewAppointment()"
                    >
                        Salvar
                    </v-btn>
                </v-card-actions>
            </v-form>
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
export default {
    name: "new",
    props: [
        'urlBaseApiPatients',
        'urlBaseApiAppointments'
    ],
    data: vm => ({
        alert: false,
        formValidate: false,
        alertTime: 2000,
        alertMessage: '',
        selectPatients: [],
        patients: [],
        loadingPatients: true,
        dateAppointment: null,
        dateAppointmentVm: null,
        menuDateAppointment: false,
        menuStartAppointment: null,
        menuEndAppointment: null,
        appointment: {
            title: '',
            dateAppointment: null,
            startAppointment: null,
            endAppointment: null,
            additional: null,
            internal: false,
        }
    }),
    methods: {
        requestNewAppointment() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = this.appointment;
            data.dateAppointment = this.dateAppointment;
            data.users = this.selectPatients;
            axios.post(this.urlBaseApiAppointments, data, settings)
                .then(
                    (response) => {
                        this.$emit('listenNewAppointment');
                    }
                )
                .catch(
                    (response) => {
                        console.log(response);
                        this.alert = true;
                        this.alertMessage = 'Erro no cadastro, tente novamente';
                    }
                )
        },
        getPatient(){
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiPatients, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.patients.push({text: item.name, value: item.id})
                    });
                    this.loadingPatients = false;
                }
            )
        },
        formatDate(date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${day}/${month}/${year}`
        },
    },
    mounted() {
        this.getPatient();
    },
    watch: {
        dateAppointment(val) {
            this.dateAppointmentVm = this.formatDate(this.dateAppointment);
        },
    },
}
</script>

<style scoped>

</style>
