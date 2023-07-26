## Laravel Transaction API with Kafka
Codificação em PHP de uma API RESTful simples implementada usando Laravel. Ele fornece endpoints para criar, ler, atualizar e deletar transações. Além disso, ele usa o Apache Kafka para publicar mensagens sempre que uma transação é criada, atualizada ou deletada.

**Requisitos**
PHP 8.2
Laravel 10
Extensão RdKafka para PHP
Apache Kafka
Instalação
Clone este repositório
Instale as dependências do projeto com o Composer: composer install

Execute as migrações do banco de dados: php artisan migrate
Inicie o servidor de desenvolvimento do Laravel: php artisan serve

**A API fornece os seguintes endpoints:**

GET /api/transactions: Retorna todas as transações
POST /api/transactions: Cria uma nova transação
GET /api/transactions/{id}: Retorna uma transação específica
PUT /api/transactions/{id}: Atualiza uma transação específica
DELETE /api/transactions/{id}: Deleta uma transação específica

Quando uma transação é criada, atualizada ou deletada, uma mensagem é publicada em um tópico do Kafka.

Autor
**Emerson Amorim**