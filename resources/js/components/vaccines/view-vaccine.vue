<template>
    <div class="row">
        <div class="col-md-12">
            <v-btn color="success" v-if="this.currentStatusVaccine === 0" @click="activeOrDisableVaccine()">
                Ativar
            </v-btn>
            <v-btn color="error" v-else @click="activeOrDisableVaccine()">
                Desativar
            </v-btn>

            <v-dialog
                v-model="dialogMain"
                max-width="600px"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="primary"
                        dark
                        v-bind="attrs"
                        v-on="on"
                    >
                        Gerir Marcas
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Gerir {{ nameCurrentVaccine }}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                >
                                    <v-simple-table>
                                        <template v-slot:default>
                                            <thead>
                                            <tr>
                                                <th class="text-left">
                                                    Nome
                                                </th>
                                                <th class="text-left">
                                                    Quantidade
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr
                                                v-for="item in listBrandVaccine"
                                                :key="item.id"
                                            >
                                                <td>{{ item.name }}</td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </template>
                                    </v-simple-table>

                                </v-col>
                                <v-col
                                    cols="12"
                                >
                                    <v-dialog
                                        v-model="dialogCreateBrand"
                                        max-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                color="primary"
                                                dark
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                                <v-icon>mdi-plus</v-icon>
                                                Nova Marca
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                            <span
                                                                class="text-h5">Nova marca para {{
                                                                    nameCurrentVaccine
                                                                }}</span>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col
                                                            cols="12"
                                                        >
                                                            <v-text-field
                                                                label="Nome da marca"
                                                                required
                                                                v-model="nameNewBrandVaccine"
                                                            ></v-text-field>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="dialogCreateBrand = false"
                                                >
                                                    Fechar
                                                </v-btn>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="createBrands()"
                                                >
                                                    Salvar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="dialogMain = false"
                        >
                            Fechar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
        <div class="col-md-12 mx-auto my-4 p-0">
            <v-expansion-panels :disabled="this.currentStatusVaccine === 0">
                <v-expansion-panel
                >
                    <v-expansion-panel-header>
                        <h4>Utentes sem Registro de vacina</h4>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-dialog
                                        v-model="dialogCreateVaccine"
                                        max-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                color="primary"
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                                <v-icon>mdi-plus</v-icon>
                                                Registrar dose
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                Registrar dose
                                            </v-card-title>
                                            <v-card-text>
                                                Registrando dose para {{ patientsSelected.length }} utentes
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <v-select
                                                            :items="listBrandVaccine"
                                                            item-text="name"
                                                            item-value="id"
                                                            v-model="selectedListBrands"
                                                            label="Marca da vacina"
                                                        >

                                                        </v-select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <v-menu
                                                            ref="menuDateRecordVaccine"
                                                            v-model="menuDateRecordVaccine"
                                                            :close-on-content-click="false"
                                                            transition="scale-transition"
                                                            offset-y
                                                            max-width="290px"
                                                            min-width="auto"
                                                        >
                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field
                                                                    v-model="dateRecordVaccineVm"
                                                                    label="Data da dose"
                                                                    persistent-hint
                                                                    prepend-icon="mdi-calendar"
                                                                    v-bind="attrs"
                                                                    v-on="on"
                                                                ></v-text-field>
                                                            </template>
                                                            <v-date-picker
                                                                v-model="dateRecordVaccine"
                                                                no-title
                                                                @input="menuDateRecordVaccine = false"
                                                            ></v-date-picker>
                                                        </v-menu>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <v-menu
                                                            ref="menuReturnDateRecordVaccine"
                                                            v-model="menuReturnDateRecordVaccine"
                                                            :close-on-content-click="false"
                                                            transition="scale-transition"
                                                            offset-y
                                                            max-width="290px"
                                                            min-width="auto"
                                                        >
                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field
                                                                    v-model="dateReturnRecordVaccineVm"
                                                                    label="Data do retorno"
                                                                    persistent-hint
                                                                    prepend-icon="mdi-calendar"
                                                                    v-bind="attrs"
                                                                    v-on="on"
                                                                ></v-text-field>
                                                            </template>
                                                            <v-date-picker
                                                                v-model="dateReturnRecordVaccine"
                                                                no-title
                                                                @input="menuReturnDateRecordVaccine = false"
                                                            ></v-date-picker>
                                                        </v-menu>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <v-text-field
                                                            label="Lote da vacina"
                                                            v-model="registerBatch"
                                                        >

                                                        </v-text-field>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <v-text-field
                                                            label="Informação adicional"
                                                            v-model="registerComments"
                                                        >

                                                        </v-text-field>
                                                    </div>
                                                </div>
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="dialogCreateVaccine = false"
                                                >
                                                    Fechar
                                                </v-btn>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="createRecordVaccine()"
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
                                    v-for="item in patientWithoutVaccineRecords"
                                    :label="item.name"
                                    v-bind:key="item.id"
                                    :value="item.id"
                                    class="col-md-3 col-12"
                                ></v-checkbox>
                            </div>
                        </div>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels> <!-- PACIENTES SEM REGISTRO DE VACINA -->
            <v-expansion-panels class="mt-3" :disabled="this.currentStatusVaccine === 0">
                <!-- PACIENTES COM REGISTRO DE VACINA -->
                <v-expansion-panel
                >
                    <v-expansion-panel-header>
                        <h4>Utentes com Registro de vacina</h4>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3 col-12"
                                     v-for="item in patientWithVaccineRecords"
                                     ref="x"
                                     v-bind:key="item.id">
                                    <v-card>
                                        <v-card-title>
                                            <h5>{{'Registro '+item.vaccineRecord}}</h5>
                                        </v-card-title>

                                        <v-card-subtitle>
                                            {{'Utente: '+item.name}}
                                        </v-card-subtitle>

                                        <v-card-actions>
                                            <v-btn
                                                color="primary"
                                                text
                                                @click="idCurrentVaccineRecord = item.vaccineRecord; editDialogVaccineDetails = true"
                                            >
                                                Gerenciar
                                            </v-btn>
                                            <v-btn
                                                color="error"
                                                text
                                                @click="deleteDialogItem(item.vaccineRecord);"
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
        <v-dialog
            v-model="confirmDialogDelete"
            persistent
            max-width="auto"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Deletar registro de vacina
                </v-card-title>
                <v-card-text>Ao confirmar, sua decisão não poderá ser revertida e o registro será excluído
                    permanentemente.
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="confirmDialogDelete = false; this.deleteItemId = 0;"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="success"
                        text
                        @click="deleteItem()"
                    >
                        Confirmar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-row justify="center">
            <v-dialog
                v-model="editDialogVaccineDetails"
                persistent
                max-width="auto"
            >
                <vaccine-edit
                    v-if="editDialogVaccineDetails"
                    :id-current-vaccine="idCurrentVaccine"
                    :id-current-vaccine-record="idCurrentVaccineRecord"
                    :base-url-api-vaccine-record="baseUrlApiVaccineRecord"
                    :base-url-api-vaccine-brand="baseUrlApiVaccineBrand"
                    @listenEditVaccines="listenEditVaccines"
                >

                </vaccine-edit>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
export default {
    name: "view",
    props: [
        'nameCurrentVaccine',
        'idCurrentVaccine',
        'baseUrlApi',
        'baseUrlApiBrand',
        'baseUrlApiVaccineRecord',
        'baseUrlApiVaccineBrand',
        'baseUrlToDetails',
        'baseUrlApiVaccinePatient'
    ],
    computed: {
        token() {
            let token = document.cookie.split(';').find(index => {
                return index.startsWith('token=')
            });

            token = token.split('=')[1];
            token = 'Bearer ' + token;

            return token;
        }
    },
    data: vm => ({
        alert: false,
        alertMessage: '',
        alertTime: 2000,
        dialogMain: false,
        dialogCreateBrand: false,
        dialogCreateVaccine: false,
        editDialogVaccineDetails: false,
        currentStatusVaccine: 0,
        nameNewBrandVaccine: '',
        idCurrentVaccineRecord: '',
        confirmDialogDelete: false,
        confirmDelete: false,
        listBrandVaccine: [],
        registerBatch: '',
        registerComments: '',
        selectedListBrands: null,
        patientWithVaccineRecords: [],
        patientWithoutVaccineRecords: [],
        patientsSelected: [],
        menuDateRecordVaccine: false,
        menuReturnDateRecordVaccine: false,
        dateRecordVaccine: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        dateRecordVaccineVm: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
        dateReturnRecordVaccine: null,
        dateReturnRecordVaccineVm: vm.formatDate(null),

    }),
    methods: {
        getListPatients() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };
            axios.get(this.baseUrlApiVaccinePatient, settings).then(
                (response) => {
                    this.patientWithVaccineRecords = [];
                    this.patientWithoutVaccineRecords = [];
                    response.data.forEach((patient) => {
                        if (patient.get_vaccines.length > 0) {
                            patient.get_vaccines.forEach((vaccine) => {
                                console.log(vaccine);
                                if (vaccine.vaccine == this.idCurrentVaccine) {
                                    this.patientWithVaccineRecords.push({id: patient.id, name: patient.name, vaccine: vaccine.vaccine, vaccineRecord: vaccine.id});
                                }
                            });
                        } else {
                            this.patientWithoutVaccineRecords.push({id: patient.id, name: patient.name});
                        }
                    })
                }
            );
        },
        listenEditVaccines(cancel){
            if (cancel) {
                this.editDialogVaccineDetails = false;
            } else {
                this.editDialogVaccineDetails = false;
                this.alert = true;
                this.alertMessage = 'Vacina atualizada com sucesso';
                this.getListPatients();
            }
        },
        deleteDialogItem(id) {
            this.confirmDialogDelete = true;
            this.deleteItemId = id;
        },
        deleteItem() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token(),
                },
                data: {
                    vaccineRecord: this.deleteItemId
                }
            };

            axios.delete(this.baseUrlApiVaccineRecord + '/' + this.deleteItemId, settings).then(
                (response) => {
                    this.confirmDialogDelete = false;
                    this.deleteItemId = 0;
                    this.alert = true;
                    this.alertMessage = 'Registro deletado';
                    this.getListPatients();
                }
            );
        },
        activeOrDisableVaccine() {

            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            if (this.currentStatusVaccine === 1) {

                this.currentStatusVaccine = 0;
                let data = {
                    status: this.currentStatusVaccine
                }

                axios.put(this.baseUrlApi + '/' + this.idCurrentVaccine, data, settings).then(
                    response => {
                        this.alert = true;
                        this.alertMessage = "Vacina desativada"
                    },
                    () => {
                        this.alert = true;
                        this.alertMessage = "Ocorreu um erro"
                    }
                )

            } else {

                this.currentStatusVaccine = 1;
                let data = {
                    status: this.currentStatusVaccine
                }

                axios.put(this.baseUrlApi + '/' + this.idCurrentVaccine, data, settings).then(
                    response => {
                        this.alert = true;
                        this.alertMessage = "Vacina ativada"
                    },
                    () => {
                        this.alert = true;
                        this.alertMessage = "Ocorreu um erro"
                    }
                )

            }
        },
        getStatusCurrentVaccine() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            axios.get(this.baseUrlApi + '/' + this.idCurrentVaccine, settings).then(
                response => {
                    this.currentStatusVaccine = response.data.status;
                }
            )
        },
        getBrands() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            axios.get(this.baseUrlApiVaccineBrand + '/' + this.idCurrentVaccine, settings).then(
                response => {
                    this.listBrandVaccine = response.data;
                }
            )
        },
        createBrands() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            let data = {
                name: this.nameNewBrandVaccine,
                vaccineId: this.idCurrentVaccine
            };

            axios.post(this.baseUrlApiBrand, data, settings).then(
                () => {
                    this.getBrands();
                    this.dialogCreateBrand = false;
                    this.nameNewBrandVaccine = '';
                },

                (error) => {
                    console.log(error);
                }
            )
        },
        createRecordVaccine() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            let data = {
                users: this.patientsSelected,
                vaccine: this.idCurrentVaccine,
                vaccineBrand: this.selectedListBrands,
                batch: this.registerBatch,
                comments: this.registerComments,
                data: this.dateRecordVaccine,
                returnDate: this.dateReturnRecordVaccine,

            };

            axios.post(this.baseUrlApiVaccineRecord, data, settings).then(
                (response) => {
                    this.dialogCreateVaccine = false;
                    this.patientWithoutVaccineRecords = [];
                    this.getListPatients();
                    this.alert = true;
                    this.alertMessage = "Dose de vacinada registrada com sucesso";
                },

                (error) => {
                    this.alert = true;
                    this.alertMessage = "Ocorreu um erro, tente novamente";
                }
            )
        },
        formatDate(date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${day}/${month}/${year}`
        },
    },
    watch: {
        dateRecordVaccine(val) {
            this.dateRecordVaccineVm = this.formatDate(this.dateRecordVaccine);
        },
        dateReturnRecordVaccine(val) {
            this.dateReturnRecordVaccineVm = this.formatDate(this.dateReturnRecordVaccine);
        }
    },
    mounted() {
        this.getBrands();
        this.getStatusCurrentVaccine();
        this.getListPatients();
    }
}
</script>

<style scoped>

</style>
