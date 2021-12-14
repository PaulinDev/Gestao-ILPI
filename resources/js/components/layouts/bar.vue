<template>
  <v-app-bar app
      flat
      absolute
      color="transparent"
      >
    <div class="row">
        <div class="col-md-6"></div>
      <div class="col-md-6" style="text-align: end">
        <v-fade-transition mode="out-in">
          <v-icon
            :key="$vuetify.theme.dark"
            @click="$vuetify.theme.dark = !$vuetify.theme.dark"
          >
            {{
              $vuetify.theme.dark
                ? 'mdi-white-balance-sunny'
                : 'mdi-weather-night'
            }}
          </v-icon>
        </v-fade-transition>
        <app-nav-user-bar
          :url-logout="urlLogout"
          :current-user-name="currentUserName"
          :current-user-post="currentUserPost"
        ></app-nav-user-bar>
      </div>
    </div>
  </v-app-bar>
</template>

<script>
export default {
  name: "bar",
  props: ["currentUserName", "currentUserPost"],
};
</script>

<style scoped>

</style>
