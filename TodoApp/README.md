# Codilar_TodoApp (Magento 2 GraphQL CRUD)

A beginner friendly Magento 2 module: Create, Read, Update, Delete todos using GraphQL, stored in the table `codilar_todoapp_todo`.

## Install

1. Copy the `Codilar` folder to `app/code/` of your Magento project, so you get:
   `app/code/Codilar/TodoApp/`
2. Run from the Magento root:

```bash
bin/magento module:enable Codilar_TodoApp
bin/magento setup:upgrade
bin/magento setup:di:compile      # only needed in production mode
bin/magento cache:flush
```

`setup:upgrade` creates the table from `etc/db_schema.xml`.

## Folder structure

| File | Purpose |
|------|---------|
| `registration.php`, `composer.json`, `etc/module.xml` | Register the module |
| `etc/db_schema.xml`, `etc/db_schema_whitelist.json` | Create the DB table |
| `etc/schema.graphqls` | Describes the GraphQL queries and mutations |
| `Model/Todo.php` | Model (one todo) |
| `Model/ResourceModel/Todo.php` | ResourceModel (DB load/save/delete) |
| `Model/ResourceModel/Todo/Collection.php` | Collection (list of todos) |
| `Model/Resolver/Todos.php` | Read all |
| `Model/Resolver/TodoById.php` | Read one |
| `Model/Resolver/CreateTodo.php` | Create |
| `Model/Resolver/UpdateTodo.php` | Update |
| `Model/Resolver/DeleteTodo.php` | Delete |

## Test it

GraphQL endpoint: `https://your-magento-site.test/graphql`

Use Postman (method POST, body type GraphQL), Altair, or the GraphQL browser extension.

### Create
```graphql
mutation {
  createTodo(title: "Learn Magento GraphQL", description: "Practice CRUD") {
    id
    title
    description
    completed
    created_at
  }
}
```

### Read all
```graphql
{
  todos {
    id
    title
    description
    completed
    created_at
  }
}
```

### Read one
```graphql
{
  todo(id: 1) {
    id
    title
    completed
  }
}
```

### Update
```graphql
mutation {
  updateTodo(id: 1, completed: true) {
    id
    title
    completed
  }
}
```

### Delete
```graphql
mutation {
  deleteTodo(id: 1)
}
```

## Check the database

```sql
SELECT * FROM codilar_todoapp_todo;
```

## Good to know

- This API is open: anyone who can reach `/graphql` can create, update and delete todos. For a real project, add a customer token or admin check inside the resolvers.
- If a GraphQL change does not show up, run `bin/magento cache:flush`.
