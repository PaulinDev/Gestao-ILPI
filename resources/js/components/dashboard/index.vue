<template>
  <div>
    <div class="row">
      <div class="col-md-6">esq</div>
      <div class="col-md-6">
        <v-card>
          <v-card-title class="align-start">
            <span class="font-weight-semibold">Statistics Card</span>
            <v-spacer></v-spacer>
            <v-btn icon small class="me-n3 mt-n2">
              <v-icon> </v-icon>
            </v-btn>
          </v-card-title>

          <v-card-subtitle class="mb-8 mt-n5">
            <span class="font-weight-semibold text--primary me-1"
              >Total 48.5% Growth</span
            >
            <span>😎 this month</span>
          </v-card-subtitle>

          <v-card-text>
            <v-row>
              <v-col
                v-for="data in statisticsData"
                :key="data.title"
                cols="6"
                md="3"
                class="d-flex align-center"
              >
                <v-avatar size="44" rounded class="elevation-1">
                  <v-icon dark color="white" size="30"> </v-icon>
                </v-avatar>
                <div class="ms-3">
                  <p class="text-xs mb-0">teste2</p>
                  <h3 class="text-xl font-weight-semibold">teste3</h3>
                </div>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "index",
};
</script>

<style scoped>
</style>
