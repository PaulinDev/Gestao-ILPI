<template>
    <div>
        <v-tabs
            v-model="tab"
            background-color="primary"
            dark
            class="pt-10"
        >
            <v-tab key="1">
                Inscrição
            </v-tab>
            <v-tab key="2">
                Saúde
            </v-tab>
            <v-tab key="3">
                Cartões
            </v-tab>
            <v-tab key="4">
                Informações de Contato
            </v-tab>
            <v-tab key="5">
                Estoque
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab" class="mt-5" :rounded="true">
            <v-tab-item
                key="1"
            >
                <v-card flat>
                    <v-card-text>
                        <h2 class="text-xl font-weight-semibold mb-2">Inscrição</h2>
                        <v-divider></v-divider>
                        <div class="row">
                            <div class="col-md-4">
                                <v-text-field
                                    label="Nº Registro"
                                    v-model="idCurrentPatient"
                                    disabled
                                >

                                </v-text-field>
                            </div>
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
                                            label="Data de admissão"
                                            persistent-hint
                                            prepend-icon="mdi-calendar"
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="patientInfo.admission"
                                        no-title
                                        @input="menuDateBirthdate = false"
                                    ></v-date-picker>
                                </v-menu>
                            </div>
                            <div class="col-md-4">
                                <v-text-field
                                    label="Quarto"
                                >

                                </v-text-field>
                            </div>
                        </div>

                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item
                key="2"
            >
                <v-card flat class="px-4 py-4">
                    <v-card-text>
                        <h2 class="text-xl font-weight-semibold mb-2">Saúde</h2>
                        <v-divider></v-divider>
                        <small v-if="patientInfo.get_health === null">Utente ainda não possui estas informações
                            cadastradas</small>
                        <v-form class="mt-5" ref="formHealth" lazy-validation v-model="formHealth">
                            <div class="row">
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Grupo Sanguíneo"
                                        v-model="patientHealth.bloodGroup"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Centro de saúde"
                                        v-model="patientHealth.healthCenter"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Médico"
                                        v-model="patientHealth.doctor"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Contato"
                                        v-model="patientHealth.contact"
                                    >

                                    </v-text-field>
                                </div>
                                <v-btn
                                    class="col-md-12"
                                    color="success"
                                    :disabled="!formHealth"
                                    @click="createOrUpdateHealth()"
                                >
                                    <span v-if="patientInfo.get_health === null">Cadastrar</span>
                                    <span v-else>Atualizar</span>
                                </v-btn>
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item
                key="3"
            >
                <v-card flat class="px-4 py-4">
                    <v-card-text>
                        <h2 class="text-xl font-weight-semibold mb-2">Cartões</h2>
                        <v-divider></v-divider>
                        <small v-if="patientInfo.get_cards === null">Utente ainda não possui estas informações
                            cadastradas</small>
                        <v-form class="mt-5" ref="formCards" lazy-validation v-model="formCards">
                            <div class="row">
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Cartão de Cidadão"
                                        v-model="patientCards.card"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Contribuinte"
                                        v-model="patientCards.contribution"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Segurança Social"
                                        v-model="patientCards.securitySocial"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Subsistema de saúde"
                                        v-model="patientCards.systemHealth"
                                    >

                                    </v-text-field>
                                </div>
                                <v-btn
                                    class="col-md-12"
                                    color="success"
                                    :disabled="!formCards"
                                    @click="createOrUpdateCards()"
                                >
                                    <span v-if="patientInfo.get_cards === null">Cadastrar</span>
                                    <span v-else>Atualizar</span>
                                </v-btn>
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item
                key="4"
            >
                <v-card flat class="px-4 py-4">
                    <v-card-text>
                        <h2 class="text-xl font-weight-semibold mb-2">Informações de Contato</h2>
                        <v-divider></v-divider>
                        <small v-if="patientInfo.get_address === null">Utente ainda não possui estas informações
                            cadastradas</small>
                        <v-form class="mt-5" ref="formAddress" lazy-validation v-model="formAddress">
                            <div class="row">
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Endereço"
                                        v-model="patientAddress.address"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Cep"
                                        v-model="patientAddress.cep"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="Telefone"
                                        v-model="patientAddress.phone"
                                    >

                                    </v-text-field>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field
                                        label="E-mail"
                                        v-model="patientAddress.email"
                                    >

                                    </v-text-field>
                                </div>
                                <v-btn
                                    class="col-md-12"
                                    color="success"
                                    :disabled="!formAddress"
                                    @click="createOrUpdateAddress()"
                                >
                                    <span v-if="patientInfo.get_address === null">Cadastrar</span>
                                    <span v-else>Atualizar</span>
                                </v-btn>
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item
                key="5"
            >
                <v-card flat>
                    <v-card-text><h2 class="text-xl font-weight-semibold mb-2">Estoque</h2></v-card-text>
                </v-card>
            </v-tab-item>
        </v-tabs-items>
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
    name: "patient-additional-info",
    props: [
        'idCurrentPatient',
        'urlBaseApi',
        'urlBaseApiHealth',
        'urlBaseApiCards',
        'urlBaseApiAddress',
    ],
    data: vm => ({
        alert: false,
        alertMessage: '',
        alertTime: 2000,
        tab: null,
        formHealth: true,
        formCards: true,
        formAddress: true,
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
            get_health: null,
            get_cards: null,
            get_address: null
        },
        patientHealth: {
            bloodGroup: '',
            healthCenter: '',
            doctor: '',
            contact: '',
            patient: 0
        },
        patientCards: {
            card: '',
            contribution: '',
            securitySocial: '',
            systemHealth: '',
            patient: 0
        },
        patientAddress: {
            address: '',
            cep: '',
            phone: '',
            email: '',
            patient: 0
        },
        dateBirthdate: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
        menuDateBirthdate: false,
        rules: {
            required: value => !!value || 'Preenchimento obrigatório.',
            min: v => v.length >= 8 || 'Este campo precisa ter no minímo 8 caracteres',
            emailMatch: () => (`The email and password you entered don't match`),
        },
    }),
    methods: {
        formatDate(date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${day}/${month}/${year}`
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

                    if (this.patientInfo.get_health !== null) {
                        this.patientHealth = this.patientInfo.get_health;
                    }

                    if (this.patientInfo.get_cards !== null) {
                        this.patientCards = this.patientInfo.get_cards;
                    }

                    if (this.patientInfo.get_address !== null) {
                        this.patientAddress = this.patientInfo.get_address;
                    }

                    this.dateBirthdate = this.patientInfo.admission;
                    console.log(this.patientHealth);
                }
            );
        },
        createOrUpdateHealth() {
            if (!this.patientInfo.get_health) {

                let settings = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.$root.token()
                    }
                };

                axios.post(this.urlBaseApiHealth, this.patientHealth, settings)
                    .then(
                        (response) => {
                            this.alert = true;
                            this.alertMessage = 'Informações da saúde do paciente adicionadas com sucesso';
                            this.getPatient();
                        }
                    )
                    .catch(
                        (response) => {
                            console.log(response);
                            this.alert = true;
                            this.alertMessage = 'Erro no cadastro, tente novamente';
                        }
                    )
            } else {
                let settings = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.$root.token()
                    }
                };
                axios.put(this.urlBaseApiHealth + '/' + this.patientHealth.id, this.patientHealth, settings)
                    .then(
                        (response) => {
                            this.alert = true;
                            this.alertMessage = 'Informações da saúde do paciente atualizadas com sucesso';
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
            }
        },
        createOrUpdateCards() {
            if (!this.patientInfo.get_cards) {

                let settings = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.$root.token()
                    }
                };

                axios.post(this.urlBaseApiCards, this.patientCards, settings)
                    .then(
                        (response) => {
                            this.alert = true;
                            this.alertMessage = 'Informações de cartões do paciente adicionadas com sucesso';
                            this.getPatient();
                        }
                    )
                    .catch(
                        (response) => {
                            console.log(response);
                            this.alert = true;
                            this.alertMessage = 'Erro no cadastro, tente novamente';
                        }
                    )
            } else {
                let settings = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.$root.token()
                    }
                };
                axios.put(this.urlBaseApiCards + '/' + this.patientCards.id, this.patientCards, settings)
                    .then(
                        (response) => {
                            this.alert = true;
                            this.alertMessage = 'Informações de cartões do paciente atualizadas com sucesso';
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
            }
        },
        createOrUpdateAddress() {
            if (!this.patientInfo.get_address) {

                let settings = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.$root.token()
                    }
                };

                axios.post(this.urlBaseApiAddress, this.patientAddress, settings)
                    .then(
                        (response) => {
                            this.alert = true;
                            this.alertMessage = 'Informações de contato do paciente adicionadas com sucesso';
                            this.getPatient();
                        }
                    )
                    .catch(
                        (response) => {
                            console.log(response);
                            this.alert = true;
                            this.alertMessage = 'Erro no cadastro, tente novamente';
                        }
                    )
            } else {
                let settings = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.$root.token()
                    }
                };
                axios.put(this.urlBaseApiAddress + '/' + this.patientAddress.id, this.patientAddress, settings)
                    .then(
                        (response) => {
                            this.alert = true;
                            this.alertMessage = 'Informações de contato do paciente atualizadas com sucesso';
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
            }
        }
    },
    watch: {
        date(val) {
            this.dateBirthdate = this.formatDate(this.date);
        }
    },
    mounted() {
        this.getPatient();
        this.patientHealth.patient = this.idCurrentPatient;
        this.patientCards.patient = this.idCurrentPatient;
        this.patientAddress.patient = this.idCurrentPatient;
    }
}
</script>

<style scoped>

</style>
