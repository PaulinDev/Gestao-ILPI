<template>
    <div>
        <v-card class="px-5 py-3">

            <v-form class="mt-5" ref="formValidate" lazy-validation v-model="formValidate">

                <v-card-title>
                    <span class="text-h5">Editar item</span>
                </v-card-title>

                <v-card-text>
                    <div class="row">
                        <div class="col-md-3">
                            <v-text-field
                                label="Nome do Item"
                                required
                                v-model="inventoryItem.name"
                            ></v-text-field>
                        </div>
                        <div class="col-md-6 row">
                            <v-autocomplete
                                :items="itemTypeList"
                                v-model="inventoryItem.type"
                                label="Tipo de item"
                                :loading="loadItemType"
                                class="col-md-9 align-self-end"
                            ></v-autocomplete>
                            <v-dialog
                                v-model="dialogNewTypeItem"
                                max-width="600px"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        v-bind="attrs"
                                        v-on="on" color="primary" class="ml-1 col-md-2 align-self-center">
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="text-h5">Cadastrar tipo de item</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col
                                                    cols="12"
                                                    md="12"
                                                >
                                                    <v-text-field
                                                        label="Nome do Tipo"
                                                        required
                                                        v-model="newTypeItem"
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
                                            @click="dialogNewTypeItem = false"
                                        >
                                            Cancelar
                                        </v-btn>
                                        <v-btn
                                            color="success"
                                            text
                                            @click="createNewItemType()"
                                        >
                                            Salvar
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </div>
                        <div class="col-md-3">
                            <v-text-field
                                label="Quantidade"
                                required
                                v-model="inventoryItem.quantity"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <v-menu
                                ref="menuManufacturingDate"
                                v-model="menuManufacturingDate"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="manufacturingVm"
                                        label="Data de fabricação"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="dateManufacturing"
                                    no-title
                                    @input="menuManufacturingDate = false"
                                ></v-date-picker>
                            </v-menu>
                        </div>
                        <div class="col-md-4">
                            <v-menu
                                ref="menuExpirationDate"
                                v-model="menuExpirationDate"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="expirationDateVm"
                                        label="Data de vencimento"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="dateExpiration"
                                    no-title
                                    @input="menuExpirationDate = false"
                                ></v-date-picker>
                            </v-menu>
                        </div>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="$emit('inventoryEdit', true)"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="success"
                        text
                        @click="editNewItemType()"
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
        'idCurrentItem'
    ],
    data: vm => ({
        alert: false,
        alertMessage: '',
        alertTime: 2000,
        formValidate: false,
        inventoryItem: {
            name: '',
            type: null,
            quantity: null,
            expirationDate: null,
            manufacturingDate: null,
            patientId: null,
            userId: null
        },
        newTypeItem: '',
        itemTypeList: [],
        loadItemType: true,
        dialogNewTypeItem: false,
        menuManufacturingDate: false,
        menuExpirationDate: false,
        dateManufacturing: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        dateExpiration: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        manufacturingVm: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
        expirationDateVm: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),

    }),
    methods: {
        createNewItemType() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            let data = {
                name: this.newTypeItem,
            };

            axios.post(this.urlBaseApiInventoryType, data, settings)
                .then(response => {
                    this.alert = true;
                    this.alertMessage = 'Novo tipo de item cadastrado com sucesso';
                    this.dialogNewTypeItem = false;
                    this.getAllItemType();
                }).catch(error => {
                this.alert = true;
                this.alertMessage = 'Houve um erro, tente novamente';
            })
        },
        getInventory(){
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiPatientInventory + '/' + this.idCurrentItem, settings).then(
                (response) => {
                    this.inventoryItem = response.data;
                    this.dateExpiration = this.inventoryItem.expirationDate;
                    this.dateManufacturing = this.inventoryItem.manufacturingDate;
                }
            );
        },
        editNewItemType() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = this.inventoryItem;

            data.manufacturingDate = this.dateManufacturing;
            data.expirationDate = this.dateExpiration;

            axios.put(this.urlBaseApiPatientInventory + '/' + this.idCurrentItem, data, settings)
                .then(response => {
                    this.$emit('inventoryEdit');
                }).catch(error => {
                this.alert = true;
                this.alertMessage = 'Houve um erro, tente novamente';
            })
        },
        getAllItemType() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiInventoryType, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.itemTypeList.push({text: item.name, value: item.id})
                    });
                    this.loadItemType = false;
                }
            )
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
        dateManufacturing(val) {
            this.manufacturingVm = this.formatDate(this.dateManufacturing);
            this.inventoryItem.manufacturingDate = this.manufacturingVm;
        },
        dateExpiration(val) {
            this.expirationDateVm = this.formatDate(this.dateExpiration);
            this.inventoryItem.expirationDate = this.expirationDateVm;
        },
    },
    mounted() {
        this.getAllItemType();
        this.getInventory();
        this.inventoryItem.patientId = this.idCurrentPatient;
    }
}
</script>

<style scoped>

</style>
