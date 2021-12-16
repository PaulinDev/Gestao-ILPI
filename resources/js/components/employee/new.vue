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
                :href="urlPageIndex"
            >
                <i class="fas fa-long-arrow-alt-left"></i> Voltar
            </v-btn>
        </div>
        <v-form class="mt-5" ref="form" lazy-validation v-model="formValidate">
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
                            <v-text-field label="Nome do funcionário" id="name" name="name" type="text" ref="name"
                                          v-model="userName"
                                          :rules="[rules.required]"></v-text-field>
                        </div>
                        <div class="form-group col-md-4">
                            <v-text-field label="E-mail" id="email" name="email" type="email"
                                          placeholder="exemplo@gestaoilpi.com.br" v-model="userEmail"
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
                            <v-text-field label="CPF" id="cpf" name="cpf" v-mask="'###.###.###-##'" v-model="userCpf"
                                          placeholder="000.000.000-00" :rules="[rules.required]"></v-text-field>
                        </div>
                        <div class="form-group col-md-4">
                            <v-text-field label="RG" id="rg" name="rg" v-mask="'##.###.###'" v-model="userRg"
                                          placeholder="00.000.000" :rules="[rules.required]"></v-text-field>
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
                    <small>Preencha o CEP para buscar automaticamente o endereço</small>
                    <div class="row my-2">
                        <div class="form-group col-md-4">
                            <v-text-field v-model="addressCep" name="addressCep" v-mask="'#####-###'"
                                          :rules="[rules.required]" label="CEP"
                                          @blur="getAddress(addressCep)"></v-text-field>
                        </div>
                        <div class="form-group col-md-4">
                            <v-text-field v-model="addressNumber" name="addressNumber" label="Número"></v-text-field>
                        </div>
                        <div class="form-group col-md-4">
                            <v-text-field v-model="addressCity" name="addressCity" label="Cidade"
                                          :disabled="true"></v-text-field>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="form-group col-md-4">
                            <v-text-field v-model="addressProvince" name="addressProvince" label="Estado"
                                          :disabled="true"></v-text-field>
                        </div>
                        <div class="form-group col-md-4">
                            <v-text-field v-model="addressDistrict" name="addressDistrict" label="Bairro"
                                          :disabled="true"></v-text-field>
                        </div>
                        <div class="form-group col-md-4">
                            <v-text-field v-model="addressStreet" name="addressStreet" label="Logradouro"
                                          :disabled="true"></v-text-field>
                        </div>
                    </div>
                    <v-btn
                        color="warning"
                        @click="countStepper = 1"
                    >
                        Anterior
                    </v-btn>
                    <v-btn
                        color="primary"
                        @click="countStepper = 3"
                    >
                        Próximo
                    </v-btn>
                </v-stepper-content>

                <v-stepper-step
                    :complete="countStepper > 3"
                    step="3"
                >
                    Permissões no sistema
                </v-stepper-step>

                <v-stepper-content step="3">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="row">

                                <div class="col-md-12 form-group d-flex align-center">
                                    <v-select
                                        :items="userPostsItems"
                                        label="Cargo"
                                        :loading="loadItemUserPost"
                                        v-model="userPost"
                                        :rules="[rules.required]"
                                    ></v-select>
                                    <v-dialog
                                        v-model="dialogNewPost"
                                        max-width="600px"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                v-bind="attrs"
                                                v-on="on" color="primary" class="ml-1">
                                                <v-icon>mdi-plus</v-icon>
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="text-h5">Criar novo cargo</span>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col
                                                            cols="12"
                                                            md="6"
                                                        >
                                                            <v-text-field
                                                                label="Nome do cargo"
                                                                required
                                                                v-model="userNewPost"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            md="6"
                                                        >
                                                            <v-text-field
                                                                label="Descrição do cargo"
                                                                required
                                                                v-model="userNewPostDesc"
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
                                                    @click="dialogNewPost = false"
                                                >
                                                    Cancelar
                                                </v-btn>
                                                <v-btn
                                                    color="success"
                                                    text
                                                    @click="createNewPost()"
                                                >
                                                    Salvar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <v-select
                                :items="userPermissionItems"
                                label="Permissão"
                                :loading="loadItemUserPermission"
                                v-model="userPermission"
                                :rules="[rules.required]"
                            ></v-select>
                        </div>
                    </div>
                    <v-btn
                        color="warning"
                        @click="countStepper = 2"
                    >
                        Anterior
                    </v-btn>
                    <v-btn
                        color="success"
                        :disabled="!formValidate"
                        @click="requestNewUser()"
                    >
                        Cadastrar
                    </v-btn>
                </v-stepper-content>
            </v-stepper>

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
        </v-form>
    </div>
</template>

<script>


export default {
    props: [
        'urlBaseApi',
        'urlBaseApiGenders',
        'urlBaseApiUserPost',
        'urlBaseApiUserPermission',
        'urlPageIndex'
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
            dialogNewUserMsg: '',
            menu: false,
            genderItems: [],
            userBirthdate: null,
            userCpf: '',
            userEmail: '',
            userGender: '',
            userNewPost: '',
            userNewPostDesc: '',
            userName: '',
            userPermission: '',
            userPost: '',
            userPostsItems: [],
            userPermissionItems: [],
            userRg: '',
            loadItemGender: true,
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
        createNewPost() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            let data = {
                name: this.userNewPost,
                description: this.userNewPostDesc
            };

            axios.post(this.urlBaseApiUserPost, data, settings)
                .then(response => {
                    this.alert = true;
                    this.alertMessage = 'Novo cargo cadastrado com sucesso';
                    this.userNewPost = '';
                    this.userNewPostDesc = '';
                    this.dialogNewPost = false;
                    this.getUserPostItems();
                }).catch(error => {
                this.alert = true;
                this.alertMessage = 'Houve um erro, tente novamente';
            })
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
        }, getUserPostItems() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiUserPost, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.userPostsItems.push({text: item.name, value: item.id})
                    });
                    this.loadItemUserPost = false;
                }, (error) => {
                    console.log(error);
                }
            )
        },
        getUserPermissionItems() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.urlBaseApiUserPermission, settings).then(
                (response) => {
                    response.data.forEach((item) => {
                        this.userPermissionItems.push({text: item.name, value: item.id})
                    });
                    this.loadItemUserPermission = false;
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
            this.dialogNewUser = true;
            this.dialogNewUserMsg = '';
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = {
                'name': this.userName,
                'email': this.userEmail,
                'post': this.userPost,
                'type': 1,
                'gender': this.userGender,
                'birthdate': this.userBirthdate,
                'userCpf': this.userCpf,
                'userRg': this.userRg,
                'permission': this.userPermission,
                'userPost': this.userPost,
                'addressCep': this.addressCep,
                'addressCity': this.addressCity,
                'addressProvince': this.addressProvince,
                'addressStreet': this.addressStreet,
                'addressNumber': this.addressNumber,
                'addressDistrict': this.addressDistrict
            };

            axios.post(this.urlBaseApi, data, settings)
                .then(
                    (response) => {
                        console.log(response);
                        let urlTarget = this.urlPageIndex;
                        this.alert = true;
                        this.alertMessage = 'Usuário cadastrado com sucesso';
                        setTimeout(function () {
                            window.location.href = urlTarget;
                        }, 1000)
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
        this.getUserPostItems();
        this.getUserPermissionItems();
    }
}
</script>

<style scoped>

</style>
