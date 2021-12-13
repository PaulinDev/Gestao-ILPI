<template>
    <div>
        <div class="col-md-12 px-0 mb-2">
            <v-dialog
                v-model="dialog"
                max-width="600px"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="primary"
                        dark
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-plus</v-icon>
                        Vacina
                    </v-btn>
                </template>
                <v-card class="v-application app-fix">
                    <v-card-title>
                        <span class="text-h5">Novo Grupo de Vacinas</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="6"
                                >
                                    <v-text-field
                                        label="Nome da vacina"
                                        required
                                        v-model="nameNewVaccine"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="6"
                                >
                                    <v-select
                                        :items="itemsSelect"
                                        v-model="selectVaccine"
                                        label="Status"
                                    >

                                    </v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="dialog = false"
                        >
                            Fechar
                        </v-btn>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="createVaccine()"
                        >
                            Salvar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
        <div class="row">
            <div class="col-md-6 h-100" v-for="item in vaccines">
                <v-card>
                    <v-card-title>
                        <v-icon color="primary" class="mr-3">fas fa-syringe</v-icon>
                        {{ item.name }}
                    </v-card-title>
                    <v-card-text class="row text-center p-0" v-if="item.status === 0">
                        <v-container>
                            <v-row>
                                <v-col cols="12" class="text-center">
                                    <h5>Vacina desativada</h5>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-text class="row text-center p-0" v-else>
                        <div class="col-md-4">
                            <v-chip
                                class="ma-2"
                                color="success"
                                text-color="white"
                                default
                            >
                                <v-avatar
                                    left
                                    class="success darken-4"
                                >
                                    {{ item.get_records_count }}
                                </v-avatar>
                                Aplicações
                            </v-chip>
                        </div>
                        <div class="col-md-4">
                            <v-chip
                                class="ma-2"
                                color="warning"
                                text-color="white"
                                default
                            >
                                <v-avatar
                                    left
                                    class="warning darken-4"
                                >
                                    {{ item.returnDate }}
                                </v-avatar>
                                Pendências
                            </v-chip>
                        </div>
                        <div class="col-md-4">
                            <v-chip
                                class="ma-2"
                                color="error"
                                text-color="white"
                                default
                            >
                                <v-avatar
                                    left
                                    class="error darken-4"
                                >
                                    {{item.PatientsWithoutRecords}}
                                </v-avatar>
                                Sem registro
                            </v-chip>
                        </div>
                    </v-card-text>
                    <v-divider class="mx-5"></v-divider>
                    <v-card-actions class="mx-3">
                        <v-btn
                            color="primary"
                            :href="baseUrlToView+'/'+item.id"
                        >
                            Gerenciar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index",
    props: [
        'baseUrlApi',
        'baseUrlToView',
    ],
    data() {
        return {
            vaccines: [
                {
                    id: null,
                    name: '',
                    status: false,
                    get_records_count: 0,
                    returnDate: 0,
                    PatientsWithoutRecords: 0,
                }
            ],
            dialog: false,
            nameNewVaccine: '',
            vaccineCount: [],
            selectVaccine: {
                text: 'Ativado',
                value: 1,
            },
            itemsSelect: [{
                text: 'Ativado',
                value: 1,
            }, {
                text: 'Desativado',
                value: 0,
            },]
        }
    },
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
    methods: {
        getVaccines() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };
            axios.get(this.baseUrlApi, settings).then(
                (response) => {
                    this.vaccines = response.data;
                }
            )
        },
        createVaccine() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            let data = {
                name: this.nameNewVaccine,
                status: this.selectVaccine.value
            };

            axios.post(this.baseUrlApi, data, settings).then(
                () => {
                    this.getVaccines();
                    this.dialog = false;
                    this.nameNewVaccine = '';
                    this.selectVaccine = {
                        text: 'Ativado',
                        value: 1,
                    };
                },

                (error) => {
                    console.log(error);
                }
            )
        }
    },
    mounted() {
        this.getVaccines();
    }
}
</script>

<style scoped>
</style>
