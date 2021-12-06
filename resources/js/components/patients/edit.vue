<template>
    <div>
        <v-card class="px-5 py-3">

            <v-form class="mt-5" ref="form" lazy-validation v-model="formValidate">

                <v-card-title>
                    <span class="text-h5">Editar utente</span>
                </v-card-title>

                <v-card-text>
                    <div class="row">
                        <div class="col-md-4">
                            <v-text-field
                                label="Nome Completo"
                                required
                                v-model="patientInfo.name"
                            ></v-text-field>
                        </div>
                        <div class="col-md-4">
                            <v-text-field
                                label="Apelido"
                                required
                                v-model="patientInfo.nick"
                            ></v-text-field>
                        </div>
                        <div class="col-md-4">
                            <v-menu
                                ref="menuDateAdmission"
                                v-model="menuDateAdmission"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="dateAdmissionVm"
                                        label="Data de admissão"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="dateAdmission"
                                    no-title
                                    @input="menuDateAdmission = false"
                                ></v-date-picker>
                            </v-menu>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <v-menu
                                ref="menuDateBirthdate"
                                v-model="menuDateBirthdate"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="dateBirthdate"
                                        label="Data de nascimento"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="date"
                                    no-title
                                    @input="menuDateBirthdate = false"
                                ></v-date-picker>
                            </v-menu>
                        </div>
                        <div class="col-md-4">
                            <v-select
                                :items="genderItems"
                                v-model="patientInfo.gender"
                                label="Sexo"
                                :loading="loadItemGender"
                                :rules="[rules.required]"
                            ></v-select>
                        </div>
                        <div class="col-md-4">
                            <v-select
                                :items="civilItems"
                                v-model="patientInfo.civil"
                                label="Estado Civil"
                                :loading="loadItemCivil"
                                :rules="[rules.required]"
                            ></v-select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <v-select
                                :items="educationItems"
                                v-model="patientInfo.education"
                                label="Grau de escolaridade"
                                :loading="loadItemEducation"
                                :rules="[rules.required]"
                            ></v-select>
                        </div>
                        <div class="col-md-4 d-flex">
                            <v-autocomplete
                                :items="occupationItems"
                                v-model="patientInfo.occupation"
                                label="Profissão"
                                :loading="loadItemOccupation"
                                :rules="[rules.required]"
                            ></v-autocomplete>
                            <v-dialog
                                v-model="dialogNewOccupation"
                                max-width="600px"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        v-bind="attrs"
                                        v-on="on" color="primary" class="ml-1 align-self-center">
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="text-h5">Nova profissão</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col
                                                    cols="12"
                                                    md="12"
                                                >
                                                    <v-text-field
                                                        label="Nome da Profissão"
                                                        required
                                                        v-model="newOccupationName"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="error"
                                            text
                                            @click="dialogNewOccupation = false"
                                        >
                                            Cancelar
                                        </v-btn>
                                        <v-btn
                                            color="success"
                                            text
                                            @click="createNewOccupation()"
                                        >
                                            Salvar
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </div>
                        <div class="col-md-4">
                            <v-autocomplete
                                :items="countryItems"
                                v-model="patientInfo.country"
                                label="Nacionalidade"
                                :loading="loadItemCountry"
                                :rules="[rules.required]"
                            ></v-autocomplete>
                        </div>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="dialogNewPost = false"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="success"
                        text
                        @click="requestEditUser()"
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
    props: [
        'idCurrentPatient',
        'urlBaseApi',
        'urlBaseApiGenders',
        'urlBaseApiCivil',
        'urlBaseApiCountry',
        'urlBaseApiEducation',
        'urlBaseApiOccupation',
        'urlPageIndex',
    ],
    name: "edit",
    data: vm => ({
        alert: false,
        alertMessage: '',
        alertTime: 2000,
        activePicker: null,
        formValidate: false,
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        dateAdmission: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        dateBirthdate: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
        dateAdmissionVm: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
        menuDateBirthdate: false,
        menuDateAdmission: false,
        dialogNewOccupation: false,
        menu: false,
        genderItems: [],
        civilItems: [],
        educationItems: [],
        occupationItems: [],
        countryItems: [],
        newOccupationName: '',
        patientInfo: {},
        loadItemGender: true,
        loadItemCivil: true,
        loadItemEducation: true,
        loadItemOccupation: true,
        loadItemCountry: true,
        rules: {
            required: value => !!value || 'Preenchimento obrigatório.',
            min: v => v.length >= 8 || 'Este campo precisa ter no minímo 8 caracteres',
            emailMatch: () => (`The email and password you entered don't match`),
        },
    }),
    methods: {
        validate() {
            this.$refs.form.validate()
        },
        createNewOccupation() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            let data = {
                name: this.newOccupationName,
            };

            axios.post(this.urlBaseApiOccupation, data, settings)
                .then(response => {
                    this.alert = true;
                    this.alertMessage = 'Nova Profissão cadastrada com sucesso';
                    this.newOccupationName = '';
                    this.dialogNewOccupation = false;
                    this.getOccupationItems();
                }).catch(error => {
                this.alert = true;
                this.alertMessage = 'Houve um erro, tente novamente';
            })
        },
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
        getGenderItems() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiGenders, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.genderItems.push({text: item.description, value: item.id})
                    });
                    this.loadItemGender = false;
                }
            )
        },
        getCivilItems() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiCivil, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.civilItems.push({text: item.description, value: item.id})
                    });
                    this.loadItemCivil = false;
                }
            )
        },
        getCountryItems() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiCountry, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.countryItems.push({text: item.name, value: item.id})
                    });
                    this.loadItemCountry = false;
                }
            )
        },
        getEducationItems() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiEducation, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.educationItems.push({text: item.description, value: item.id})
                    });
                    this.loadItemEducation = false;
                }
            )
        },
        getOccupationItems() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiOccupation, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.occupationItems.push({text: item.description, value: item.id})
                    });
                    this.loadItemOccupation = false;
                }
            )
        },
        save(date) {
            this.$refs.menu.save(date)
        },
        requestEditUser() {
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
                        this.$emit('listenEditRequestUser');
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
        formatDate(date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${day}/${month}/${year}`
        },

    },
    computed: {
        computedDateFormatted() {
            return this.formatDate(this.date)
        },
    },
    watch: {
        date(val) {
            this.dateBirthdate = this.formatDate(this.date);
        },
        dateAdmission(val) {
            this.dateAdmissionVm = this.formatDate(this.dateAdmission);
        },
    },
    mounted() {
        this.getGenderItems();
        this.getCivilItems();
        this.getEducationItems();
        this.getOccupationItems();
        this.getCountryItems();
        this.getPatient();
    }
}
</script>

<style scoped>

</style>
