<template>
    <div>
        <v-card>
            <v-card-title>
                Editar dose
            </v-card-title>
            <v-card-text>
                <div class="row">
                    <div class="col-md-4">
                        <v-select
                            :items="listBrandVaccine"
                            item-text="name"
                            item-value="id"
                            v-model="vaccine.vaccineBrand"
                            label="Marca da vacina"
                        >

                        </v-select>
                    </div>
                    <div class="col-md-4">
                        <v-menu
                            ref="menuDateRecordVaccine"
                            v-model="menuDateRecordVaccine"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="auto"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="dateRecordVaccineVm"
                                    label="Data da dose"
                                    persistent-hint
                                    prepend-icon="mdi-calendar"
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="dateRecordVaccine"
                                no-title
                                @input="menuDateRecordVaccine = false"
                            ></v-date-picker>
                        </v-menu>
                    </div>
                    <div class="col-md-4">
                        <v-menu
                            ref="menuReturnDateRecordVaccine"
                            v-model="menuReturnDateRecordVaccine"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="auto"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="dateReturnRecordVaccineVm"
                                    label="Data do retorno"
                                    persistent-hint
                                    prepend-icon="mdi-calendar"
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="dateReturnRecordVaccine"
                                no-title
                                @input="menuReturnDateRecordVaccine = false"
                            ></v-date-picker>
                        </v-menu>
                    </div>
                    <div class="col-md-4">
                        <v-text-field
                            label="Lote da vacina"
                            v-model="vaccine.batch"
                        >

                        </v-text-field>
                    </div>
                    <div class="col-md-4">
                        <v-text-field
                            label="Informação adicional"
                            v-model="vaccine.comments"
                        >

                        </v-text-field>
                    </div>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="$emit('listenEditVaccines', true);"
                >
                    Fechar
                </v-btn>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="editRecordVaccine()"
                >
                    Salvar
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "edit",
    props:
        [
            'idCurrentVaccine',
            'idCurrentVaccineRecord',
            'baseUrlApiVaccineRecord',
            'baseUrlApiVaccineBrand'
        ],
    data: vm => ({
        vaccine: {
            batch: null,
            comments: '',
            created_at: null,
            date: '',
            id: null,
            patient: null,
            returnDate: null,
            updated_at: null,
            vaccine: null,
            vaccineBrand: null,
        },
        listBrandVaccine: [],
        dateRecordVaccine: null,
        menuDateRecordVaccine: false,
        menuReturnDateRecordVaccine: false,
        dateRecordVaccineVm: vm.formatDate(null),
        dateReturnRecordVaccine: null,
        dateReturnRecordVaccineVm: vm.formatDate(null),
    }),
    methods: {
        getVaccines() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };
            axios.get(this.baseUrlApiVaccineRecord + '/' + this.idCurrentVaccineRecord, settings).then(
                (response) => {
                    this.vaccine = response.data;
                    this.dateReturnRecordVaccine = this.vaccine.returnDate;
                    this.dateRecordVaccine = this.vaccine.date;
                }
            )
        },
        editRecordVaccine() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            let data = this.vaccine;
            data.returnDate = this.dateReturnRecordVaccine;
            data.date = this.dateRecordVaccine;

            axios.put(this.baseUrlApiVaccineRecord+'/'+this.idCurrentVaccineRecord, data, settings)
                .then(response => {
                    this.$emit('listenEditVaccines');
                }).catch(error => {
                console.log(error);
                this.alert = true;
                this.alertMessage = 'Houve um erro, tente novamente';
            })
        },
        formatDate(date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${day}/${month}/${year}`
        },
        getBrands() {
            let settings = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.$root.token()
                }
            };

            axios.get(this.baseUrlApiVaccineBrand + '/' + this.idCurrentVaccine, settings).then(
                response => {
                    this.listBrandVaccine = response.data;
                }
            )
        },
    },
    mounted() {
        this.getBrands();
        this.getVaccines();
    },
    watch: {
        dateRecordVaccine(val) {
            this.dateRecordVaccineVm = this.formatDate(this.dateRecordVaccine);
        },
        dateReturnRecordVaccine(val) {
            this.dateReturnRecordVaccineVm = this.formatDate(this.dateReturnRecordVaccine);
        }
    },
}
</script>

<style scoped>

</style>
