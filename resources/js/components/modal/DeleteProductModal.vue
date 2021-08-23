<template>
    <div id="delete-product-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-info-circle fa-4x"></i>
                    </div>
                    Tem certeza que deseja excluir <strong>{{deleteProductData.nome}}</strong> permanentemente?
                </div>
                <div class="modal-footer">

                    <button class="btn btn-sm px-4 btn-danger" type="submit" aria-label="Excluir"
                        @click="deleteProduct">
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
            deleteProduct() {
                axios.delete(
                    '/api/produtos/' + this.deleteProductData.id,
                    this.$store.state.configHeader
                ).then(() => {
                    this.$emit('getProducts')
                    $('#delete-product-modal').modal('hide')
                })
            }
        },
        props: {
            deleteProductData: Object
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
