@extends('layouts.master')

@section('content')
    <v-container>
        <v-card>
            <v-card-text>
                <v-layout align-center justify-center row>
                    <v-flex xs11 sm5>
                        <v-menu
                                v-model="menus"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="displayStart"
                                        label="Inicio"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    v-model="startdate"
                                    type="month"
                                    scrollable
                                    min="2003-01-01"
                                    max="2007-12-31"
                                    @input="menus=false"
                            ></v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs11 sm5>
                        <v-menu
                                v-model="menue"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="displayEnd"
                                        label="Fin"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    v-model="enddate"
                                    type="month"
                                    scrollable
                                    min="2003-01-01"
                                    max="2007-12-31"
                                    @input="menue=false"
                            ></v-date-picker>
                        </v-menu>
                    </v-flex>
                </v-layout>
                <br/>
                <v-layout row wrap>
                    <v-flex xs12 sm6 md6>
                        <v-data-table
                                      dense
                                      v-model.sync="selected"
                                      :headers="headers"
                                      :items="doctors"
                                      item-key="co_usuario"
                                      show-select
                                      :page.sync="page"
                                      :items-per-page="itemsPerPage"
                                      hide-default-footer
                                      @page-count="pageCount = $event"
                                      disable-sort
                                      hide-default-header
                                      class="elevation-1">
                            <template v-slot:header="{ props: { headers } }">
                                <thead class="v-data-table-header hidden-xs-only">
                                <tr>
                                    <th>
                                        <v-simple-checkbox v-model="checkall"
                                                           :indeterminate="indeterminate"></v-simple-checkbox>
                                    </th>
                                    <th class="text-xs-left">Nombre</th>
                                    <th class="text-xs-left">Nacimiento</th>
                                </tr>
                                </thead>
                            </template>
                        </v-data-table>
                        <div class="text-xs-center pt-2">
                            <v-pagination v-model="page" :length="pageCount"></v-pagination>
                        </div>
                        <br/>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                        <v-layout align-center justify-space-around column fill-height>
                            <v-flex xs12 md12 sm12>
                                <v-btn color="info" rounded block width="160" :disabled="validData"
                                       @click="getRelatorio">
                                    <v-icon>mdi-file-table</v-icon>
                                    Relatório
                                </v-btn>
                            </v-flex>
                            <v-flex xs12 md12 sm12>
                                <v-btn color="info" rounded block width="160" :disabled="validData"
                                       @click="getGrafico">
                                    <v-icon>mdi-chart-bar</v-icon>
                                    Gráfico
                                </v-btn>
                            </v-flex>
                            <v-flex xs12 md12 sm12>
                                <v-btn color="info" block rounded width="160" :disabled="validData" @click="getPizza">
                                    <v-icon>mdi-chart-pie</v-icon>
                                    Pizza
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                </v-layout>
            </v-card-text>
        </v-card>
        <br/>
        <v-card v-if="frows.length!==0 && vrelatorio" v-for="(values,key,idx) in frows" :key="idx">
            <v-card-title class="headline blue lighten-2" primary-title>
                @{{ key | toUsuario }}
            </v-card-title>
            <v-card-text>
                <div class="v-data-table v-data-table--dense theme--light">
                    <div class="v-data-table__wrapper">
                        <table>
                            <thead>
                            <tr>
                                <th class="text-xs-center">Período</th>
                                <th class="text-xs-center">Receita Líquida</th>
                                <th class="text-xs-center">Custo Fixo</th>
                                <th class="text-xs-center">Comissão</th>
                                <th class="text-xs-center">Lucro</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="it in values" :key="it.period">
                                <td>@{{ it.period | toDate }}</td>
                                <td class="text-xs-right">$R @{{ it.recliq | numeral('0,0.00') }}</td>
                                <td class="text-xs-right">- $R @{{ it.bruto | numeral('0,0.00')}}</td>
                                <td class="text-xs-right">- $R @{{ it.comision | numeral('0,0.00') }}</td>
                                <td class="text-xs-right" :class="{'error':it.beneficio<0}">@{{ it.beneficio<0?'-':''}}
                                    R$ @{{ Math.abs(it.beneficio) | numeral('0,0.00') }}
                                </td>
                            </tr>
                            <tr class="grey">
                                <td>SALDO</td>
                                <td class="text-xs-right">$R @{{ totals[key].liq | numeral('0,0.00') }}</td>
                                <td class="text-xs-right">- $R @{{ totals[key].costo | numeral('0,0.00') }}</td>
                                <td class="text-xs-right">- $R @{{ totals[key].com | numeral('0,0.00') }}</td>
                                <td class="text-xs-right"> $R @{{ totals[key].lucro | numeral('0,0.00') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </v-card-text>
        </v-card>
        <v-card v-show="vgrafico">
            <v-card-text>
                <highcharts :options="graficoOptions"></highcharts>
            </v-card-text>
        </v-card>
        <v-card v-show="vpizza">
            <v-card-text>
                <highcharts :options="pizzaOptions"></highcharts>
            </v-card-text>
        </v-card>
        <v-snackbar v-model="snackbar.active" :color="snackbar.color">
            @{{ snackbar.msg }}
            <v-btn dark icon @click="snackbar.active = false">
                <v-icon>mdi_close</v-icon>
            </v-btn>
        </v-snackbar>
    </v-container>
@endsection

@section('js')
    <script>
        Vue.use(HighchartsVue.default);
        window.vmContext = new Vue({
            el: '#app',
            vuetify: new Vuetify({
                icons: {
                    iconfont: 'mdi'
                }
            }),
            data: {
                startdate: "2003-01",
                enddate: "2007-12",
                menus: false,
                menue: false,
                modal: false,
                selected: [],
                headers: [
                    {text: 'Nombre', align: 'left', value: 'no_usuario', sortable: false},
                    {text: 'Nacimiento', value: 'dt_nascimento', sortable: false}
                ],
                doctors: {!! json_encode($doctors) !!},

                page: 1,
                pageCount: 0,
                itemsPerPage: 5,
                snackbar: {
                    active: false,
                    color: undefined,
                    msg: undefined
                },
                frows: [],
                totals: [],
                pizzaOptions: {
                    credits: {
                        enabled: false
                    },
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Participação na Receita'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>R$ {point.y:.2f}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Receita',
                        colorByPoint: true,
                        data: []
                    }]
                },
                graficoOptions: {
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: 'Performance Comercial'
                    },
                    xAxis: {
                        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>R$ {point.y:.2f}</b>'
                    },
                    series: []
                },
                vrelatorio: false,
                vgrafico: false,
                vpizza: false,
                checkall: false,
                indeterminate: false
            },
            computed: {
                displayStart() {
                    return moment(this.startdate).format("MMMM YYYY");
                },
                displayEnd() {
                    return moment(this.enddate).format("MMMM YYYY");
                },
                validData() {
                    return this.startdate > this.enddate || this.selected.length === 0;
                }
            },
            methods: {
                getRelatorio() {
                    axios.post("{{ route('btn.relatorio') }}", {
                        startdate: this.startdate,
                        enddate: this.enddate,
                        users: _.map(this.selected, "co_usuario")
                    }).then(
                        (r) => {
                            this.vrelatorio = this.vgrafico = this.vpizza = false;
                            this.frows = r.data.rows;
                            this.totals = r.data.totals;
                            if (this.frows.length === 0) return this.sbInfo("No existen datos");
                            this.vrelatorio = true;
                        }
                    ).catch((e) => {
                        if (e.response && e.response.status === 422) {
                            return this.sbError("Error validando datos de entrada");
                        }
                        this.sbError("Ha ocurrido un error con el servidor");
                        console.log(e);
                    });
                },
                getSaldo(cu) {
                    return this.totals[cu];
                },
                sbError(msg) {
                    this.snackbar.msg = msg;
                    this.snackbar.color = "error";
                    this.snackbar.active = true;
                },
                sbInfo(msg) {
                    this.snackbar.msg = msg;
                    this.snackbar.color = "warning";
                    this.snackbar.active = true;
                },
                getPizza() {
                    axios.post("{{ route('btn.pizza') }}", {
                        startdate: this.startdate,
                        enddate: this.enddate,
                        users: _.map(this.selected, "co_usuario")
                    }).then(
                        (r) => {
                            this.vrelatorio = this.vgrafico = this.vpizza = false;
                            this.pizzaOptions.series[0].data = r.data.map((e) => {
                                return [e.name, parseFloat(e.y)]
                            });
                            if (r.data.length === 0) return this.sbInfo("No existen datos");
                            this.vpizza = true;
                        }
                    ).catch((e) => {
                        if (e.response && e.response.status === 422) {
                            return this.sbError("Error validando datos de entrada");
                        }
                        this.sbError("Ha ocurrido un error con el servidor");
                        console.log(e);
                    });
                },
                getGrafico() {
                    axios.post("{{ route('btn.grafico') }}", {
                        startdate: this.startdate,
                        enddate: this.enddate,
                        users: _.map(this.selected, "co_usuario")
                    }).then(
                        (r) => {
                            this.vrelatorio = this.vgrafico = this.vpizza = false;
                            this.graficoOptions.series = r.data;
                            if (r.data.length === 0) return this.sbInfo("No existen datos");
                            this.vgrafico = true;
                        }
                    ).catch((e) => {
                        if (e.response && e.response.status === 422) {
                            return this.sbError("Error validando datos de entrada");
                        }
                        this.sbError("Ha ocurrido un error con el servidor");
                        console.log(e);
                    });
                }
            },
            filters: {
                toUsuario(cu) {
                    return _.find(vmContext.doctors, {"co_usuario": cu}).no_usuario;
                },
                toDate(d) {
                    return moment(d, "YYYY-MM").format("MMMM [de] YYYY");
                }
            },
            watch: {
                'checkall': function (nv) {
                    if (this.selected.length && !nv) {
                        this.selected = [];
                    } else this.selected = this.doctors.slice();
                },
                'selected': function () {
                    this.indeterminate = this.selected.length !== 0 && this.selected.length !== this.doctors.length;
                }
            }
        });
    </script>
@stop
