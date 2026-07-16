<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PostaHub - Benvenuto</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between">

    <div></div>

    <main class="max-w-3xl mx-auto px-6 text-center">
        <span class="text-xs font-semibold uppercase tracking-wider text-blue-400 bg-blue-950/50 border border-blue-800 px-3 py-1 rounded-full">
            Tesi di Laurea - Mick
        </span>
        
        <h1 class="text-5xl font-extrabold tracking-tight mt-6 sm:text-6xl text-white">
            Piattaforma <span class="text-blue-500">PostaHub</span>
        </h1>
        
        <p class="mt-6 text-lg text-slate-400 leading-relaxed max-w-2xl mx-auto">
            Sistema di gestione e invio newsletter sviluppato con architettura Laravel per il backend e un'interfaccia interattiva in Blade e PrimeVue.
        </p>

        <div class="mt-10">
            <a href="/login" class="inline-block rounded-xl bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-lg hover:bg-blue-500 hover:shadow-blue-500/20 transition duration-200">
                Accedi al Sistema
            </a>
        </div>
    </main>

    <footer class="py-8 text-center text-sm text-slate-500 border-t border-slate-800/60 bg-slate-950/20">
        <p>© {{ date('Y') }} - Progetto di Tesi. Sviluppato con Laravel, Blade & PrimeVue.</p>
    </footer>

</body>
</html>