<template>
    <aside>
        <div class="coluna-lateral text-white">
            <ul class="list-unstyled">
                <li>
                    <router-link to="/">
                        <i class="fas fa-tachometer-alt mr-2"></i> Painel
                    </router-link>
                    <router-link to="/produtos">
                        <i class="fas fa-box-open mr-2"></i> Produtos
                    </router-link>
                    <router-link to="/registrar-venda">
                        <i class="fas fa-cart-plus mr-2"></i> Registrar Venda
                    </router-link>
                    <router-link to="/vendas">
                        <i class="fas fa-shopping-cart mr-2"></i> Vendas
                    </router-link>
                    <router-link to="/categorias">
                        <i class="fas fa-folder mr-2"></i> Categorias
                    </router-link>
                    <router-link to="/relatorios">
                        <i class="fas fa-chart-pie mr-2"></i> Relatórios
                    </router-link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<style scoped>
    .coluna-lateral {
        margin-top: 10px;
        padding: 0;
        min-height: calc(100vh - 40px);
        overflow: hidden;
        background-color: #212529;
    }

    .coluna-lateral li a {
        display: block;
        padding: 8px 8px;
        color: rgba(255, 255, 255, .8);
        background: transparent;
        border-left: 2px solid transparent;
        margin: 0 10px;
        border-radius: 4px;
    }

    .coluna-lateral a.active {
        color: white;
        background-color: #e36b13 !important;
        margin: 0 10px;
        border-radius: 4px;
        text-decoration: none;
    }

    .coluna-lateral li a:hover {
        color: white;
        background-color: #373d42;
        margin: 0 10px;
        border-radius: 4px;
        text-decoration: none;
    }

</style>
