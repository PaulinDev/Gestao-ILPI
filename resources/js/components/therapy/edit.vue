<template>
    <div>
        <v-card class="px-5 py-3">

            <v-form class="mt-5" ref="formValidate" lazy-validation v-model="formValidate">

                <v-card-title>
                    <span class="text-h5">Editar Terapêutica</span>
                </v-card-title>

                <v-card-text>
                    <div class="row">
                        <div class="col-md-4">
                            <v-text-field
                                label="Título"
                                v-model="therapy.title"
                                required
                            ></v-text-field>
                        </div>
                        <div class="col-md-8" style="align-self: end;">
                            <div class="row">
                                <v-autocomplete
                                    v-model="therapy.medicine"
                                    :items="inventory"
                                    item-text="name"
                                    item-value="id"
                                    label="Medicamento"
                                    :loading="loadItemType"
                                    class="col-md-9"
                                ></v-autocomplete>
                                <v-dialog
                                    v-model="dialogNewTypeItem"
                                    max-width="auto"
                                    class="col-md-2"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            v-bind="attrs"
                                            v-on="on" color="primary" class="col-md-2 align-self-center">
                                            <v-icon>mdi-plus</v-icon>
                                        </v-btn>
                                    </template>
                                    <patient-inventory-new
                                        :url-base-api-inventory-type="urlBaseApiInventoryType"
                                        :url-base-api-patient-inventory="urlBaseApiPatientInventory"
                                        :id-current-patient="idCurrentPatient"
                                        @inventoryNew="InventoryNew"
                                    ></patient-inventory-new>
                                </v-dialog>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <v-menu
                                ref="menuDateStart"
                                v-model="menuDateStart"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="startDateVm"
                                        label="Data de início"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="dateStart"
                                    no-title
                                    @input="menuDateStart = false"
                                ></v-date-picker>
                            </v-menu>
                        </div>
                        <div class="col-md-6">
                            <v-menu
                                ref="menuDateEnd"
                                v-model="menuDateEnd"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="dateEndVm"
                                        label="Data de término"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="dateEnd"
                                    no-title
                                    @input="menuDateEnd = false"
                                ></v-date-picker>
                            </v-menu>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <v-textarea
                                v-model="therapy.additional"
                                label="Informações adicionais"
                            >

                            </v-textarea>
                        </div>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="$emit('listenEditTherapy',true);"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="success"
                        text
                        @click="requestEditTherapy()"
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
        'urlBaseApiInventoryType',
        'urlBaseApiPatientInventory',
        'urlBaseApiInventoryByPatient',
        'idCurrentPatient',
        'idCurrentTherapy',
        'urlBaseApiTherapy',
    ],
    data: vm => ({
        alert: false,
        alertMessage: '',
        alertTime: 2000,
        formValidate: false,
        newTypeItem: '',
        inventory: [{
            id: null,
            name: '',
            quantity: '',
            expirationDate: null,
            manufacturingDate: null,
            patientId: null,
            userId: null,
            type: null
        }],
        therapy: {
            id: null,
            title: '',
            medicine: null,
            patientId: null,
            dateStart: null,
            dateEnd: null,
            additional: '',
        },
        loadItemType: true,
        dialogNewTypeItem: false,
        menuDateStart: false,
        menuDateEnd: false,
        dateStart: null,
        dateEnd: null,
        startDateVm: vm.formatDate(null),
        dateEndVm: vm.formatDate(null),

    }),
    methods: {
        getAllInventory() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiInventoryByPatient + '/' + this.idCurrentPatient, settings).then(
                (response) => {
                    this.inventory = response.data;
                    this.loadItemType = false;
                }
            )
        },
        getTherapy(){
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiTherapy + '/' + this.idCurrentTherapy, settings).then(
                (response) => {
                    this.therapy = response.data;
                    this.dateStart = this.therapy.dateStart;
                    this.dateEnd = this.therapy.dateEnd;
                }
            )
        },
        InventoryNew(cancel) {
            if (cancel) {
                this.dialogNewTypeItem = false;
            } else {
                this.dialogNewTypeItem = false;
                this.alert = true;
                this.alertMessage = 'Novo item de estoque cadastrado com sucesso';
                this.getPatient();
            }
        },
        requestEditTherapy(){
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = this.therapy;
            data.dateStart = this.dateStart;
            data.dateEnd = this.dateEnd;

            axios.put(this.urlBaseApiTherapy+'/'+this.therapy.id, data, settings)
                .then(response => {
                    this.$emit('listenEditTherapy');
                }).catch(error => {
                console.log(error);
                this.alert = true;
                this.alertMessage = 'Houve um erro, tente novamente';
            })
        },
        formatDate(date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${day}/${month}/${year}`
        },
        parseDate(date) {
            if (!date) return null

            const [month, day, year] = date.split('/')
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        },
    },
    watch: {
        dateStart(val) {
            this.startDateVm = this.formatDate(this.dateStart);
        },
        dateEnd(val) {
            this.dateEndVm = this.formatDate(this.dateEnd);
        },
    },
    mounted() {
        this.getAllInventory();
        this.getTherapy();
        this.therapy.patientId = this.idCurrentPatient;
    }
}
</script>

<style scoped>

</style>
