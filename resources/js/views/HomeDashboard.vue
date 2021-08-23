<template>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-uppercase">
                        <h2 class="font-weight-bold">{{ totalSales }}</h2>
                        Vendas
                    </div>
                    <div>
                        <i class="fas fa-shopping-cart fa-5x text-black-50"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <router-link to="vendas"
                        class="d-block text-white d-flex justify-content-between align-items-center">
                        Ver mais
                        <i class="fas fa-chevron-right"></i>
                    </router-link>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-uppercase">
                        <h2 class="font-weight-bold">{{ totalProducts }}</h2>
                        Produtos
                    </div>
                    <div>
                        <i class="fas fa-box-open  fa-5x text-black-50"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <router-link to="produtos"
                        class="d-block text-white d-flex justify-content-between align-items-center">
                        Ver mais
                        <i class="fas fa-chevron-right"></i>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <div class="card bg-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-uppercase">
                        <h2 class="font-weight-bold">{{ totalCategories }}</h2>
                        Categorias
                    </div>
                    <div>
                        <i class="fas fa-folder fa-5x text-black-50"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <router-link to="categorias"
                        class="d-block text-dark d-flex justify-content-between align-items-center">
                        Ver mais
                        <i class="fas fa-chevron-right"></i>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="col-12 my-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive col-12 col-md-6 mb-3">
                            <h5>Últimos produtos cadastrados</h5>
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Qtd</th>
                                        <th>Valor</th>
                                        <th>Categoria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in lastProducts" :key="item.codigo">
                                        <td>{{ item.codigo }}</td>
                                        <td>{{ item.nome }}</td>
                                        <td>{{ item.quantidade }}</td>
                                        <td>{{ item.valor | moeda }}</td>
                                        <td>{{ item.categoria.nome }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <router-link to="/produtos" class="btn btn-primary">
                                Ver todos os produtos cadastrados
                            </router-link>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h5>Vendas diárias</h5>
                            <GChart :settings="{ 'packages':['corechart'] }" type="LineChart" :data="chartData"
                                :options="chartOptions" />
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {
        GChart
    } from 'vue-google-charts'

    export default {
        data() {
            return {
                totalSales: null,
                totalProducts: null,
                totalCategories: null,
                lastProducts: {},
                chartData: [],
                chartOptions: {
                    hAxis: {
                        title: 'Data'
                    },
                    vAxis: {
                        title: 'Quantidade'
                    },
                    backgroundColor: '#f5f5f5'
                }
            }
        },
        components: {
            GChart
        },
        created() {
            this.$loading.show()
            axios.get('/api/vendas', this.$store.state.configHeader).then(response => {
                this.totalSales = response.data.total
            })
            axios.get('/api/produtos', this.$store.state.configHeader).then(response => {
                this.totalProducts = response.data.total
                this.lastProducts = response.data.data
            })
            axios.get('/api/categorias', this.$store.state.configHeader).then(response => {
                this.totalCategories = response.data.total
            })
            axios.get('/api/vendas/dias', this.$store.state.configHeader).then(response => {
                this.chartData = response.data
                this.$loading.hide()
            })
        },
        metaInfo: {
            title: 'Painel',
        }
    }

</script>

<style scoped>
    .text-black-50 {
        opacity: .4
    }

</style>
