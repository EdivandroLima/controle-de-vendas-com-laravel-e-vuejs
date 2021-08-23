<template>
    <div id="edit-category-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="edit-category-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="edit-category-modal-title">Editar categoria</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" @submit.prevent="editCategory($event)">
                        <div class="form-group">
                            <label for="add-nome-categoria-input">Nome</label>
                            <input id="add-nome-categoria-input"
                                :class="['form-control', errors.nome ? 'is-invalid' : '']" type="text" name="nome"
                                :value="editCategoryData.nome" required>
                            <div class="invalid-feedback">
                                {{ errors.nome ? errors.nome[0] : '' }}
                            </div>
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                        <button class="btn btn-primary btn-block">Salvar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                errors: {}
            }
        },
        methods: {
            editCategory(e) {
                let form = new FormData(e.target)
                axios.post(
                    '/api/categorias/' + this.editCategoryData.id, form,
                    this.$store.state.configHeader
                ).then(response => {
                    this.$emit('getCategories')
                    $('#edit-category-modal').modal('hide')
                    this.errors = {}
                }).catch(error => {
                    this.errors = error.response.data.errors
                })
            }
        },
        props: {
            editCategoryData: Object
        },
    }

</script>
