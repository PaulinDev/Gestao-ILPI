<template>
    <v-app-bar
        app
        color="white"
        elevation="8"
    >
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6 user-bar">
                <v-icon v-if="!this.$root.themeDark">mdi-weather-night</v-icon>
                <v-icon v-if="this.$root.themeDark">mdi-white-balance-sunny</v-icon>
                <v-icon class="ms-3">mdi-bell-outline</v-icon>
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
            </div>
        </div>

    </v-app-bar>
</template>

<script>
export default {
    name: "bar",
    props: ['currentUser', 'currentUserPost'],
    mounted() {
        console.log(this.currentUser);
    }
}
</script>

<style scoped>
.user-bar {
    display: flex;
    justify-content: flex-end;
}
</style>
