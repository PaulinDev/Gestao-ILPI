<template>
    <v-navigation-drawer
        app
        expand-on-hover
        floating
    >
        <v-list
            expand
            shaped
            class="vertical-nav-menu-items pr-5"
        >
            <v-list-item
                class="vertical-nav-menu-link"
                active-class="bg-gradient-primary white--text">
                <v-list-item-icon>
                    <i class="fas fa-home"></i>
                </v-list-item-icon>
                <v-list-item-title class="nameApp align-self-center">Gestão ILPI</v-list-item-title>
            </v-list-item>

            <v-list-item link :href="this.pageUrlEmployee"
                         class="vertical-nav-menu-link"
                         active-class="bg-gradient-primary white--text">
                <v-list-item-icon>
                    <i class="fas fa-user"></i>
                </v-list-item-icon>
                <v-list-item-title>Funcionários</v-list-item-title>
            </v-list-item>

            <v-list-item link :href="this.pageUrlPatients"
                         class="vertical-nav-menu-link"
                         active-class="bg-gradient-primary white--text">
                <v-list-item-icon>
                    <i class="fas fa-user"></i>
                </v-list-item-icon>
                <v-list-item-title>Utentes</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
    name: "navigation",
    props: [
        'pageUrlEmployee',
        'pageUrlPatients',
    ]
}
</script>

<style scoped>
.v-navigation-drawer {
    box-shadow: 0 0 15px 0 rgba(34, 41, 47, .05);
}

.nameApp {
    color: #7367F0 !important;
    font-weight: 700 !important;
    font-family: montserrat !important;
    font-size: 20px !important;
    margin-top: 2%;
    margin-left: -5%;
}

.fa-home {
    color: #7367F0 !important;
    font-size: 24px !important;
}
</style>

<style lang="scss">
.vertical-nav-menu-link {
    &.v-list-item--active {
        box-shadow: 0 5px 10px -4px rgba(94, 86, 105, 0.42);
    }
}
</style>
