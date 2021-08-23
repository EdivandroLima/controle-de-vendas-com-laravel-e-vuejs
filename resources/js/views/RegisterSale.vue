<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title font-weight-bold">Registrar venda</h5>
            <div class="">
                <div class="form-group text-right">
                    <label for="input-pesquisar-produto" class="sr-only">
                        Digite o nome do produto ou o código
                    </label>
                    <input id="input-pesquisar-produto" class="form-control" type="text" name=""
                        placeholder="Digite o nome do produto ou o código" v-model="valueSearch" @keyup.enter="search">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 mb-3">
                    <form action="#" method="post" name="formAddValue" @submit.prevent>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Qtd</th>
                                        <th>Valor</th>
                                        <th>Categoria</th>
                                        <th>Add ao carrinho</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in products" :key="item.id">
                                        <td>{{ item.codigo }}</td>
                                        <td>{{ item.nome }}</td>
                                        <td>{{ item.quantidade }}</td>
                                        <td class="text-truncate">{{ item.valor | moeda }}</td>
                                        <td>{{ item.categoria.nome }}</td>
                                        <td>
                                            <div class="input-group flex-nowrap">
                                                <input class="form-control" type="number" min="0" :max="item.quantidade"
                                                    value="0" style="width: 80px" :id="item.codigo"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button"
                                                        @click="addToCart(item)">
                                                        <span class="sr-only">
                                                            Adicionar ao carrinho
                                                        </span>
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <span v-show="loadMore">Aguarde...</span>
                        <a href="#" @click.prevent="showMore" v-if="dataPage.next_page_url" v-show="!loadMore"
                            key="showMore">
                            Exibir Mais Produtos
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="bg-light p-3 card">
                        <h5 class="card-title font-weight-bold">Carrinho de compras </h5>
                        <ul class="list-group list-group-flush bg-light">
                            <li class="list-group-item bg-light px-0 d-flex align-items-start justify-content-between"
                                v-for="(item, index) in cartProducts" :key="`item${index}`">
                                <div>
                                    <strong>{{ item.nome }}</strong> <br>
                                    Qtd: {{ item.quantidade }}<br>
                                    <strong> {{ item.valor_total | moeda }}</strong>
                                </div>
                                <button type="button" class="btn btn-none  text-danger btn-sm"
                                    @click="removeItemCart(item.produto_id)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </li>
                        </ul>
                        <div class="mt-3" v-if="cartProducts.length" key='subtotal'>
                            <h5>
                                Subtotal ({{ subTotal().itens }} itens): <strong>{{ subTotal().valor | moeda }}</strong>
                            </h5>
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal"
                                data-target="#finalizar-venda-modal">
                                <strong>Vender</strong>
                            </button>
                        </div>
                        <div class="mt-3" v-else>
                            Nenhum produto adicionado
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <FinalizeSale :cart-products="cartProducts" :sub-total="subTotal()" @resetData="resetData" />
    </div>
</template>

<script>
    import FinalizeSale from '../components/modal/FinalizeSale'
    export default {
        data() {
            return {
                cartProducts: [],
                dataPage: false,
                products: null,
                loadMore: false,
                valueSearch: '',
            }
        },
        components: {
            FinalizeSale
        },
        methods: {
            addToCart(prod) {
                let qtd = parseInt(document.getElementById(prod.codigo).value)
                if (!qtd) return;

                let product = [{
                    produto_id: prod.id,
                    codigo: prod.codigo,
                    nome: prod.nome,
                    valor_total: prod.valor * qtd,
                    quantidade: qtd,
                }]

                // remove produto se já tiver add no carrinho, e add ele com novos valores
                // para evitar repetições do mesmo produto no carrinho
                this.cartProducts = this.cartProducts.filter(function (value) {
                    if (value.produto_id != prod.id) {
                        return true;
                    }
                })

                // add produto ao carrinho
                this.cartProducts = product.concat(this.cartProducts)
            },
            removeItemCart(id) {
                this.cartProducts = this.cartProducts.filter(function (value) {
                    if (value.produto_id != id) {
                        return true;
                    }
                })
            },
            subTotal() {
                if (!this.cartProducts.length) {
                    return {
                        valor: 0,
                        itens: 0
                    }
                }
                let valor = this.cartProducts.reduce((total, item) => {
                    return total + item.valor_total
                }, 0)

                let itens = this.cartProducts.reduce((total, item) => {
                    return total + item.quantidade
                }, 0)

                return {
                    valor,
                    itens
                }
            },
            resetData() {
                document.formAddValue.reset()
                $('#finalizar-venda-modal').modal('hide')
                this.getProducts()
                this.cartProducts = []
            },
            getProducts() {
                axios.get('/api/produtos', this.$store.state.configHeader).then(response => {
                    this.products = response.data.data
                    this.$loading.hide()
                    this.dataPage = response.data
                })
            },
            showMore() {
                this.waitLoad()
                axios.get(this.dataPage.next_page_url, this.$store.state.configHeader).then(response => {
                    this.products = this.products.concat(response.data.data)
                    this.dataPage = response.data
                    this.waitLoad()
                    if (this.valueSearch != '' && this.dataPage.next_page_url) {
                        this.dataPage.next_page_url += "&s=" + this.valueSearch
                    }
                })
            },
            search() {
                this.products = null
                this.waitLoad()
                axios.get('/api/produtos/search?s=' + this.valueSearch, this.$store.state.configHeader).then(
                    response => {
                        this.products = response.data.data
                        this.dataPage = response.data
                        if (this.valueSearch != '' && this.dataPage.next_page_url) {
                            this.dataPage.next_page_url += "&s=" + this.valueSearch
                        }
                        this.waitLoad()
                    }
                )
            },
            waitLoad() {
                this.loadMore = !this.loadMore
            }
        },
        created() {
            this.$loading.show()
            this.getProducts()
        },
        metaInfo: {
            title: 'Registrar venda',
        }
    }

</script>

<style scoped>
    .fade-enter,
    .fade-leave-to {
        opacity: 0
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .2s;
    }

</style>
