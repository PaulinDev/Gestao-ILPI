<template>
    <div>
        <v-breadcrumbs
            :items="items"
            divider="/"
            class="px-0"
        ></v-breadcrumbs>


        <v-dialog
            v-model="dialogNewPatient"
            persistent
            max-width="auto"
        >
            <template v-slot:activator="{ on, attrs }">
                <div class="col-md-10 px-0 py-0">
                    <v-btn
                        color="primary"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <i class="fas fa-plus"></i> Utente
                    </v-btn>
                </div>
            </template>
            <new-patient
                :url-base-api="urlBaseApi"
                :url-base-api-genders="urlBaseApiGenders"
                :url-base-api-civil="urlBaseApiCivil"
                :url-base-api-country="urlBaseApiCountry"
                :url-base-api-education="urlBaseApiEducation"
                :url-base-api-occupation="urlBaseApiOccupation"
                v-on:listenNewRequestUser="listenNewRequestUser"
            ></new-patient>
        </v-dialog>

        <v-card class="mt-5">
            <v-card-title>
                Utentes
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Pesquisar"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="dataItem"
                :search="search"
                :loading="loadingItems"
                locale="pt"
                loading-text="Carregando... Por favor aguarde"
            >

                <template v-slot:item.get_situation.description="{ item }">
                <span style="color:red; font-weight: bold"
                      v-if="item.get_situation.id !== 1">{{ item.get_situation.description }}</span>
                    <span style="color:green; font-weight: bold"
                          v-if="item.get_situation.id === 1">{{ item.get_situation.description }}</span>
                </template>
                <template v-slot:item.birthdate="{ item }">
                    {{ datetimeToDate(item.birthdate) }}
                </template>
                <template v-slot:item.name="{ item }">
                    {{ shortName(item.name) }}
                </template>
                <template v-slot:item.actions="{item}">
                    <v-menu
                        bottom
                        left
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                icon
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>

                        <v-list dense>
                            <v-list-item>
                                <v-list-item-title>
                                    <v-btn :href="urlPageView+'/'+item.id" text color="warning">
                                        <v-icon class="mr-2"> mdi-file-document-outline</v-icon>
                                        Detalhes
                                    </v-btn>
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title>
                                    <v-btn text @click="deleteDialogItem(item.id);" color="red">
                                        <v-icon class="mr-2"> mdi-delete-outline</v-icon>
                                        Excluir
                                    </v-btn>
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>


                </template>

            </v-data-table>
        </v-card>

        <v-row justify="center">
            <v-dialog
                v-model="confirmDialogDelete"
                persistent
                max-width="400"
            >
                <v-card>
                    <v-card-title class="text-h5">
                        Deletar usuário
                    </v-card-title>
                    <v-card-text>Ao confirmar, sua decisão não poderá ser revertida e o usuário será excluído
                        permanentemente.
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            text
                            @click="confirmDialogDelete = false;"
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
        </v-row>
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
        'urlBaseApi',
        'urlBaseApiDelete',
        'urlPageNew',
        'urlPageView',
        'urlBaseApiGenders',
        'urlBaseApiCivil',
        'urlBaseApiCountry',
        'urlBaseApiEducation',
        'urlBaseApiOccupation',
    ],
    name: "list",
    data() {
        return {
            items: [
                {
                    text: 'Dashboard',
                    disabled: false,
                    href: 'breadcrumbs_dashboard',
                },
                {
                    text: 'Link 1',
                    disabled: false,
                    href: 'breadcrumbs_link_1',
                },
                {
                    text: 'Link 2',
                    disabled: true,
                    href: 'breadcrumbs_link_2',
                },
            ],
            alert: false,
            alertMessage: '',
            alertTime: 2000,
            search: '',
            headers: [
                {text: "Registro", value: "id"},
                {text: "Nome", value: "name"},
                {text: "Apelido", value: "nick"},
                {text: "Nascimento", value: "birthdate"},
                {text: "Sexo", value: "get_gender.description"},
                {text: "Situação", value: "get_situation.description"},
                {text: "Ações", value: "actions"},
            ],
            dataItem: [],
            loadingItems: true,
            confirmDialogDelete: false,
            confirmDelete: false,
            deleteItemId: 0,
            dialogNewPatient: false
        }
    },
    methods: {
        getEmployees() {

            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApi, settings).then(
                (response) => {
                    this.loadingItems = false;
                    this.dataItem = response.data;
                }
            );
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
                    employee: this.deleteItemId
                }
            };

            axios.delete(this.urlBaseApiDelete + '/' + this.deleteItemId, settings).then(
                (response) => {
                    this.confirmDialogDelete = false;
                    this.deleteItemId = 0;
                    this.alert = true;
                    this.alertMessage = 'Usuário deletado';
                    this.getEmployees();
                }
            );
        },
        datetimeToDate: function (date) {
            let getDate = new Date(date),
                day = getDate.getDate(),
                month = getDate.getMonth(),
                year = getDate.getFullYear(),
                monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

            return day + 1 + ' de ' + monthNames[month] + ' de ' + year;
        },

        shortName: function (name) {
            let newName = '';
            let splitName = name.split(" ");
            if (splitName.length > 1) {
                newName = splitName[0] + " " + splitName[1];
            } else {
                newName = name;
            }

            return newName;
        },
        listenNewRequestUser: function () {
            this.dialogNewPatient = false;
            this.getEmployees();
            this.alert = true;
            this.alertMessage = 'Usuário cadastrado com sucesso';
        }
    },
    mounted() {
        this.getEmployees();
    }
}
</script>

<style scoped>

</style>
