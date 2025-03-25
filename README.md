# Money Conversion

Money conversion è un calcolatore di operazioni effetuate sul sistema monetario inglese in vigore fino al 1970.
Sarà possibile fare le le principali operazioni aritmetiche e interagire con un catalogo di prodotti sia tramite interfaccia che tramite chiamate API.

## Installazione

1. Clona il repository:
   ```sh
    git clone https://github.com/TonyAgosta/money-conversion.git
   ```
   
2. Aggiorna le informazioni relative al db
   ```sh
   cd money-conversion/project
   ```
   ```sh
   cp .env.example .env
   ```
   e aggiorna il valore di DATABASE_URL nel .env con 
   ```sh
   "mysql://root:@money_conversion_db:3306/money-conversion?serverVersion=8&charset=utf8mb4"
   ```
3. Build del progetto
    ```sh
   cd ../ && docker compose up -d
   ```
4. Installa il progetto
   ```sh
   docker exec -it money_conversion bash -c "cd project && composer install"
   ```
5. Esegui le migrazioni dentro il container docker
    ```shell
   sudo docker exec -it money_conversion bash -c "cd project && php bin/console doctrine:migrations:migrate --no-interaction"
    ```
6. Vai alla pagina localhost:8741 !
