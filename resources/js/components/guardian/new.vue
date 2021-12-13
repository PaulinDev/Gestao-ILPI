<template>
    <div>
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
                            <v-text-field label="Nome do usuário" id="name" name="name" type="text" ref="name"
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
        'urlBaseApiGuardian',
        'urlBaseApiGenders',
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
                'type': 2,
                'gender': this.userGender,
                'birthdate': this.userBirthdate,
                'userCpf': this.userCpf,
                'userRg': this.userRg,
                'permission': 3,
                'userPost': 2,
                'patientId': this.idCurrentPatient,
                'addressCep': this.addressCep,
                'addressCity': this.addressCity,
                'addressProvince': this.addressProvince,
                'addressStreet': this.addressStreet,
                'addressNumber': this.addressNumber,
                'addressDistrict': this.addressDistrict
            };

            axios.post(this.urlBaseApiGuardian, data, settings)
                .then(
                    (response) => {
                        console.log(response);
                        this.alert = true;
                        this.alertMessage = 'Usuário cadastrado com sucesso';
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
    }
}
</script>

<style scoped>

</style>
