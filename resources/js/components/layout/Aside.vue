<template>
    <aside>
        <div class="coluna-lateral text-white bg-dark">
            <ul class="list-unstyled">
                <li>
                    <router-link to="/">
                        <i class="fas fa-tachometer-alt mr-1"></i> Painel
                    </router-link>
                    <router-link to="/produtos">
                        <i class="fas fa-box-open mr-1"></i> Produtos
                    </router-link>
                    <router-link to="/registrar-venda">
                        <i class="fas fa-cart-plus mr-1"></i> Registrar Venda
                    </router-link>
                    <router-link to="/vendas">
                        <i class="fas fa-shopping-cart mr-1"></i> Vendas
                    </router-link>
                    <router-link to="/categorias">
                        <i class="fas fa-folder mr-1"></i> Categorias
                    </router-link>
                    <router-link to="/relatorios">
                        <i class="fas fa-chart-pie mr-1"></i> Relatórios
                    </router-link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<style scoped>
    .coluna-lateral {
        padding: 0;
        min-height: calc(100vh - 40px);
        overflow: hidden;
    }

    .coluna-lateral li a {
        display: block;
        padding: 8px 15px;
        color: rgba(255, 255, 255, .8);
        background: transparent;
        border-left: 2px solid transparent;
    }

    .coluna-lateral li a:hover,
    .coluna-lateral a.active {
        background: #41484f;
        text-decoration: none;
        color: white;
        border-left: 2px solid rgb(15, 163, 226);
    }

</style>
