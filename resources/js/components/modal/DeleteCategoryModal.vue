<template>
    <div id="delete-category-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-info-circle fa-4x"></i>
                    </div>
                    Tem certeza que deseja excluir <strong>{{deleteCategoryData.nome}}</strong> permanentemente?
                    Isso excluirá todos os produtos relacionados a essa categoria.
                </div>
                <div class="modal-footer">

                    <button class="btn btn-sm px-4 btn-danger" type="submit" aria-label="Excluir"
                        @click="deleteCategory">
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn btn-sm px-4 btn-secondary" type="button" data-dismiss="modal"
                        aria-label="Cancelar"><i class="fas fa-times"></i></button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            deleteCategory() {
                axios.delete(
                    '/api/categorias/' + this.deleteCategoryData.id,
                    this.$store.state.configHeader
                ).then(() => {
                    this.$emit('getCategories')
                    $('#delete-category-modal').modal('hide')
                })
            }
        },
        props: {
            deleteCategoryData: Object
        }
    }

</script>
<style scoped>
    @media (min-width: 768px) {
        .modal-dialog {
            max-width: 280px
        }
    }

</style>
