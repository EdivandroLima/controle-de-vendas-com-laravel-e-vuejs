# Controle de vendas com Laravel v8 e Vue.js v2
Projeto criado para a prática e estudo de Laravel + Vue.js. A aplicação é um sistema de controle de vendas com registro de categoria, registro de produto, registro de vendas e relatório de vendas diárias.

## Demonstração
Visualizar demo: https://www.teste-1234.com.br
E-mail: adm@teste.com.br
Senha: 12345678

## Dependências Vue.js
- [VueRouter](https://www.npmjs.com/package/vue-router)
- [Vuex](https://www.npmjs.com/package/vuex)
- [VueDialogLoading](https://github.com/leyap/vue-dialog-loading)
- [VueMeta](https://www.npmjs.com/package/vue-meta)
- [VueGoogleCharts](https://www.npmjs.com/package/vue-google-charts)
- [Bootstrap](https://www.npmjs.com/package/bootstrap)
- [Fortawesome](https://www.npmjs.com/package/@fortawesome/fontawesome-free)

## Instalação
**Instale as dependências**
```
$ composer install --no-scripts
```
**Copie o arquivo .env.example**
```
$ copy .env.example .env
```
**Crie uma nova chave para a aplicação** 
```
$ php artisan key:generate
```
**Configure o banco de dados (utilizei o MySQL) no arquivo .env e rodar os migrations com:**
```
$ php artisan migrate
// ou com os seeders, populando o banco de dados
$ php artisan migrate --seed
```
**Iniciando a aplicação**
```
$ php artisan serve
```

## API endpoints
É necessário passar um token de API para as requisições
```
// Exemplo header
'Authorization' => 'Bearer ' . Auth::user()->api_token,
'Accept' => 'application/json',
```
### Produtos
```
GET /api/produtos // Listar produtos com uma paginação
POST /api/produtos // Adicionar produto
GET /api/produtos/search?s={pesquisa} // Irá fazer uma busca por código/nome
PUT|PATCH /api/produtos/{id} // Editar um produto, passando por parâmetro o id
DELETE /api/produtos/{id} // Remover um produto, passando por parâmetro o id
```

Campos necessários para adicionar e editar um produto
- 'nome' (Obrigatório, mínimo 3 caracteres)
- 'quantidade' (Obrigatório, númerico)
- 'valor' (Obrigatório, númerico)
- 'categoria_id' (Obrigatório, númerico, ser o id de uma categoria)

### Categorias
```
GET /api/categorias // Listar categorias com uma paginação
GET /api/categorias/nomes // Listar apenas nome e id
POST /api/categorias // Adicionar categoria
GET /api/categorias/search?s={pesquisa} // Irá fazer uma busca pelo nome da categoria
PUT|PATCH /api/categorias/{id} // Editar uma categoria, passando por parâmetro o id
DELETE /api/categorias/{id} // Remover uma categoria, passando por parâmetro o id
```

Campos necessários para adicionar e editar uma categoria
- 'nome' (Obrigatório, mínimo 3 caracteres, único)

### Vendas
```
GET /api/vendas // Listar todas as vendas com uma paginação
GET /api/vendas/search?s={pesquisa} // Irá fazer uma busca pelo nome do cliente ou o nome do produto que foi vendido
GET /api/vendas/dias // Lista a data e a quantidade de vendas dos últimos 30 dias
POST /api/vendas // Fazer o registro de uma nova venda
DELETE /api/vendas/{id} // Remover o registro de uma venda, passando por parâmetro o id
```

Campos necessários para registrar uma venda
- 'produto_id'   (Obrigatório, ser o id de um produto)
- 'quantidade'   (Obrigatório, númerico)
- 'valor_total'   (Obrigatório, númerico)
- 'forma_pagamento'  (Obrigatório)
- 'status'  (Obrigatório, boolean)

## Factories
Inserindo múltiplos registros “aleatórios” dentro do Banco de Dados
```
// Executar o tinker
$ php artisan tinker

// Gerar dados de categorias
>>> App\Models\Categoria::factory(10)->create()
// Gerar dados de produtos
>>> App\Models\Produto::factory(10)->create()
// Gerar dados de vendas
>>> App\Models\Venda::factory(10)->create()
```