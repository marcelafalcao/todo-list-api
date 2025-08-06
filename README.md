# API de Lista de Tarefas

Esta é uma API RESTful para gerenciar uma lista de tarefas, desenvolvida em PHP com o framework Symfony.

## Instalação

### Pré-requisitos

- Docker
- Docker Compose

### Passo a passo

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/seu-usuario/todo-list-api.git
   cd todo-list-api
   ```

2. **Inicie os containers:**

   ```bash
   docker-compose up -d
   ```

3. **Instale as dependências do Composer:**

   ```bash
   docker-compose exec app composer install
   ```

4. **Execute as migrações do banco de dados:**

   ```bash
   docker-compose exec app php bin/console doctrine:migrations:migrate
   ```

## Uso

A API estará acessível em `http://localhost:80`.

### Exemplos de Requisições com Postman

#### Criar uma nova tarefa

- **Método:** `POST`
- **URL:** `http://localhost/api/tarefas`
- **Corpo da requisição (JSON):**

  ```json
  {
      "titulo": "Minha primeira tarefa",
      "descricao": "Esta é a descrição da minha primeira tarefa."
  }
  ```

- **Resposta esperada (JSON):**

  ```json
  {
      "id": 1,
      "titulo": "Minha primeira tarefa",
      "descricao": "Esta é a descrição da minha primeira tarefa.",
      "concluida": false,
      "dataCriacao": "2025-08-05 15:00:00"
  }
  ```

#### Listar todas as tarefas

- **Método:** `GET`
- **URL:** `http://localhost/api/tarefas`
- **Resposta esperada (JSON):**

  ```json
  [
      {
          "id": 1,
          "titulo": "Minha primeira tarefa",
          "descricao": "Esta é a descrição da minha primeira tarefa.",
          "concluida": false,
          "dataCriacao": "2025-08-05 15:00:00"
      }
  ]
  ```

#### Obter uma tarefa específica

- **Método:** `GET`
- **URL:** `http://localhost/api/tarefas/1`
- **Resposta esperada (JSON):**

  ```json
  {
      "id": 1,
      "titulo": "Minha primeira tarefa",
      "descricao": "Esta é a descrição da minha primeira tarefa.",
      "concluida": false,
      "dataCriacao": "2025-08-05 15:00:00"
  }
  ```

#### Atualizar uma tarefa

- **Método:** `PUT`
- **URL:** `http://localhost/api/tarefas/1`
- **Corpo da requisição (JSON):**

  ```json
  {
      "titulo": "Minha primeira tarefa (atualizada)",
      "descricao": "Esta é a descrição atualizada da minha primeira tarefa.",
      "concluida": true
  }
  ```

- **Resposta esperada (JSON):**

  ```json
  {
      "id": 1,
      "titulo": "Minha primeira tarefa (atualizada)",
      "descricao": "Esta é a descrição atualizada da minha primeira tarefa.",
      "concluida": true,
      "dataCriacao": "2025-08-05 15:00:00"
  }
  ```

#### Excluir uma tarefa

- **Método:** `DELETE`
- **URL:** `http://localhost/api/tarefas/1`
- **Resposta esperada:**

  - **Status:** `204 No Content`
