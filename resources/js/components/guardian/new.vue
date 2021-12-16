<template>
    <div>
        <v-card class="px-5 py-3">

            <v-form class="mt-5" ref="formValidate" lazy-validation v-model="formValidate">

                <v-card-title>
                    <span class="text-h5">Associar responsável para o utente</span>
                </v-card-title>

                <v-card-text>
                    <div class="row">
                        <div class="col-md-6 row">
                            <v-autocomplete
                                :items="listAllUsers"
                                v-model="userSelected"
                                label="Usuário"
                                :loading="loadAllUsers"
                                class="col-md-9 align-self-end"
                            ></v-autocomplete>
                            <v-dialog
                                v-model="dialogNewUser"
                                max-width="auto"
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
                                        <span class="text-h5">Cadastrar novo usuário</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col
                                                    cols="12"
                                                    md="12"
                                                >
                                                    <v-form class="mt-5" ref="form" lazy-validation
                                                            v-model="formValidate">
                                                        <v-stepper
                                                            v-model="countStepper"
                                                            vertical
                                                        >
                                                            <v-stepper-step
                                                                :complete="countStepper > 1"
                                                                step="1"
                                                            >
                                                                Informações pessoais
                                                            </v-stepper-step>

                                                            <v-stepper-content step="1">
                                                                <div class="row my-2">
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field label="Nome do usuário" id="name"
                                                                                      name="name" type="text" ref="name"
                                                                                      v-model="userName"
                                                                                      :rules="[rules.required]"></v-text-field>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field label="E-mail" id="email"
                                                                                      name="email" type="email"
                                                                                      placeholder="exemplo@gestaoilpi.com.br"
                                                                                      v-model="userEmail"
                                                                                      :rules="[rules.required]"></v-text-field>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <v-menu
                                                                            ref="menu"
                                                                            v-model="menu"
                                                                            :close-on-content-click="false"
                                                                            transition="scale-transition"
                                                                            offset-y
                                                                            min-width="auto"
                                                                        >
                                                                            <template v-slot:activator="{ on, attrs }">
                                                                                <v-text-field
                                                                                    v-model="userBirthdate"
                                                                                    label="Data de nascimento"
                                                                                    readonly
                                                                                    v-bind="attrs"
                                                                                    v-on="on"
                                                                                    :rules="[rules.required]"
                                                                                    class="v-application"
                                                                                ></v-text-field>
                                                                            </template>
                                                                            <v-date-picker
                                                                                v-model="userBirthdate"
                                                                                :active-picker.sync="activePicker"
                                                                                :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                                                                                min="1950-01-01"
                                                                                @change="save"
                                                                            ></v-date-picker>
                                                                        </v-menu>
                                                                    </div>
                                                                </div>
                                                                <div class="row my-2">
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field label="CPF" id="cpf" name="cpf"
                                                                                      v-mask="'###.###.###-##'"
                                                                                      v-model="userCpf"
                                                                                      placeholder="000.000.000-00"
                                                                                      :rules="[rules.required]"></v-text-field>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field label="RG" id="rg" name="rg"
                                                                                      v-mask="'##.###.###'"
                                                                                      v-model="userRg"
                                                                                      placeholder="00.000.000"
                                                                                      :rules="[rules.required]"></v-text-field>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <v-select
                                                                            :items="genderItems"
                                                                            v-model="userGender"
                                                                            label="Sexo"
                                                                            :loading="loadItemGender"
                                                                            :rules="[rules.required]"
                                                                        ></v-select>
                                                                    </div>
                                                                </div>
                                                                <v-btn
                                                                    color="primary"
                                                                    @click="countStepper = 2"
                                                                >
                                                                    Próximo
                                                                </v-btn>
                                                            </v-stepper-content>

                                                            <v-stepper-step
                                                                :complete="countStepper > 2"
                                                                step="2"
                                                            >
                                                                Informações de endereço
                                                            </v-stepper-step>

                                                            <v-stepper-content step="2">
                                                                <small>Preencha o CEP para buscar automaticamente o
                                                                    endereço</small>
                                                                <div class="row my-2">
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field v-model="addressCep"
                                                                                      name="addressCep"
                                                                                      v-mask="'#####-###'"
                                                                                      :rules="[rules.required]"
                                                                                      label="CEP"
                                                                                      @blur="getAddress(addressCep)"></v-text-field>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field v-model="addressNumber"
                                                                                      name="addressNumber"
                                                                                      label="Número"></v-text-field>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field v-model="addressCity"
                                                                                      name="addressCity" label="Cidade"
                                                                                      :disabled="true"></v-text-field>
                                                                    </div>
                                                                </div>
                                                                <div class="row my-2">
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field v-model="addressProvince"
                                                                                      name="addressProvince"
                                                                                      label="Estado"
                                                                                      :disabled="true"></v-text-field>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field v-model="addressDistrict"
                                                                                      name="addressDistrict"
                                                                                      label="Bairro"
                                                                                      :disabled="true"></v-text-field>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <v-text-field v-model="addressStreet"
                                                                                      name="addressStreet"
                                                                                      label="Logradouro"
                                                                                      :disabled="true"></v-text-field>
                                                                    </div>
                                                                </div>
                                                                <v-btn
                                                                    color="warning"
                                                                    @click="countStepper = 1"
                                                                >
                                                                    Anterior
                                                                </v-btn>

                                                            </v-stepper-content>
                                                        </v-stepper>
                                                    </v-form>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="error"
                                            text
                                            @click="dialogNewUser = false"
                                        >
                                            Cancelar
                                        </v-btn>
                                        <v-btn
                                            color="success"
                                            text
                                            @click="requestNewUser()"
                                        >
                                            Salvar
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </div>
                        <div class="col-md-6 row">
                            <v-autocomplete
                                :items="listAllTypeGuardian"
                                v-model="guardianTypeSelected"
                                label="Parentesco"
                                :loading="loadAllTypeGuardian"
                                class="col-md-9 align-self-end"
                            ></v-autocomplete>
                            <v-dialog
                                v-model="dialogNewGuardianType"
                                max-width="auto"
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
                                        <span class="text-h5">Cadastrar novo tipo de responsável</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col
                                                    cols="12"
                                                    md="12"
                                                >
                                                    <v-form class="mt-5" ref="form" lazy-validation
                                                            v-model="formValidate">
                                                        <v-text-field
                                                            label="Parentesco"
                                                            v-model="nameNewGuardianType"
                                                        >

                                                        </v-text-field>
                                                    </v-form>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="error"
                                            text
                                            @click="dialogNewGuardianType = false"
                                        >
                                            Cancelar
                                        </v-btn>
                                        <v-btn
                                            color="success"
                                            text
                                            @click="createNewTypeGuardian()"
                                        >
                                            Salvar
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </div>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="$emit('listenNewGuardian', true)"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="success"
                        text
                        @click="requestNewGuardian()"
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
    props: [
        'urlBaseApiGuardian',
        'urlBaseApiGuardianType',
        'urlBaseApiGenders',
        'urlBaseApiUsers',
        'idCurrentPatient',
    ],
    name: "new",
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
            countStepper: 1,
            addressCep: '',
            addressCity: '',
            addressProvince: '',
            addressStreet: '',
            addressNumber: '',
            addressDistrict: '',
            activePicker: null,
            formValidate: false,
            dialogNewUser: false,
            dialogNewPost: false,
            dialogNewGuardianType: false,
            listAllUsers: [],
            listAllTypeGuardian: [],
            userSelected: null,
            guardianTypeSelected: null,
            dialogNewUserMsg: '',
            menu: false,
            genderItems: [],
            userBirthdate: null,
            userCpf: '',
            userEmail: '',
            userGender: '',
            userNewPost: '',
            nameNewGuardianType: '',
            userNewPostDesc: '',
            userName: '',
            userPermission: '',
            userPost: '',
            userPostsItems: [],
            userPermissionItems: [],
            userRg: '',
            loadItemGender: true,
            loadAllUsers: true,
            loadAllTypeGuardian: true,
            loadItemUserPost: true,
            loadItemUserPermission: true,
            rules: {
                required: value => !!value || 'Preenchimento obrigatório.',
                min: v => v.length >= 8 || 'Este campo precisa ter no minímo 8 caracteres',
                emailMatch: () => (`The email and password you entered don't match`),
            },
        }
    },
    methods: {
        validate() {
            this.$refs.form.validate()
        },
        getGenderItems() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiGenders, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.genderItems.push({text: item.description, value: item.id})
                    });
                    this.loadItemGender = false;
                }, (error) => {
                    console.log(error);
                }
            )
        },
        createNewTypeGuardian() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = {
                'name': this.nameNewGuardianType,
            };

            axios.post(this.urlBaseApiGuardianType, data, settings)
                .then(
                    (response) => {
                        this.dialogNewGuardianType = false;
                        this.nameNewGuardianType = '';
                        this.alert = true;
                        this.alertMessage = 'Novo tipo de responsável cadastrado com sucesso';
                        this.getAllTypeGuardian();
                    }
                )
                .catch(
                    () => {
                        this.barAlert = true;
                        this.barAlertMessage = 'Erro no cadastro, tente novamente';
                    }
                )

        },
        getAllUsers() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            this.listAllUsers = [];

            axios.get(this.urlBaseApiUsers, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.listAllUsers.push({text: item.name, value: item.id})
                    });
                    this.loadAllUsers = false;
                }, (error) => {
                    console.log(error);
                }
            )
        },
        getAllTypeGuardian() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            this.listAllTypeGuardian = [];

            axios.get(this.urlBaseApiGuardianType, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.listAllTypeGuardian.push({text: item.name, value: item.id})
                    });
                    this.loadAllTypeGuardian = false;
                }, (error) => {
                    console.log(error);
                }
            )
        },
        save(date) {
            this.$refs.menu.save(date)
        },
        getAddress(cep) {
            const urlViaCep = 'https://viacep.com.br/ws/' + cep + '/json/';
            axios.get(urlViaCep).then(
                (data) => {
                    this.addressCity = data.data.localidade;
                    this.addressDistrict = data.data.bairro;
                    this.addressProvince = data.data.uf;
                    this.addressStreet = data.data.logradouro;
                }
            )
        },
        requestNewUser() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = {
                'name': this.userName,
                'email': this.userEmail,
                'type': 2,
                'gender': this.userGender,
                'birthdate': this.userBirthdate,
                'userCpf': this.userCpf,
                'userRg': this.userRg,
                'permission': 3,
                'userPost': 2,
                'addressCep': this.addressCep,
                'addressCity': this.addressCity,
                'addressProvince': this.addressProvince,
                'addressStreet': this.addressStreet,
                'addressNumber': this.addressNumber,
                'addressDistrict': this.addressDistrict
            };

            axios.post(this.urlBaseApiUsers, data, settings)
                .then(
                    (response) => {
                        this.dialogNewUser = false;
                        this.alert = true;
                        this.alertMessage = 'Usuário cadastrado com sucesso';
                        this.getAllUsers();
                    }
                )
                .catch(
                    () => {
                        this.barAlert = true;
                        this.barAlertMessage = 'Erro no cadastro, tente novamente';
                    }
                )

        },
        requestNewGuardian() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = {
                'patientId': parseInt(this.idCurrentPatient),
                'userId': this.userSelected,
                'type': this.guardianTypeSelected,
            };

            axios.post(this.urlBaseApiGuardian, data, settings)
                .then(
                    (response) => {
                        this.$emit('listenNewGuardian');
                    }
                )
                .catch(
                    () => {
                        this.barAlert = true;
                        this.barAlertMessage = 'Erro no cadastro, tente novamente';
                    }
                )

        }
    },
    mounted() {
        this.getGenderItems();
        this.getAllUsers();
        this.getAllTypeGuardian();
    }
}
</script>

<style scoped>

</style>
