# Money Conversion

Money conversion è un calcolatore di operazioni effetuate sul sistema monetario inglese in vigore fino al 1970.
Sarà possibile fare le le principali operazioni aritmetiche e interagire con un catalogo di prodotti sia tramite interfaccia che tramite chiamate API.

## Installazione

1. Clona il repository:
   ```sh
    git@github.com:TonyAgosta/money-conversion.git
   ```
2. Vai nella dir del progetto
    ```sh
    cd money-conversion/project
   cp .env.example .env
   aggiorna il valore di DATABASE_URL con "mysql://root:@money_conversion_db:3306/money-conversion?serverVersion=8&charset=utf8mb4"
   ```
3. Installa il progetto
    ```sh
   cd ../ (per ritornarne nella dir principale)
   docker compose install
   ```
4. Esegui le migrazioni dentro il container docker
    ```shell
   docker exec -it money_conversion bash -c "cd project && php bin/console make:migration && php bin/console doctrine:migrations:migrate"
    ```
5. Vai alla pagina localhost:8741 !
