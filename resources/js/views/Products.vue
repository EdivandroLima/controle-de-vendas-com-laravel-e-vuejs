<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-product-modal">
                        Adicionar produto
                    </button>
                </div>
                <div class="form-group text-right">
                    <label for="input-pesquisar-produto" class="sr-only">Pesquisar produto</label>
                    <input id="input-pesquisar-produto" class="form-control" type="text" name=""
                        placeholder="Digite um nome..." v-model="valueSearch" @keyup.enter="search">
                </div>
            </div>
            <div v-if="dataPage && dataPage.path.indexOf('search') != -1" key="totalEncontrados">
                Total de <strong>{{ dataPage.total }}</strong> resultados
            </div>
            <div v-else key="totalCategorias">
                Total de <strong>{{ dataPage.total }}</strong> produtos
            </div>
            <div class="table-responsive my-2">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Qtd</th>
                            <th>Valor</th>
                            <th>Categoria</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in products" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.codigo }}</td>
                            <td>{{ item.nome }}</td>
                            <td>{{ item.quantidade }}</td>
                            <td>{{ item.valor | moeda }}</td>
                            <td>{{ item.categoria.nome }}</td>
                            <td class="text-truncate">{{ item.created_at }}</td>
                            <td class="text-truncate">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#edit-product-modal" @click="editProductData= item">
                                    Editar
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#delete-product-modal" @click="deleteProductData= item">
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
                    Exibir Mais Produtos
                </a>
            </div>
        </div>
        <AddProductModal @getProducts="getProducts" />
        <EditProductModal @getProducts="getProducts" :edit-product-data="editProductData" />
        <DeleteProductModal @getProducts="getProducts" :delete-product-data="deleteProductData" />
    </div>
</template>

<script>
    import AddProductModal from '../components/modal/AddProductModal'
    import EditProductModal from '../components/modal/EditProductModal'
    import DeleteProductModal from '../components/modal/DeleteProductModal'
    export default {
        data() {
            return {
                dataPage: false,
                products: null,
                loadMore: false,
                valueSearch: '',
                editProductData: {},
                deleteProductData: {}
            }
        },
        components: {
            AddProductModal,
            EditProductModal,
            DeleteProductModal
        },
        methods: {
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
                axios.get(
                    '/api/produtos/search?s=' + this.valueSearch,
                    this.$store.state.configHeader
                ).then(response => {
                    this.products = response.data.data
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
            this.getProducts()
        },
        metaInfo: {
            title: 'Produtos',
        }
    }

</script>