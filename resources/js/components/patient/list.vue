<template>
    <div>
        <v-breadcrumbs
            :items="items"
            divider="/"
            class="px-0"
        ></v-breadcrumbs>
        <div class="col-md-10 px-0 py-0">
            <v-btn
                color="primary"
                :href="urlPageNew"
            >
                <i class="fas fa-plus"></i> Funcionário
            </v-btn>
        </div>

        <v-card class="mt-5">
            <v-card-title>
                Funcionários
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

                <template v-slot:item.get_permission="{ item }">
                <span style="color:red; font-weight: bold"
                      v-if="item.get_permission.id === 1">{{ item.get_permission.name }}</span>
                    <span style="color:green; font-weight: bold"
                          v-if="item.get_permission.id !== 1">{{ item.get_permission.name }}</span>
                </template>
                <template v-slot:item.birthdate="{ item }">
                    {{ datetimeToDate(item.birthdate) }}
                </template>
                <template v-slot:item.name="{ item }">
                    {{ shortName(item.name) }}
                </template>
                <template v-slot:item.actions="{item}">
                    <v-btn :href="urlPageEdit+'/'+item.id" text><v-icon small class="mr-2" color="orange darken-2"> mdi-pencil</v-icon></v-btn>
                    <v-btn text><v-icon small color="red darken-2" @click="deleteDialogItem(item.id);"> mdi-delete</v-icon></v-btn>
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
    </div>
</template>

<script>

export default {
    props: [
        'urlBaseApi',
        'urlBaseApiDelete',
        'urlPageNew',
        'urlPageEdit'
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
                {text: "Nascimento", value: "birthdate"},
                {text: "Sexo", value: "get_gender.description"},
                {text: "Cargo", value: "get_post.name"},
                {text: "Permissão", value: "get_permission"},
                {text: "Ações", value: "actions"},
            ],
            dataItem: [],
            loadingItems: true,
            confirmDialogDelete: false,
            confirmDelete: false,
            deleteItemId: 0,
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

            axios.delete(this.urlBaseApiDelete+'/'+this.deleteItemId, settings).then(
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
        }
    },
    mounted() {
        this.getEmployees();
    }
}
</script>

<style scoped>

</style>
