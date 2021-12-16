<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <v-card class="mx-auto my-12 pt-10">
                    <template slot="progress">
                        <v-progress-linear
                            color="deep-purple"
                            height="10"
                            indeterminate
                        ></v-progress-linear>
                    </template>

                    <v-card-title class="justify-center flex-column">
                        <v-avatar size="120" tile :rounded="true" class="mb-4">
                            <v-img
                                height="120"
                                max-width="120"
                                src="https://themeselection.com/demo/materio-vuetify-vuejs-admin-template/demo-1/img/2.80504cd9.png"
                            ></v-img>
                        </v-avatar>
                        <v-dialog
                            v-model="dialogPhotoUser"
                            max-width="auto"
                            width="400px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="primary" class="mb-2" v-bind="attrs" v-on="on" text>
                                    {{ user.photo === null ? "Nova foto" : "Alterar foto" }}
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-text>
                                    <form enctype="multipart/form-data">
                                        <v-file-input
                                            :label="
                    user.photo === null ? 'Nova foto' : 'Alterar foto'
                  "
                                            filled
                                            v-model="photoUser"
                                            v-on:change="onChange"
                                            prepend-icon="mdi-camera"
                                            class="col-md-12 mx-auto"
                                        ></v-file-input>
                                        <button class="btn btn-primary btn-block">Upload</button>
                                    </form>
                                    <v-btn
                                        color="primary"
                                        class="col-md-12 mx-auto"
                                        @click="updatePhoto()"
                                        :disabled="!photoUser"
                                        v-bind="attrs"
                                        v-on="on"
                                        text
                                    >
                                        Enviar foto
                                    </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                        <span class="mb-2" style="color: rgba(94, 86, 105, 0.87) !important">{{
                                user.name
                            }}</span>
                        <v-chip class="ma-2" color="primary" pill>
                            <v-icon> mdi-account-outline</v-icon>
                            {{ user.get_permission.name }}
                        </v-chip>
                    </v-card-title>

                    <v-card-text>
                        <h2 class="text-xl font-weight-semibold mb-2">Detalhes</h2>
                        <v-divider></v-divider>
                        <v-list-item class="px-0">
                            <v-list-item-content>
                                <v-list-item-title>Cargo</v-list-item-title>
                                <v-list-item-subtitle>{{ user.get_post.name }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-0">
                            <v-list-item-content>
                                <v-list-item-title>E-mail</v-list-item-title>
                                <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-0">
                            <v-list-item-content>
                                <v-list-item-title>Gênero</v-list-item-title>
                                <v-list-item-subtitle>{{ user.get_gender.description }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-0">
                            <v-list-item-content>
                                <v-list-item-title>CPF</v-list-item-title>
                                <v-list-item-subtitle>{{ user.userCpf }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-0">
                            <v-list-item-content>
                                <v-list-item-title>RG</v-list-item-title>
                                <v-list-item-subtitle>{{ user.userRg }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

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
            <div class="col-md-8">
                <user-edit
                    :url-base-api="urlBaseApi"
                    :url-base-api-genders="urlBaseApiGenders"
                    :url-base-api-user-post="urlBaseApiUserPost"
                    :url-base-api-user-permission="urlBaseApiUserPermission"
                    :id-current-employee="idCurrentUser"
                ></user-edit>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "profile",
    props: [
        'urlBaseApi',
        'urlBaseApiEmployee',
        'idCurrentUser',
        'urlBaseApiGenders',
        'urlBaseApiUserPost',
        'urlBaseApiUserPermission',
    ],
    data() {
        return {
            user: {},
            dialogPhotoUser: false,
            photoUser: null,
        }
    },
    methods: {
        onChange(e) {
            this.photoUsere = e.target.files[0];
        },
        getUser() {
            let settings = {
                headers: {
                    Accept: "application/json",
                    Authorization: this.$root.token(),
                },
            };
            axios
                .get(this.urlBaseApi + "/" + this.idCurrentUser, settings)
                .then((response) => {
                    this.user = response.data;
                });
        }
    }, updatePhoto() {
        let settings = {
            headers: {
                Accept: "application/json",
                'content-type': 'multipart/form-data',
                Authorization: this.$root.token(),
            },
        };

        console.log(this.photoUser);
        let data = new FormData();
        data.append("file", this.photoUser);

        console.log(data);
        axios
            .post(
                this.urlBaseApiPhotoPatient + "/" + this.idCurrentPatient,
                data,
                settings
            )
            .then((response) => {
                console.log(response);
            });
    },
    mounted() {
        this.getUser();
    }
}
</script>

<style scoped>

</style>
