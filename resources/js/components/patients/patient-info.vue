<template>
    <div>

        <v-card
            class="mx-auto my-12 pt-10"
        >
            <template slot="progress">
                <v-progress-linear
                    color="deep-purple"
                    height="10"
                    indeterminate
                ></v-progress-linear>
            </template>

            <v-card-title class="justify-center flex-column">
                <v-avatar size="120" tile :rounded="true" class="mb-4">
                    <v-img
                        height="120"
                        max-width="120"
                        src="https://themeselection.com/demo/materio-vuetify-vuejs-admin-template/demo-1/img/2.80504cd9.png"
                    ></v-img>
                </v-avatar>
                <span class="mb-2" style="color: rgba(94,86,105,.87)!important;">{{ patientInfo.name }}</span>
                <v-chip
                    class="ma-2"
                    color="primary"
                    pill
                >
                    <v-icon>
                        mdi-account-outline
                    </v-icon>
                    {{ patientInfo.get_occupation.description }}
                </v-chip>
            </v-card-title>

            <v-card-text>
                <h2 class="text-xl font-weight-semibold mb-2">Detalhes</h2>
                <v-divider></v-divider>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Apelido</v-list-item-title>
                        <v-list-item-subtitle>{{ patientInfo.nick }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Aniversário</v-list-item-title>
                        <v-list-item-subtitle>{{ this.datetimeToDate(patientInfo.birthdate) }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Data de admissão</v-list-item-title>
                        <v-list-item-subtitle>{{ this.datetimeToDate(patientInfo.admission) }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Gênero</v-list-item-title>
                        <v-list-item-subtitle>{{ patientInfo.get_gender.description }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Estado civil</v-list-item-title>
                        <v-list-item-subtitle>{{ patientInfo.get_civil.description }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Grau de escolaridade</v-list-item-title>
                        <v-list-item-subtitle>{{ patientInfo.get_education.description }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Profissão</v-list-item-title>
                        <v-list-item-subtitle>{{ patientInfo.get_occupation.description }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>País de origem</v-list-item-title>
                        <v-list-item-subtitle>{{ patientInfo.get_country.name }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card-text>

            <v-card-actions>
                <v-dialog
                    v-model="dialogEditPatient"
                    persistent
                    max-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            color="warning"
                            v-bind="attrs"
                            v-on="on"
                            text
                        >
                            Editar
                        </v-btn>
                    </template>
                    <edit-patient
                        :id-current-patient="idCurrentPatient"
                        :url-base-api="urlBaseApi"
                        :url-base-api-genders="urlBaseApiGenders"
                        :url-base-api-civil="urlBaseApiCivil"
                        :url-base-api-country="urlBaseApiCountry"
                        :url-base-api-education="urlBaseApiEducation"
                        :url-base-api-occupation="urlBaseApiOccupation"
                        @listenEditRequestUser="listenEditRequestUser"
                    ></edit-patient>
                </v-dialog>
                <v-btn
                    color="success"
                    v-if="patientInfo.situation !== 1"
                    text
                    @click="disableOrActivePatient(true)"
                >
                    Ativar
                </v-btn>
                <v-btn
                    color="error"
                    v-else
                    text
                    @click="disableOrActivePatient(false)"
                >
                    Desativar
                </v-btn>
            </v-card-actions>
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
    name: "patient-info",
    props: [
        'idCurrentPatient',
        'urlBaseApi',
        'urlBaseApiGenders',
        'urlBaseApiCivil',
        'urlBaseApiCountry',
        'urlBaseApiEducation',
        'urlBaseApiOccupation',
    ],
    data() {
        return {
            alert: false,
            alertMessage: '',
            alertTime: 2000,
            patientInfo: {
                name: '',
                nick: '',
                birthdate: '',
                gender: '',
                civil: '',
                education: '',
                occupation: '',
                admission: '',
                country: '',
                situation: '',
            },
            dialogEditPatient: false,
        }
    },
    methods: {
        getPatient() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApi + '/' + this.idCurrentPatient, settings).then(
                (response) => {
                    this.patientInfo = response.data;
                }
            );
        },
        disableOrActivePatient(active) {

            if (active) {
                this.patientInfo.situation = 1;
            } else {
                this.patientInfo.situation = 2;
            }

            this.dialogNewUser = true;
            this.dialogNewUserMsg = '';
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = {
                'name': this.patientInfo.name,
                'nick': this.patientInfo.nick,
                //'additional': null,
                'birthdate': this.patientInfo.birthdate,
                'gender': this.patientInfo.gender,
                'civil': this.patientInfo.civil,
                'education': this.patientInfo.education,
                'occupation': this.patientInfo.occupation,
                'admission': this.patientInfo.admission,
                'country': this.patientInfo.country,
                'situation': this.patientInfo.situation,
            };

            axios.put(this.urlBaseApi + '/' + this.idCurrentPatient, data, settings)
                .then(
                    () => {
                        this.dialogEditPatient = false;
                        this.alert = true;
                        this.alertMessage = 'Utente atualizado com sucesso';
                        this.getPatient();
                    }
                )
                .catch(
                    (error) => {
                        console.log(error);
                        this.alert = true;
                        this.alertMessage = 'Erro no cadastro, tente novamente';
                    }
                )

        },
        datetimeToDate: function (date) {
            let getDate = new Date(date),
                day = getDate.getDate(),
                month = getDate.getMonth(),
                year = getDate.getFullYear(),
                monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

            return day + ' de ' + monthNames[month] + ' de ' + year;
        },
        listenEditRequestUser(cancel) {
            if (cancel) {
                this.dialogEditPatient = false;
            } else {
                this.dialogEditPatient = false;
                this.alert = true;
                this.alertMessage = 'Utente atualizado com sucesso';
                this.getPatient();
            }
        }
    },
    mounted() {
        this.getPatient();
    }
}
</script>

<style scoped>

</style>
