<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <router-link to="registrar-venda" class="btn btn-primary">
                        Registrar venda
                    </router-link>
                </div>
                <div class="form-group text-right">
                    <label for="input-pesquisar-produto" class="sr-only">Pesquisar venda</label>
                    <input id="input-pesquisar-produto" class="form-control" type="text" name=""
                        placeholder="Digite o cliente ou o produto..." v-model="valueSearch" @keyup.enter="search">
                </div>
            </div>
            <div v-if="dataPage && dataPage.path.indexOf('search') != -1" key="totalEncontrados">
                Total de <strong>{{ dataPage.total }}</strong> resultados
            </div>
            <div v-else key="totalCategorias">
                Total de <strong>{{ dataPage.total }}</strong> registros
            </div>
            <div class="table-responsive my-2">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Produto e quantidade</th>
                            <th>Total</th>
                            <th>Forma de pagamento</th>
                            <th>Observações</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in sales" :key="item.id">
                            <td>{{item.id}}</td>
                            <td>{{ item.cliente }}</td>
                            <td>{{ item.produto.nome }}:{{ item.quantidade }}</td>
                            <td class="text-truncate">{{ item.valor_total | moeda }}</td>
                            <td>{{ item.forma_pagamento }}</td>
                            <td>{{ item.observacoes }}</td>
                            <td>{{ item.status ? 'Ok' : 'Pendente' }}</td>
                            <td class="text-truncate">{{ item.created_at }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#delete-venda-modal" @click="deleteSaleData= item">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <span v-show="loadMore">Aguarde...</span>
                <a href="#" @click.prevent="showMore" v-if="dataPage.next_page_url" v-show="!loadMore" key="showMore">
                    Exibir Mais Vendas
                </a>
            </div>
        </div>
        <DeleteSaleModal v-if="deleteSaleData" key="deleteSaleData" @getSales="getSales"
            :delete-sale-data="deleteSaleData" />
    </div>
</template>

<script>
    import DeleteSaleModal from '../components/modal/DeleteSaleModal'
    export default {
        data() {
            return {
                dataPage: false,
                sales: null,
                loadMore: false,
                valueSearch: '',
                deleteSaleData: false
            }
        },
        components: {
            DeleteSaleModal
        },
        methods: {
            getSales() {
                axios.get('/api/vendas', this.$store.state.configHeader).then(response => {
                    this.sales = response.data.data
                    this.$loading.hide()
                    this.dataPage = response.data
                })
            },
            showMore() {
                this.waitLoad()
                axios.get(this.dataPage.next_page_url, this.$store.state.configHeader).then(response => {
                    this.sales = this.sales.concat(response.data.data)
                    this.dataPage = response.data
                    this.waitLoad()
                    if (this.valueSearch != '' && this.dataPage.next_page_url) {
                        this.dataPage.next_page_url += "&s=" + this.valueSearch
                    }
                })
            },
            search() {
                this.sales = null
                this.waitLoad()
                axios.get('/api/vendas/search?s=' + this.valueSearch, this.$store.state.configHeader).then(response => {
                    this.sales = response.data.data
                    this.dataPage = response.data
                    if (this.valueSearch != '' && this.dataPage.next_page_url) {
                        this.dataPage.next_page_url += "&s=" + this.valueSearch
                    }
                    this.waitLoad()
                })
            },
            waitLoad() {
                this.loadMore = !this.loadMore
            }
        },
        created() {
            this.$loading.show()
            this.getSales()
        },
        metaInfo: {
            title: 'Vendas',
        }
    }

</script>
