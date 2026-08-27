## Guida all'installazione sistema custom Newsletter

I seguenti comandi andranno copiati sul terminale

Clona la repository \
*git clone https://github.com/micheelegatti/progetto_tesi.git* \
*cd progetto_tesi*

Duplica il file di configurazioni e rinomina .env\
*cp .env.example .env*

Creare container Docker: 
*docker compose up -d* 

Installare le dipendenze \
Se si ha WSL integrata o Linux/Mac usare:\
*./vendor/bin/sail composer install* \
Se hai configurato Sail nelle variabili d'ambiente, puoi usare direttamente *sail composer install* \
Se usi Windows con Powershell: \
*docker compose exec laravel.test composer install*

Configura applicazione e database \
*sail artisan key:generate* \
*sail artisan migrate --seed* \
Se non usi Sail, usa l'equivalente: \
*docker compose exec laravel.test artisan key:generate* \
*docker compose exec laravel.test artisan migrate --seed*


Avvio front-end:\ 
*sail npm install* \
*sail npm run dev*\
Se non usi Sail, usa l'equivalente: \
*docker compose exec laravel.test npm install* \
*docker compose exec laravel.test npm run dev*

## Avvio progetto
L'applicazione è su http://localhost:8080/ 
Il servizio di Mailpit con le email di prova invece è su http://localhost:8025/ \

Utente admin generato tramite Seed del database \
Username: admin@test \
Password: password123 
