<template>
    <div>
        <div class="col-md-12 px-0 mb-2">
            <v-dialog
                v-model="dialogNewGroup"
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
                        Grupo
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Novo Grupo de Atividades</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                >
                                    <v-text-field
                                        label="Nome do grupo"
                                        required
                                        v-model="nameNewGroup"
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
                            @click="dialogNewGroup = false"
                        >
                            Fechar
                        </v-btn>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="createGroup()"
                        >
                            Salvar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
        <div class="row">
            <div v-if="this.groups.length > 0" class="row">
                <div class="col-md-6 col-12" v-for="item in this.groups">
                    <v-card
                        elevation="2"
                        class="p-2"
                    >
                        <v-card-title class="p-0">
                            <div class="row">
                                <div class="col-md-6 col-12">{{ item.name }}</div>
                                <div class="col-md-6 col-12 d-flex" style="justify-content: end;">
                                    <v-dialog
                                        v-model="dialogNewActivity"
                                        max-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                color="success"
                                                class="mr-1"
                                                @click="dialogNewActivity = true"
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                                <v-icon>mdi-plus</v-icon>
                                                Atividade
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="text-h5">Nova atividade</span>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col
                                                            cols="12"
                                                        >
                                                            <v-text-field
                                                                label="Nome da atividade"
                                                                required
                                                                v-model="nameNewActivity"
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
                                                    @click="dialogNewActivity = false"
                                                >
                                                    Fechar
                                                </v-btn>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="createActivity(item.id)"
                                                >
                                                    Salvar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <v-dialog
                                        v-model="dialogEditGroup"
                                        max-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                color="primary"
                                                class="mr-1"
                                                @click="dialogEditGroup = true"
                                                v-bind="attrs"
                                                v-on="on"
                                            >Gerir
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="text-h5">Editar Grupo</span>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col
                                                            cols="6"
                                                        >
                                                            <v-text-field
                                                                label="Nome do grupo"
                                                                required
                                                                v-model="item.name"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="6"
                                                        >
                                                            <v-switch
                                                                v-model="item.status"
                                                                v-if="item.status"
                                                                label="Status do Grupo: Ativado"
                                                            ></v-switch>
                                                            <v-switch
                                                                v-model="item.status"
                                                                v-if="!item.status"
                                                                label="Status do Grupo: Desativado"
                                                            ></v-switch>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="dialogEditGroup = false"
                                                >
                                                    Fechar
                                                </v-btn>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="editGroup(item)"
                                                >
                                                    Salvar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </div>
                            </div>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div v-if="item.get_activities.length > 0 && item.status">
                                <div class="row">
                                    <div v-for="activities in item.get_activities">
                                        <div class="col-md-6">
                                            <v-btn :href="routeViewActivity+'/'+activities.id" color="secondary" dark>
                                                {{ activities.name }}
                                            </v-btn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <v-card-subtitle class="p-0" v-if="!item.status">Grupo desativado</v-card-subtitle>
                                <v-card-subtitle class="p-0" v-else>Nenhuma atividade cadastrada</v-card-subtitle>
                            </div>
                        </v-card-text>
                    </v-card>
                </div>
            </div>
            <div v-else>
                Nenhum grupo cadastrado
            </div>
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
    </div>
</template>

<script>
export default {
    name: "group",
    props: [
        'urlBaseApi',
        'urlBaseApiActivity',
        'routeViewActivity'
    ],
    data() {
        return {
            alert: false,
            alertMessage: '',
            alertTime: 2000,
            nameNewGroup: '',
            nameNewActivity: '',
            nameEditGroup: '',
            groups: [],
            dialogNewGroup: false,
            dialogNewActivity: false,
            dialogEditGroup: false,
        }
    },
    methods: {
        createGroup: function () {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            let data = {
                name: this.nameNewGroup
            };

            axios.post(this.urlBaseApi, data, settings)
                .then(response => {
                    this.getGroup();
                    this.dialogNewGroup = false;
                    this.alert = true;
                    this.alertMessage = 'Novo grupo criado com sucesso';
                }).catch(error => {
                this.alert = true;
                this.alertMessage = 'Ocorreu um erro, tente novamente';
            })
        },
        createActivity: function (idGroup) {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = {
                group: idGroup,
                name: this.nameNewActivity
            };

            axios.post(this.urlBaseApiActivity, data, settings)
                .then(response => {
                    this.getGroup();
                    this.dialogNewActivity = false;
                    this.alert = true;
                    this.alertMessage = 'Nova atividade criada com sucesso';
                }).catch(error => {
                this.alert = true;
                this.alertMessage = 'Ocorreu um erro, tente novamente';
            })
        },
        editGroup: function (group) {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            axios.put(this.urlBaseApi + '/' + group.id, group, settings)
                .then(
                    (response) => {
                        this.getGroup();
                        this.dialogEditGroup = false;
                        this.alert = true;
                        this.alertMessage = 'Grupo atualizado com sucesso';
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
        getGroup: function () {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApi, settings)
                .then(response => {
                    this.groups = response.data
                });
        }
    },
    mounted() {
        this.getGroup();
    }
}
</script>

<style scoped>

</style>
