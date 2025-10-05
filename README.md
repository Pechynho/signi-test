# Spuštění aplikace
- pro jednoduchost jsem ponechal všechny potřebné ENV proměnné v `.env` souboru, který je součást GITu (v reálné aplikaci samozřejmě `.env` soubor do GITu nepatří)
- pro instalaci PHP závislostí spusťte příkaz `docker compose exec php composer install`
- pro migraci DB spusťte příkaz `docker compose exec php bin/console doctrine:migrations:migrate`
- pro spuštění prostředí pusťte příkaz `docker compose up`
- aplikace poběží na adrese `https://127.0.0.1` (případně `https://localhost`)
- pokud by byly problém s certifikátem, tak si ho můžete nainstalovat do svého systému ze složky `docker/nginx/certificate`

# Adminer
- adminer běží na adrese `https://127.0.0.1:8080` (případně `https://localhost:8080`)
