## Guida all'installazione sistema custom Newsletter

I seguenti comandi andranno copiati sul terminale

**Clona la repository**
git clone https://github.com/micheelegatti/progetto_tesi.git
cd progetto_tesi

**Copia il file di configurazioni** /
cp .env.example .env

**Installa le dipendenze** \
composer install

I seguenti comandi sono eseguili solo se sail è salvata nelle variabili d'ambiente 
Sennò utilizzare    ./vendor/bin/sail  al posto di sail

-- Avvia i container con sail
sail up -d 

--Configura applicazione e database 
sail artisan key:generate
sail artisan migrate --seed

--Avvio front-end 
sail npm install
sail npm run dev

## Avvio progetto
L'applicazione è su http://localhost:8080/
Il servizio di Mailpit con le email di prova invece è su http://localhost:8025/

Utente admin generato tramite Seed del database
Username: admin@test
Password: password123
