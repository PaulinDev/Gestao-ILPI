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
            <v-tab key="6">
                Responsavéis
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
                        <v-form class="mt-5" ref="formSubscription" lazy-validation v-model="formSubscription">
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
                                                disabled
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
                        </v-form>
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
                <v-card flat class="px-4 py-4">
                    <v-card-text>
                        <div class="row">
                            <div class="col-md-6"><h2 class="text-xl font-weight-semibold mb-2">Estoque</h2></div>
                            <v-dialog
                                v-model="dialogItem"
                                persistent
                                max-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <div class="col-md-6 px-0 py-0" style="text-align: right;">
                                        <v-btn
                                            color="primary"
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            <i class="fas fa-plus"></i> Item
                                        </v-btn>
                                    </div>
                                </template>
                                <patient-inventory-new
                                    :url-base-api-inventory-type="urlBaseApiInventoryType"
                                    :url-base-api-patient-inventory="urlBaseApiPatientInventory"
                                    :id-current-patient="idCurrentPatient"
                                    @inventoryNew="InventoryNew"
                                ></patient-inventory-new>
                            </v-dialog>
                        </div>
                        <v-divider></v-divider>
                        <small v-if="patientInfo.get_inventory === null">Utente ainda não possui estas informações
                            cadastradas</small>
                        <v-data-table
                            :headers="headersInventory"
                            :items="patientInventory"
                            :search="search"
                            :loading="loadingItems"
                            locale="pt"
                            loading-text="Carregando... Por favor aguarde"
                            v-if="!loadingTypeInventory"
                        >

                            <template v-slot:item.manufacturingDate="{ item }">
                                {{ datetimeToDate(item.manufacturingDate) }}
                            </template>

                            <template v-slot:item.type="{ item }">
                                {{ replaceTypeInventory(item.type) }}
                            </template>

                            <template v-slot:item.expirationDate="{ item }">
                                {{ datetimeToDate(item.expirationDate) }}
                            </template>

                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="editItemInventory = item.id; editDialogItemInventory = true;"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    @click="deleteItem = item.id; confirmDialogDelete = true"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item
                key="6"
            >
                <v-card flat class="px-4 py-4">
                    <v-card-text>
                        <div class="row">
                            <div class="col-md-6"><h2 class="text-xl font-weight-semibold mb-2">Responsáveis</h2></div>
                            <v-dialog
                                v-model="dialogNewGuardian"
                                max-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <div class="col-md-6 px-0 py-0" style="text-align: right;">
                                        <v-btn
                                            color="primary"
                                            v-bind="attrs"
                                            v-on="on"
                                            v-if="patientInfo.get_guardians === null || patientInfo.get_guardians.length === 0"
                                        >
                                            <i class="fas fa-plus"></i> Responsável
                                        </v-btn>
                                    </div>
                                </template>
                                <new-guardian
                                    v-if="dialogNewGuardian"
                                    :url-base-api-guardian="urlBaseApiGuardian"
                                    :url-base-api-genders="urlBaseApiGenders"
                                    :id-current-patient="idCurrentPatient"
                                    @listenNewGuardian="listenNewGuardian"
                                >

                                </new-guardian>
                            </v-dialog>
                        </div>
                        <v-divider></v-divider>
                        <small v-if="patientInfo.get_guardians === null">Utente ainda não possui estas informações
                            cadastradas</small>
                        <v-data-table
                            :headers="headersGuardian"
                            :items="patientGuardians"
                            :search="search"
                            :loading="loadingItems"
                            locale="pt"
                            loading-text="Carregando... Por favor aguarde"
                        >

                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    @click="deleteItemGuardian = item.id; confirmDialogDelete = true"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-tab-item>
        </v-tabs-items>

        <v-tabs
            v-model="tab2"
            background-color="primary"
            dark
            class="pt-10"
        >
            <v-tab key="1">
                Patologias
            </v-tab>
            <v-tab key="2">
                Terapêutica
            </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab2" class="mt-5" :rounded="true">
            <v-tab-item
                key="1"
            >
                <v-card flat class="px-4 py-4">
                    <v-card-text>
                        <div class="row">
                            <div class="col-md-6"><h2 class="text-xl font-weight-semibold mb-2">Patologias</h2></div>
                            <v-dialog
                                v-model="dialogItem"
                                persistent
                                max-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <div class="col-md-6 px-0 py-0" style="text-align: right;">
                                        <v-btn
                                            color="primary"
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            <i class="fas fa-plus"></i> Registro
                                        </v-btn>
                                    </div>
                                </template>
                                <pathology-new
                                    :url-base-api-pathology="urlBaseApiPathology"
                                    :url-base-api-pathology-record="urlBaseApiPathologyRecord"
                                    :id-current-patient="idCurrentPatient"
                                    @pathologyRecordNew="pathologyRecordNew"
                                ></pathology-new>
                            </v-dialog>
                        </div>
                        <v-divider></v-divider>
                        <small v-if="patientInfo.get_pathology === null">Utente ainda não possui estas informações
                            cadastradas</small>
                        <v-data-table
                            :headers="headersPathology"
                            :items="patientPathology"
                            :search="search"
                            :loading="loadingItems"
                            locale="pt"
                            loading-text="Carregando... Por favor aguarde"
                            v-if="!loadingTypePathology"
                        >
                            <template v-slot:item.pathologyId="{ item }">
                                {{ replaceTypePathology(item.pathologyId) }}
                            </template>

                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    @click="deletePathologyId = item.id; confirmDialogDeletePathology = true"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item
                key="2"
            >
                <v-card flat class="px-4 py-4">
                    <v-card-text>
                        <div class="row">
                            <div class="col-md-6"><h2 class="text-xl font-weight-semibold mb-2">Terapêutica</h2></div>
                            <v-dialog
                                v-model="dialogNewTherapy"
                                persistent
                                max-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <div class="col-md-6 px-0 py-0" style="text-align: right;">
                                        <v-btn
                                            color="primary"
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            <i class="fas fa-plus"></i> Registro
                                        </v-btn>
                                    </div>
                                </template>
                                <therapy-new
                                    :url-base-api-inventory-by-patient="urlBaseApiInventoryByPatient"
                                    :id-current-patient="idCurrentPatient"
                                    :url-base-api-therapy="urlBaseApiTherapy"
                                    :url-base-api-inventory-type="urlBaseApiInventoryType"
                                    :url-base-api-patient-inventory="urlBaseApiPatientInventory"
                                    @listenNewTherapy="listenNewTherapy"
                                ></therapy-new>
                            </v-dialog>
                        </div>
                        <v-divider></v-divider>
                        <small v-if="patientInfo.get_therapy === null">Utente ainda não possui estas informações
                            cadastradas</small>
                        <v-data-table
                            :headers="headersTherapy"
                            :items="patientTherapy"
                            :search="search"
                            :loading="loadingItems"
                            locale="pt"
                            loading-text="Carregando... Por favor aguarde"
                            v-if="!loadingTypePathology"
                        >
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    @click="editTherapy = item.id; editDialogPathology = true"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    @click="deleteTherapyId = item.id; confirmDialogDeleteTherapy = true"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
                    </v-card-text>
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
        <v-row justify="center">
            <v-dialog
                v-model="confirmDialogDelete"
                persistent
                max-width="auto"
            >
                <v-card>
                    <v-card-title class="text-h5">
                        Deletar item do estoque
                    </v-card-title>
                    <v-card-text>Ao confirmar, sua decisão não poderá ser revertida e o item será excluído
                        permanentemente.
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            text
                            @click="confirmDialogDelete = false; deleteItem = null"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            color="success"
                            text
                            @click="deleteItemInventory(deleteItem)"
                        >
                            Confirmar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <v-row justify="center">
            <v-dialog
                v-model="confirmDialogDeleteTherapy"
                persistent
                max-width="auto"
            >
                <v-card>
                    <v-card-title class="text-h5">
                        Deletar terapêutica associada
                    </v-card-title>
                    <v-card-text>Ao confirmar, sua decisão não poderá ser revertida e o registro será excluído
                        permanentemente.
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            text
                            @click="confirmDialogDeleteTherapy = false; deleteTherapyId = null"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            color="success"
                            text
                            @click="deleteTherapy(deleteTherapyId)"
                        >
                            Confirmar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <v-row justify="center">
            <v-dialog
                v-model="confirmDialogDeletePathology"
                persistent
                max-width="auto"
            >
                <v-card>
                    <v-card-title class="text-h5">
                        Deletar patologia associada
                    </v-card-title>
                    <v-card-text>Ao confirmar, sua decisão não poderá ser revertida e a patologia será excluída
                        permanentemente.
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            text
                            @click="confirmDialogDeletePathology = false; deletePathologyId = null"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            color="success"
                            text
                            @click="deletePathology(deletePathologyId)"
                        >
                            Confirmar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        <v-row justify="center">
            <v-dialog
                v-model="editDialogItemInventory"
                persistent
                max-width="auto"
            >
                <patient-inventory-edit
                    :id-current-item="editItemInventory"
                    :url-base-api-pathology="urlBaseApiPathology"
                    :url-base-api-pathology-record="urlBaseApiPathologyRecord"
                    @inventoryEdit="InventoryEdit"
                >
                </patient-inventory-edit>
            </v-dialog>
        </v-row>
        <v-row justify="center">
            <v-dialog
                v-model="editDialogPathology"
                persistent
                max-width="auto"
            >
                <therapy-edit
                    :url-base-api-inventory-by-patient="urlBaseApiInventoryByPatient"
                    :id-current-patient="idCurrentPatient"
                    :id-current-therapy="editTherapy"
                    :url-base-api-therapy="urlBaseApiTherapy"
                    :url-base-api-inventory-type="urlBaseApiInventoryType"
                    :url-base-api-patient-inventory="urlBaseApiPatientInventory"
                    @listenEditTherapy="listenEditTherapy"
                ></therapy-edit>
            </v-dialog>
        </v-row>
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
        'urlBaseApiTherapy',
        'urlBaseApiInventoryType',
        'urlBaseApiPatientInventory',
        'urlBaseApiPathology',
        'urlBaseApiPathologyRecord',
        'urlBaseApiInventoryByPatient',
        'urlBaseApiGuardian',
        'urlBaseApiGenders',
    ],
    data: vm => ({
        alert: false,
        alertMessage: '',
        alertTime: 2000,
        tab: null,
        tab2: null,
        formHealth: true,
        formCards: true,
        formAddress: true,
        formSubscription: true,
        search: '',
        deleteItem: null,
        deletePathologyId: null,
        deleteTherapyId: null,
        confirmDialogDelete: false,
        confirmDialogDeleteTherapy: false,
        confirmDialogDeletePathology: false,
        editDialogItemInventory: false,
        editDialogPathology: false,
        editItemInventory: null,
        editTherapy: null,
        loadingItems: true,
        dialogItem: false,
        dialogNewGuardian: false,
        dialogNewTherapy: false,
        loadingTypeInventory: true,
        loadingTypePathology: true,
        headersInventory: [
            {text: "Registro", value: "id"},
            {text: "Nome", value: "name"},
            {text: "Tipo", value: "type"},
            {text: "Quantidade", value: "quantity"},
            {text: "Fabricação", value: "manufacturingDate"},
            {text: "Vencimento", value: "expirationDate"},
            {text: "Ações", value: "actions"},
        ],
        headersPathology: [
            {text: "Registro", value: "id"},
            {text: "Patologia", value: "pathologyId"},
            {text: "Ações", value: "actions"},
        ],
        headersTherapy: [
            {text: "Registro", value: "id"},
            {text: "Nome", value: "title"},
            {text: "Ações", value: "actions"},
        ],
        headersGuardian: [
            {text: "Registro", value: "id"},
            {text: "Nome", value: "name"},
            {text: "Ações", value: "actions"},
        ],
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
            get_address: null,
            get_inventory: null,
            get_pathology: null,
            get_therapy: null,
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
        patientInventory: [{
            id: null,
            name: '',
            quantity: null,
            expirationDate: null,
            manufacturingDate: null,
            patientId: null,
            userId: null,
            type: null,
        }],
        patientPathology: [{
            id: null,
            patientId: null,
            pathologyId: null,
        }],
        patientTherapy: [{
            id: null,
            title: '',
            medicine: null,
            patientId: null,
            dateStart: null,
            dateEnd: null,
            additional: ''
        }],
        patientGuardians: [{
            id: null,
            name: '',
            post: null,
            permission: null,
            type: null,
            birthdate: null,
            address: null,
            patientId: null,
            userCpf: null,
            userRg: null,
            email: null,
            gender: ''
        }],
        inventoryType: '',
        pathologyType: '',
        dateAdmission: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        dateAdmissionVm: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
        menuDateAdmission: false,
        rules: {
            required: value => !!value || 'Preenchimento obrigatório.',
            min: v => v.length >= 8 || 'Este campo precisa ter no minímo 8 caracteres',
            emailMatch: () => (`The email and password you entered don't match`),
        },
    }),
    methods: {
        InventoryNew(cancel) {
            if (cancel) {
                this.dialogItem = false;
            } else {
                this.dialogItem = false;
                this.alert = true;
                this.alertMessage = 'Novo item de estoque cadastrado com sucesso';
                this.getPatient();
            }
        },
        pathologyRecordNew(cancel) {
            if (cancel) {
                this.dialogItem = false;
            } else {
                this.dialogItem = false;
                this.alert = true;
                this.alertMessage = 'Patologia registras ao utente com sucesso';
                this.getPatient();
            }
        },
        listenNewGuardian(cancel) {
            if (cancel) {
                this.dialogNewGuardian = false;
            } else {
                this.dialogNewGuardian = false;
                this.alert = true;
                this.alertMessage = 'Responsável cadastrado com sucesso';
                this.getPatient();
            }
        },
        listenNewTherapy(cancel) {
            if (cancel) {
                this.dialogNewTherapy = false;
            } else {
                this.dialogNewTherapy = false;
                this.alert = true;
                this.alertMessage = 'Terapêutica registrada ao utente com sucesso';
                this.getPatient();
            }
        },
        listenEditTherapy(cancel) {
            if (cancel) {
                this.editDialogPathology = false;
            } else {
                this.editDialogPathology = false;
                this.alert = true;
                this.alertMessage = 'Terapêutica atualizado com sucesso';
                this.getPatient();
            }
        },
        InventoryEdit(cancel) {
            if (cancel) {
                this.dialogItem = false;
            } else {
                this.editDialogItemInventory = false;
                this.alert = true;
                this.alertMessage = 'Item do estoque atualizado com sucesso';
                this.getPatient();
            }
        },
        pathologyRecordEdit(cancel) {
            if (cancel) {
                this.editDialogPathology = false;
            } else {
                this.editDialogPathology = false;
                this.alert = true;
                this.alertMessage = 'Registro de patologia atualizado com sucesso';
                this.getPatient();
            }
        },
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

                    if (this.patientInfo.get_inventory !== null) {
                        this.patientInventory = this.patientInfo.get_inventory;
                    }

                    if (this.patientInfo.get_pathology !== null) {
                        this.patientPathology = this.patientInfo.get_pathology;
                    }

                    if (this.patientInfo.get_therapy !== null) {
                        this.patientTherapy = this.patientInfo.get_therapy;
                    }

                    if (this.patientInfo.get_guardians !== null) {
                        console.log(this.patientGuardians);
                        this.patientGuardians = this.patientInfo.get_guardians;
                        console.log('this.patientGuardians');
                        console.log(this.patientGuardians);
                    }

                    this.loadingItems = false;
                    this.dateAdmission = this.patientInfo.admission;
                }
            );
        },
        getTypeInventory() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiInventoryType, settings).then(
                (response) => {
                    this.inventoryType = response.data;
                    this.loadingTypePathology = false;
                }
            );

        },
        getTypePathology() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiPathology, settings).then(
                (response) => {
                    this.pathologyType = response.data;
                    this.loadingTypeInventory = false;
                }
            );

        },
        deleteItemInventory(item) {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                },
                data: {
                    item: item
                }
            };
            axios.delete(this.urlBaseApiPatientInventory + '/' + item, settings).then(
                (response) => {
                    console.log(response);
                    this.alert = true;
                    this.alertMessage = 'Item do estoque removido com sucesso';
                    this.confirmDialogDelete = false;
                    this.getPatient();
                }
            );

        },
        deletePathology(item) {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                },
                data: {
                    id: item
                }
            };
            axios.delete(this.urlBaseApiPathologyRecord + '/' + item, settings).then(
                (response) => {
                    this.alert = true;
                    this.alertMessage = 'Patologia removida com sucesso';
                    this.confirmDialogDeletePathology = false;
                    this.getPatient();
                }
            );

        },
        deleteTherapy(item) {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                },
                data: {
                    id: item
                }
            };
            axios.delete(this.urlBaseApiTherapy + '/' + item, settings).then(
                (response) => {
                    this.alert = true;
                    this.alertMessage = 'Terapêutica removida com sucesso';
                    this.confirmDialogDeleteTherapy = false;
                    this.getPatient();
                }
            );

        },
        replaceTypeInventory(id) {
            return this.inventoryType.find(x => x.id === id).name;
        },
        replaceTypePathology(id) {
            return this.pathologyType.find(x => x.id === id).name;
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
        },
        datetimeToDate: function (date) {
            let getDate = new Date(date),
                day = getDate.getDate(),
                month = getDate.getMonth(),
                year = getDate.getFullYear();
            return day + '/' + month + '/' + year;
        },
    },
    watch: {
        dateAdmission(val) {
            this.dateAdmissionVm = this.formatDate(this.dateAdmission);
        }
    },
    mounted() {
        this.getPatient();
        this.getTypeInventory();
        this.getTypePathology();
        this.patientHealth.patient = this.idCurrentPatient;
        this.patientCards.patient = this.idCurrentPatient;
        this.patientAddress.patient = this.idCurrentPatient;
    }
}
</script>

<style scoped>

</style>
