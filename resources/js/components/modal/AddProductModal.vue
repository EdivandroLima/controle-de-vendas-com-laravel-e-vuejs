<template>
    <div id="add-product-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-product-modal-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-product-modal-title">Adicionar produto</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post" @submit.prevent="addProduct($event)">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nome-produto-input">Nome</label>
                            <input id="nome-produto-input" :class="['form-control', errors.nome ? 'is-invalid' : '']"
                                type="text" name="nome">
                            <div class="invalid-feedback">
                                {{ errors.nome ? errors.nome[0] : '' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="qtd-produto-input">Quantidade</label>
                                <input id="qtd-produto-input"
                                    :class="['form-control', errors.quantidade ? 'is-invalid' : '']" type="number"
                                    name="quantidade" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <div class="invalid-feedback">
                                    {{ errors.quantidade ? errors.quantidade[0] : '' }}
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="valor-produto-input">Valor</label>
                                <input id="valor-produto-input"
                                    :class="['form-control', errors.valor ? 'is-invalid' : '']" type="number"
                                    name="valor" placeholder=""
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <div class="invalid-feedback">
                                    {{ errors.valor ? errors.valor[0] : '' }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="categoria-produto-select">Categoria</label>
                            <select id="categoria-produto-select"
                                :class="['custom-select', errors.categoria_id ? 'is-invalid' : '']" name="categoria_id">
                                <option v-for="(value, index) in categories" :key="value" :value="index">
                                    {{ value }}
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                {{ errors.categoria_id ? errors.categoria_id[0] : '' }}
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: {},
                errors: {}
            }
        },
        methods: {
            addProduct(e) {
                let form = new FormData(e.target)
                axios.post('/api/produtos', form, this.$store.state.configHeader).then(response => {
                    this.$emit('getProducts')
                    $('#add-product-modal').modal('hide')
                    e.target.reset()
                    this.errors = {}
                }).catch(error => {
                    this.errors = error.response.data.errors
                })
            }
        },
        created() {
            axios.get('/api/categorias/nomes', this.$store.state.configHeader).then(response => {
                this.categories = response.data
            })
        },
    }

</script>

<style scoped>
    @media (min-width: 768px) {
        .modal-dialog {
            max-width: 450px;
        }
    }

</style>
