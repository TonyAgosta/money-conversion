# Money Conversion

Money conversion è un calcolatore di operazioni effettuate sul sistema monetario inglese in vigore fino al 1970.
Sarà possibile fare le le principali operazioni aritmetiche e interagire con un catalogo di prodotti sia tramite
interfaccia che tramite chiamate API.

## Installazione

1. Clona il repository:
   ```sh
    git clone https://github.com/TonyAgosta/money-conversion.git
   ```

2. Aggiorna la variabile di ambiente relatival db nel file .env
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
   docker exec -it money_conversion bash -c "cd project && php bin/console doctrine:migrations:migrate --no-interaction"
    ```
6. Vai alla pagina ```localhost:8741``` !

## API REST

Di seguito è possibile trovare le api disponili con alcuni esempi.

### Operazioni aritmetiche

#### Somma

/api/moltiplicazione

I parametri da utillizare sono "addendo_1" e "addendo_2".

Esempio:

   ```
   {
    "addendo_1":"15p 17s 8d",
    "addendo_2": "5p 19s 6d3"
   }
   ```

   ```sh
      curl --location 'localhost:8741/api/somma' \
        --header 'Content-Type: application/json' \
        --data '{
          "addendo_1":"15p 17s 8d",
          "addendo_2": "5p 19s 6d"
        }'
   ```

#### Differenza

/api/sottrazione

I parametri da utillizare sono "minuendo" e "sottraendo".

Esempio:

   ```
   {
    "minuendo":"15p 17s 8d",
    "sottraendo": "5p 19s 6d"
   }
   ```

   ```sh
      curl --location 'localhost:8741/api/sottrazione' \
        --header 'Content-Type: application/json' \
        --data '{
          "minuendo":"15p 17s 8d",
          "sottraendo": "5p 19s 6d"
        } '
   ```

#### Moltiplicazione

/api/moltiplicazione

I parametri da utillizare sono "fattore_1" e "fattore_2".

Esempio:

   ```
   {
    "fattore_1":"5p 17s 8d",
    "fattore_2": "3"
   }
   ```

   ```sh
      curl --location 'localhost:8741/api/moltiplicazione' \
         --header 'Content-Type: application/json' \
         --data '{
             "fattore_1": "5p 17s 8d",
             "fattore_2": "3"
      }'
   ```

#### Divisione

/api/divisione

I parametri da utillizare sono "dividendo" e "divisore".

Esempio:

   ```
   {
    "dividendo":"5p 17s 8d",
    "divisore": "3"
   }
   ```

   ```sh
      curl --location 'localhost:8741/api/divisione' \
      --header 'Content-Type: application/json' \
      --data '{
          "dividendo":"5p 17s 8d",
          "divisore": "3"
      }'
   ```

### Catalogo

#### Elenco di proddtti

/api/list

   ```sh
      curl --location 'localhost:8741/api/list'
   ```

#### Visualizzazione di un prodotto dato il suo id

/api/prodotto/id_del_prodotto

```sh
  curl --location 'localhost:8741/api/prodotto/id_del_prodotto'
```

#### Aggiunta di un nuovo prodotto

/api/aggiungi-prodotto

I parametri da usare sono: nome (required), prezzo (required), descrizione (optional)

Esempio

   ```
   {
    "nome": "Prodotto 1",
    "prezzo": "5p 6s 2d",
    "descrizione": "Descrizione del prodotto"
   }
   ```

   ```sh
      curl --location 'localhost:8741/api/aggiungi-prodotto' \
      --header 'Content-Type: application/json' \
      --data '{
        "nome": "Prodotto 1",
        "prezzo": "5p 6s 2d",
        "descrizione": "Descrizione del prodotto"
      }'
   ```

#### Modifica di un prodotto dato il suo id

/api/edit/id_del_prodotto

Esempio

   ```
   {
    "nome": "Prodotto 1",
    "prezzo": "5p 6s 2d",
    "descrizione": "Descrizione del prodotto"
   }
   ```

   ```sh
     curl --location 'localhost:8741/api/edit/id_del_prodotto' \
      --header 'Content-Type: application/json' \
      --data '{
          "nome": "edit",
          "prezzo": "5p 6s 2d",
          "descrizione": "test descrizione"
      }'
   ```

#### Eliminazione di un prodotto dato il suo id

/api/delete/id_del_prodotto

I parametri da usare sono: nome (required), prezzo (required), descrizione (optional)

   ```sh
     curl --location --request POST 'localhost:8741/api/delete/id_del_prodotto'
   ```