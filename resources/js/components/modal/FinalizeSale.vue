<template>
    <div id="finalizar-venda-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="finalizar-venda-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finalizar-venda-modal-title">Finalizar venda</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="cliente-input">Cliente (opcional)</label>
                        <input id="cliente-input" class="form-control" type="text" name="cliente"
                            placeholder="Não identificado" v-model="saleInfo.cliente">
                    </div>
                    <div class="form-group">
                        <label for="metodo_pagamento">Método de pagamento*</label>
                        <select name="metodo_pagamento" id="metodo_pagamento" class="custom-select"
                            v-model="saleInfo.forma_pagamento">
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Cartão de débito">Cartão de débito</option>
                            <option value="Cartão de crédito">Cartao de crédito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="observacoes">Observações da venda (opcional)</label>
                        <textarea name="observacoes" id="observacoes" rows="3" class="form-control" placeholder="Não"
                            v-model="saleInfo.observacoes"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status da venda*</label>
                        <select name="status" id="status" class="custom-select" v-model="saleInfo.status">
                            <option value="1">Concluído</option>
                            <option value="0">Pendente</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <h5 class="text-center font-weight-bold">
                            Subtotal ({{ subTotal.itens }} itens): <strong>{{ subTotal.valor | moeda }}</strong>
                        </h5>
                    </div>
                    <button type="button" class="btn btn-success btn-block" @click="saveSalesData">
                        Finalizar venda
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                saleInfo: {
                    cliente: 'Não identificado',
                    forma_pagamento: 'Dinheiro',
                    status: 1,
                    observacoes: 'Não',
                }
            }
        },
        props: {
            cartProducts: Array,
            subTotal: Object
        },
        methods: {
            saveSalesData() {
                this.$loading.show()

                let count = 0;
                for (let i in this.cartProducts) {
                    let formData = {
                        ...this.cartProducts[i],
                        ...this.saleInfo
                    };

                    axios.post('/api/vendas', formData, this.$store.state.configHeader).then(response => {
                        count++;
                        if (count == this.cartProducts.length) {
                            this.$emit('resetData')
                        }
                    }).catch(error => {
                        console.log(error.response.data.errors)
                    })
                }
            },
        },
    }

</script>

<style scoped>
    @media (min-width: 768px) {
        .modal-dialog {
            max-width: 450px
        }
    }

</style>
