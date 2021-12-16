<template>
    <div>
        <v-card class="col-md-12">
            <template slot="progress">
                <v-progress-linear
                    color="deep-purple"
                    height="10"
                    indeterminate
                ></v-progress-linear>
            </template>

            <v-card-title class="justify-center flex-column" v-if="!loadingPatient">
                <v-avatar size="120" tile :rounded="true" class="mb-4">
                    <v-img
                        height="120"
                        max-width="120"
                        src="https://themeselection.com/demo/materio-vuetify-vuejs-admin-template/demo-1/img/2.80504cd9.png"
                    ></v-img>
                </v-avatar>
                <span class="mb-2" style="color: rgba(94, 86, 105, 0.87) !important">{{
                        patientInfo.name
                    }}</span>
                <v-chip class="ma-2" color="primary" pill>
                    <v-icon> mdi-account-outline</v-icon>
                    {{ patientInfo.get_occupation.description }}
                </v-chip>

                <div class="row">
                    <div class="col-md-4">
                        <v-dialog
                            v-model="dialogPathology"
                            max-width="auto"
                            width="1200"
                            height="auto"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    v-bind="attrs"
                                    v-on="on" color="primary" class="ml-1 align-self-center" text
                                    :disabled="patientInfo.get_pathology.length === 0">
                                    Patologias
                                </v-btn>
                            </template>

                            <v-card>
                                <v-card-text>
                                    <h2 class="text-xl font-weight-semibold mb-2">Patologias</h2>
                                    <v-divider></v-divider>
                                    <div v-for="pathology in patientInfo.get_pathology" v-if="!loadingTypePathology">
                                        <v-divider></v-divider>
                                        <v-list-item class="px-0">
                                            <v-list-item-content>
                                                <v-list-item-title>Nome</v-list-item-title>
                                                <v-list-item-subtitle>{{ replaceTypePathology(pathology.pathologyId) }}</v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </div>

                    <div class="col-md-4">
                        <v-dialog
                            v-model="dialogTherapy"
                            max-width="auto"
                            width="1200"
                            height="auto"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    v-bind="attrs"
                                    v-on="on" color="primary" class="ml-1 align-self-center" text
                                    :disabled="patientInfo.get_therapy.length === 0">
                                    Terapêutica
                                </v-btn>
                            </template>

                            <v-card>
                                <v-card-text>
                                    <h2 class="text-xl font-weight-semibold mb-2">Terapêutica</h2>
                                    <v-divider></v-divider>
                                    <div v-for="therapy in patientInfo.get_therapy">
                                        <v-divider></v-divider>
                                        <v-list-item class="px-0">
                                            <v-list-item-content>
                                                <v-list-item-title>Nome</v-list-item-title>
                                                <v-list-item-subtitle>{{ therapy.title }}</v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item class="px-0">
                                            <v-list-item-content>
                                                <v-list-item-title>Data de início</v-list-item-title>
                                                <v-list-item-subtitle>{{
                                                        datetimeToDate(therapy.dateStart)
                                                    }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item class="px-0">
                                            <v-list-item-content>
                                                <v-list-item-title>Data de término</v-list-item-title>
                                                <v-list-item-subtitle>{{
                                                        datetimeToDate(therapy.dateEnd)
                                                    }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item class="px-0">
                                            <v-list-item-content>
                                                <v-list-item-title>Informações adicionais</v-list-item-title>
                                                <v-list-item-subtitle>{{
                                                        therapy.additional
                                                    }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </div>
                    <div class="col-md-4">
                        <v-dialog
                            v-model="dialogInventory"
                            max-width="auto"
                            width="1200"
                            height="auto"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    v-bind="attrs"
                                    v-on="on" color="primary" class="ml-1 align-self-center" text
                                    :disabled="patientInfo.get_inventory.length === 0">
                                    Medicamentos
                                </v-btn>
                            </template>

                            <v-card>
                                <v-card-text>
                                    <h2 class="text-xl font-weight-semibold mb-2">Medicamentos</h2>
                                    <v-divider></v-divider>
                                    <div v-for="inventory in patientInfo.get_inventory">
                                        <v-divider></v-divider>
                                        <v-list-item class="px-0">
                                            <v-list-item-content>
                                                <v-list-item-title>Nome</v-list-item-title>
                                                <v-list-item-subtitle>{{ inventory.name }}</v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item class="px-0">
                                            <v-list-item-content>
                                                <v-list-item-title>Quantidade</v-list-item-title>
                                                <v-list-item-subtitle v-if="!loadingTypeInventory">{{
                                                        inventory.quantity+' '+replaceTypeInventory(inventory.type)
                                                    }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </div>
                </div>
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
                        <v-list-item-subtitle>{{
                                this.datetimeToDate(patientInfo.birthdate)
                            }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Data de admissão</v-list-item-title>
                        <v-list-item-subtitle>{{
                                this.datetimeToDate(patientInfo.admission)
                            }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Gênero</v-list-item-title>
                        <v-list-item-subtitle>{{
                                patientInfo.get_gender.description
                            }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Estado civil</v-list-item-title>
                        <v-list-item-subtitle>{{
                                patientInfo.get_civil.description
                            }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Grau de escolaridade</v-list-item-title>
                        <v-list-item-subtitle>{{
                                patientInfo.get_education.description
                            }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>Profissão</v-list-item-title>
                        <v-list-item-subtitle>{{
                                patientInfo.get_occupation.description
                            }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item class="px-0">
                    <v-list-item-content>
                        <v-list-item-title>País de origem</v-list-item-title>
                        <v-list-item-subtitle>{{
                                patientInfo.get_country.name
                            }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <h2 class="text-xl font-weight-semibold mb-2">Saúde <span v-if="patientInfo.get_health === null"
                                                                          style="font-size: 10px"> - Essas informações ainda não foram cadastradas</span>
                </h2>
                <v-divider></v-divider>
                <div v-if="patientInfo.get_health !== null">
                    <v-list-item class="px-0" v-if="patientInfo.get_health.bloodGroup !== null">
                        <v-list-item-content>
                            <v-list-item-title>Grupo Sanguíneo</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_health.bloodGroup
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_health.healthCenter !== null">
                        <v-list-item-content>
                            <v-list-item-title>Centro de saúde</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_health.healthCenter
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_health.doctor !== null">
                        <v-list-item-content>
                            <v-list-item-title>Médico</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_health.doctor
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_health.contact !== null">
                        <v-list-item-content>
                            <v-list-item-title>Contato</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_health.contact
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </div>
                <h2 class="text-xl font-weight-semibold mb-2">Cartões <span v-if="patientInfo.get_cards === null"
                                                                            style="font-size: 10px"> - Essas informações ainda não foram cadastradas</span>
                </h2>
                <v-divider></v-divider>
                <div v-if="patientInfo.get_cards !== null">
                    <v-list-item class="px-0" v-if="patientInfo.get_cards.card !== null">
                        <v-list-item-content>
                            <v-list-item-title>Cartões</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_cards.card
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_cards.contribution !== null">
                        <v-list-item-content>
                            <v-list-item-title>Contribuinte</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_cards.contribution
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_cards.securitySocial !== null">
                        <v-list-item-content>
                            <v-list-item-title>Segurança social</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_cards.securitySocial
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_cards.systemHealth !== null">
                        <v-list-item-content>
                            <v-list-item-title>Subsistema de saúde</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_cards.contribution
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </div>
                <h2 class="text-xl font-weight-semibold mb-2">Contato <span v-if="patientInfo.get_address === null"
                                                                            style="font-size: 10px"> - Essas informações ainda não foram cadastradas</span>
                </h2>
                <v-divider></v-divider>
                <div v-if="patientInfo.get_address !== null">
                    <v-list-item class="px-0" v-if="patientInfo.get_address.address !== null">
                        <v-list-item-content>
                            <v-list-item-title>Endereço</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_address.address
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_address.cep !== null">
                        <v-list-item-content>
                            <v-list-item-title>Cep</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_address.cep
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_address.phone !== null">
                        <v-list-item-content>
                            <v-list-item-title>Telefone</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_address.phone
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-0" v-if="patientInfo.get_address.email !== null">
                        <v-list-item-content>
                            <v-list-item-title>E-mail</v-list-item-title>
                            <v-list-item-subtitle>{{
                                    patientInfo.get_address.email
                                }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </div>
            </v-card-text>
        </v-card>
        <v-snackbar v-model="alert" :timeout="alertTime">
            {{ alertMessage }}

            <template v-slot:action="{ attrs }">
                <v-btn color="blue" text v-bind="attrs" @click="alert = false">
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
        "idCurrentPatient",
        "urlBaseApi",
        "urlBaseApiGenders",
        "urlBaseApiCivil",
        'urlBaseApiTherapy',
        'urlBaseApiInventoryType',
        'urlBaseApiPathology',
        "urlBaseApiCountry",
        "urlBaseApiEducation",
        "urlBaseApiOccupation",
        "relative"
    ],
    data() {
        return {
            alert: false,
            alertMessage: "",
            alertTime: 2000,
            patientInfo: {
                name: "",
                nick: "",
                birthdate: "",
                gender: "",
                photo: "",
                civil: "",
                education: "",
                occupation: "",
                admission: "",
                country: "",
                situation: "",
            },
            photoUser: null,
            inventoryType: '',
            loadingTypeInventory: true,
            loadingTypePathology: true,
            loadingPatient: true,
            pathologyType: '',
            dialogEditPatient: false,
            dialogInventory: false,
            dialogPhotoPatient: false,
            dialogPathology: false,
            dialogTherapy: false,
        };
    },
    methods: {
        getPatient() {
            let settings = {
                headers: {
                    Accept: "application/json",
                    Authorization: this.$root.token(),
                },
            };
            axios
                .get(this.urlBaseApi + "/" + this.idCurrentPatient, settings)
                .then((response) => {
                    this.patientInfo = response.data;
                    this.loadingPatient = false;
                });
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
                    this.loadingTypeInventory = false;
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
                    this.loadingTypePathology = false;
                }
            );

        },
        replaceTypeInventory(id) {
            return this.inventoryType.find(x => x.id === id).name;
        },
        replaceTypePathology(id) {
            return this.pathologyType.find(x => x.id === id).name;
        },
        datetimeToDate: function (date) {
            let getDate = new Date(date),
                day = getDate.getDate(),
                month = getDate.getMonth(),
                year = getDate.getFullYear(),
                monthNames = [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro",
                ];

            return day + " de " + monthNames[month] + " de " + year;
        },
    },
    mounted() {
        this.getPatient();
        this.getTypeInventory();
        this.getTypePathology();
    },
};
</script>

<style scoped>
</style>
