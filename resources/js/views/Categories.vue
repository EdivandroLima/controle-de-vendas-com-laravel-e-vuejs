<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-category-modal">
                        Adicionar categoria
                    </button>
                </div>
                <div class="form-group text-right">
                    <label for="input-pesquisar-produto" class="sr-only">Pesquisar categoria</label>
                    <input id="input-pesquisar-produto" class="form-control" type="text" name=""
                        placeholder="Digite um nome..." v-model="valueSearch" @keyup.enter="search">
                </div>
            </div>
            <div v-if="dataPage && dataPage.path.indexOf('search') != -1" key="totalEncontrados">
                Total de <strong>{{ dataPage.total }}</strong> resultados
            </div>
            <div v-else key="totalCategorias">
                Total de <strong>{{ dataPage.total }}</strong> categorias
            </div>
            <div class="table-responsive my-2">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in categories" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.nome }}</td>
                            <td>{{ item.created_at }}</td>
                            <td class="text-truncate">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#edit-category-modal" @click="editCategoryData= item">
                                    Editar
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#delete-category-modal" @click="deleteCategoryData= item">
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
                    Exibir Mais Categorias
                </a>
            </div>
        </div>
        <AddCategoryModal @getCategories="getCategories" />
        <EditCategoryModal @getCategories="getCategories" :edit-category-data="editCategoryData" />
        <DeleteCategoryModal @getCategories="getCategories" :delete-category-data="deleteCategoryData" />
    </div>
</template>

<script>
    import AddCategoryModal from '../components/modal/AddCategoryModal'
    import EditCategoryModal from '../components/modal/EditCategoryModal'
    import DeleteCategoryModal from '../components/modal/DeleteCategoryModal'
    export default {
        data() {
            return {
                dataPage: false,
                categories: null,
                loadMore: false,
                valueSearch: '',
                editCategoryData: {},
                deleteCategoryData: {},
            }
        },
        components: {
            AddCategoryModal,
            EditCategoryModal,
            DeleteCategoryModal
        },
        methods: {
            getCategories() {
                axios.get('/api/categorias', this.$store.state.configHeader).then(response => {
                    this.categories = response.data.data
                    this.$loading.hide()
                    this.dataPage = response.data
                })
            },
            showMore() {
                this.waitLoad()
                axios.get(this.dataPage.next_page_url, this.$store.state.configHeader).then(response => {
                    this.categories = this.categories.concat(response.data.data)
                    this.dataPage = response.data
                    this.waitLoad()
                    if (this.valueSearch != '' && this.dataPage.next_page_url) {
                        this.dataPage.next_page_url += "&s=" + this.valueSearch
                    }
                })
            },
            search() {
                this.categories = null
                this.waitLoad()
                axios.get('/api/categorias/search?s=' + this.valueSearch, this.$store.state.configHeader).then(
                    response => {
                        this.categories = response.data.data
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
            this.getCategories()
        },
        metaInfo: {
            title: 'Categorias',
        }
    }

</script>
