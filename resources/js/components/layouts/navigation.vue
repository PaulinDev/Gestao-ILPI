<template>
    <v-navigation-drawer
        app
        expand-on-hover
        floating
    >
        <v-list
            nav
            dense
        >
            <v-list-item link href="https://gestaoilpi.com.br/employees/list">
                <v-list-item-icon>
                    <i class="fas fa-user"></i>
                </v-list-item-icon>
                <v-list-item-title>Funcionários</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
    name: "navigation"
}
</script>

<style scoped>

</style>
