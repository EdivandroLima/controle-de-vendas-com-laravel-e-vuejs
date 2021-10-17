<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-1">
        <a class="navbar-brand">Brand</a>
        <button class="navbar-toggler" data-target="#my-nav-i" data-toggle="collapse" aria-controls="my-nav-i"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="my-nav-i" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">

                <li class="dropdown nav-item">
                    <a href="#" class="nav-link dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ userLogged.name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="my-dropdown">
                        <a class="dropdown-item" href="#" @click="logout">
                            <i class="fas fa-sign-out-alt fa-sm mr-1 text-muted"></i> strong
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        methods: {
            logout() {
                axios.post('/logout').then(() => {
                    window.location.href = '/'
                })
            }
        },
        props: {
            userLogged: Object
        },
    }

</script>

<style scoped>
    @media (min-width: 768px) {
        .navbar {
            height: 40px; 
        }
    }

</style>
