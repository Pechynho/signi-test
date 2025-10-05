# Spuštění aplikace
- pro jednoduchost jsem ponechal všechny potřebné ENV proměnné v `.env` souboru, který je součást GITu (v reálné aplikaci samozřejmě `.env` soubor do GITu nepatří)
- pro build kontejnerů spusťe příkaz `docker compose build`
- pro spuštění prostředí pusťte příkaz `docker compose up -d`
- pro instalaci PHP závislostí spusťte příkaz `docker compose exec php composer install`
- pro migraci DB spusťte příkaz `docker compose exec php bin/console doctrine:migrations:migrate`
- aplikace poběží na adrese `https://127.0.0.1` (případně `https://localhost`)
- pokud by byly problém s certifikátem, tak si ho můžete nainstalovat do svého systému ze složky `docker/nginx/certificate`

# Adminer
- adminer běží na adrese `https://127.0.0.1:8080` (případně `https://localhost:8080`)

# API Endpoints
## Výpis workspaces

Endpoint podporuje stránkování pomocí následujících parametrů:

- `pagination-page`: Číslo stránky (začíná od 1)
- `pagination-limit`: Počet záznamů na stránku (povolené hodnoty: 10, 20, 50, 100)

Příklad:

- `https://127.0.0.1/workspace?pagination-page=1&pagination-limit=10`

## Detail workspace

Endpoint vrací detail workspace včetně všech kontaktů s jejich custom input hodnotami. Data jsou načítána pomocí eager loadingu, aby se předešlo N+1 problému.

Endpoint podporuje volitelný parametr:

- `query`: Vyhledávání v kontaktech podle firstname, lastname nebo email (částečná shoda)

Příklady:

- `https://127.0.0.1/workspace/1`
- `https://127.0.0.1/workspace/1?query=test`
