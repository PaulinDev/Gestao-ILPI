<template>
    <v-app-bar
        app
        color="white"
        elevation="0"
    >
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6 user-bar">
                <v-icon v-if="!this.$root.themeDark">mdi-weather-night</v-icon>
                <v-icon v-if="this.$root.themeDark">mdi-white-balance-sunny</v-icon>
                <v-icon class="ms-3">mdi-bell-outline</v-icon>
                <v-menu
                    rounded="lg"
                    offset-y
                >
                    <template v-slot:activator="{ attrs, on }">
                        <v-btn
                            class="ma-5 btnMenuUser"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <div class="user-nav ms-3">
                    <span class="user-name font-weight-bolder">
                        {{ currentUserName }}
                    </span>
                                <span class="user-status d-block">
                        {{ currentUserPost }}
                    </span>
                            </div>
                            <v-badge
                                bordered
                                bottom
                                color="success"
                                dot
                                offset-x="10"
                                offset-y="10"
                                class="ms-4"
                            >
                                <v-avatar size="40">
                                    <v-img src="https://cdn.vuetifyjs.com/images/lists/2.jpg"></v-img>
                                </v-avatar>
                            </v-badge>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item

                            link
                        >
                            <v-list-item-title>Meu Perfil</v-list-item-title>
                        </v-list-item>
                        <v-list-item

                            link
                        >

                            <v-list-item-title>Mensagens</v-list-item-title>
                        </v-list-item>
                        <v-list-item

                            link
                        >


                            <v-list-item-title>Calendário</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </div>
        </div>

    </v-app-bar>
</template>

<script>
export default {
    name: "bar",
    props: ['currentUserName', 'currentUserPost'],
    mounted() {
    }
}
</script>

<style scoped>

.btnMenuUser {
    padding: 4% 1% !important;
    background: transparent !important;
    box-shadow: none !important;
}

.user-nav span {
    font-family: Montserrat;
    color: #6e6b7b;
}

.user-nav span.font-weight-bolder {
    font-weight: bolder;
    font-size: 14px;
}

.user-nav span:not(.font-weight-bolder) {
    font-weight: 400;
    font-size: 12px;
    text-align: end;
}

.v-sheet.v-app-bar.v-toolbar:not(.v-sheet--outlined) {
    box-shadow: 0 4px 24px 0 rgba(34, 41, 47, .1) !important;
}

.user-bar {
    display: flex;
    justify-content: flex-end;
}
</style>
