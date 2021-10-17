<template>
    <div>
        <Header :user-logged="userLogged" />
        <div class="container-fluid">
            <div class="row">
                <div :class="['col-2 bg-dark', aside ? 'toggle-menu':'']">
                    <Aside />
                </div>
                <div :class="[aside ? 'col-12':'col-10']">

                    <div class="bg-white border-bottom">
                        <button class="btn btn-white py-1 d-none d-md-inline-block" @click="toggleAside">
                            <i class="fas fa-bars"></i>
                        </button>
                        <ul :class="['list-unstyled list-inline m-0 links', 
                            aside ? 'd-inline-block' : 'd-md-none']">
                            <li>
                                <router-link to="/" class="btn btn-white p-1" title="Painel">
                                    <i class="fas fa-tachometer-alt mr-1"></i>
                                </router-link>
                                <router-link to="/produtos" class="btn btn-white p-1" title="Produtos">
                                    <i class="fas fa-box-open mr-1"></i>
                                </router-link>
                                <router-link to="/registrar-venda" class="btn btn-white p-1" title="Registrar Venda">
                                    <i class="fas fa-cart-plus mr-1"></i>
                                </router-link>
                                <router-link to="/vendas" class="btn btn-white p-1" title="Vendas">
                                    <i class="fas fa-shopping-cart mr-1"></i>
                                </router-link>
                                <router-link to="/categorias" class="btn btn-white p-1" title="Categorias">
                                    <i class="fas fa-folder mr-1"></i>
                                </router-link>
                                <router-link to="/relatorios" class="btn btn-white p-1" title="Relatórios">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                </router-link>
                            </li>
                        </ul>
                    </div>

                    <div class="p-3">
                        <transition name="fade" mode="out-in">
                            <router-view></router-view>
                        </transition>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Header from './Header';
    import Aside from './Aside';
    export default {
        data() {
            return {
                aside: false,
                userLogged: {}
            }
        },
        methods: {
            toggleAside() {
                this.aside = !this.aside
                this.aside ? document.cookie = "aside=1" : document.cookie = "aside=0";
            }
        },
        components: {
            Header,
            Aside
        },
        props: {
            user: String
        },
        created() {
            if (document.cookie.indexOf('aside=1') != -1) {
                this.aside = true
            }
            this.userLogged = JSON.parse(this.user)
        },
    }

</script>

<style scoped>
    .col-2 {
        max-width: 15%;
        transition: margin .5s;
        padding: 0;
        background-color: #212529 !important;
    }

    .col-10 {
        min-width: 85%;
        transition: all .5s;
        padding: 0;
    }

    .col-12 {
        min-width: 100%;
        transition: all .5s;
        padding: 0;
    }

    .toggle-menu {
        margin-left: -15%;
    }

    @media (max-width: 576px) {
        .col-2 {
            margin-left: -15% !important;
        }

        .col-10 {
            min-width: 100% !important;
        }

        .links {
            text-align: center;
            padding: 4px 8px;
        }

        .links .btn {
            margin: 0 4px;
        }
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .2s;
    }

</style>

<style>
    #app {
        overflow: hidden;
    }

    .navbar {
        background-color: #e36b13 !important
    }

</style>
