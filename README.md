## Como iniciar

1. `npm install`
2. `composer update`
3. Altere o arquivo .env.example para .env
4. Configure o banco de dados no seu .env e crie um banco limpo
5. `php artisan migrate:fresh --seed`
6. `php artisan key:generate`
7. `php artisan storage:link`
8. `php artisan serve`
9. `npm run watch`
10. Acesse: http://localhost:8000 ou sua APP_URL (no .ENV)

## Conta Administrativa

-   **Email:** admin@sistema.com.br
-   **Senha:** admin

## Conta para Desenvolvimento

-   **Email:** developer@sistema.com.br
-   **Senha:** developer
