<template>
    <div>
        <v-card class="px-5 py-3">

            <v-form class="mt-5" ref="formValidate" lazy-validation v-model="formValidate">

                <v-card-title>
                    <span class="text-h5">Registrar patologia</span>
                </v-card-title>

                <v-card-text>
                    <div class="row">
                        <div class="col-md-9">
                            <v-autocomplete
                                :items="itemPathologyList"
                                v-model="selectedPathologies"
                                label="Patologia"
                                :loading="loadingItemsPathology"
                                class="col-md-12 align-self-end"
                                multiple
                            ></v-autocomplete>
                        </div>
                        <v-dialog
                            v-model="dialogNewPathology"
                            max-width="auto"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    v-bind="attrs"
                                    v-on="on" color="primary" class="col-md-2 align-self-center">
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">Cadastrar Patologia</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                md="12"
                                            >
                                                <v-text-field
                                                    label="Nome da Patologia"
                                                    required
                                                    v-model="newPathologyName"
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
                                        @click="dialogNewPathology = false"
                                    >
                                        Cancelar
                                    </v-btn>
                                    <v-btn
                                        color="success"
                                        text
                                        @click="createNewPathology()"
                                    >
                                        Salvar
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="$emit('pathologyRecordNew',true)"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="success"
                        text
                        @click="requestNewRecordPathology()"
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
        'idCurrentPatient',
        'urlBaseApiPathology',
        'urlBaseApiPathologyRecord'
    ],
    data: vm => ({
        alert: false,
        alertMessage: '',
        alertTime: 2000,
        formValidate: false,
        newPathologyName: '',
        selectedPathologies: [],
        pathologyRecord: {
            pathologyId: null,
            patientId: null,
        },
        itemPathologyList: [],
        loadingItemsPathology: true,
        dialogNewPathology: false,

    }),
    methods: {
        createNewPathology() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            let data = {
                name: this.newPathologyName,
            };

            axios.post(this.urlBaseApiPathology, data, settings)
                .then(response => {
                    this.alert = true;
                    this.alertMessage = 'Nova patologia cadastrada com sucesso';
                    this.dialogNewPathology = false;
                    this.getAllPathologies();
                }).catch(error => {
                this.alert = true;
                this.alertMessage = 'Houve um erro, tente novamente';
            })
        },
        requestNewRecordPathology() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = this.pathologyRecord;
            data.pathologyId = this.selectedPathologies;

            axios.post(this.urlBaseApiPathologyRecord, data, settings)
                .then(response => {
                    this.$emit('pathologyRecordNew');
                }).catch(error => {
                console.log(error);
                this.alert = true;
                this.alertMessage = 'Houve um erro, tente novamente';
            })
        },
        getAllPathologies() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiPathology, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.itemPathologyList.push({text: item.name, value: item.id})
                    });
                    this.loadingItemsPathology = false;
                }
            )
        },
    },
    mounted() {
        this.getAllPathologies();
        this.pathologyRecord.patientId = this.idCurrentPatient;
    }
}
</script>

<style scoped>

</style>
