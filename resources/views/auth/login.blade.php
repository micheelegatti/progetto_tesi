<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Accedi</title>

        {{-- Script inline per intercettare la dark mode del sistema (preso dal tuo app.blade) --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';
                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        <style>
            html { background-color: oklch(1 0 0); }
            html.dark { background-color: oklch(0.145 0 0); }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts

        {{-- Carichiamo solo i CSS di Tailwind generati da Vite --}}
        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-zinc-900 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-md w-full space-y-8 bg-white dark:bg-zinc-800 p-8 rounded-xl shadow-lg border border-gray-100 dark:border-zinc-700">
            <div>
                <h2 class="mt-2 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                    Accedi a SoftwebMail
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Sistema di newsletter per la tesi di Michele Gatti
                </p>
            </div>

            {{-- Mostra eventuali errori di validazione (es. password errata) --}}
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 p-3 rounded-lg text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- Il form punta alla rotta POST login standard di Laravel --}}
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" BelongsTo required autofocus
                            class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 dark:border-zinc-600 placeholder-gray-500 text-gray-900 dark:text-white bg-white dark:bg-zinc-700 rounded-t-md focus:outline-none focus:ring-[#722e89] focus:border-[#722e89] focus:z-10 sm:text-sm" 
                            placeholder="Indirizzo Email">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required 
                            class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 dark:border-zinc-600 placeholder-gray-500 text-gray-900 dark:text-white bg-white dark:bg-zinc-700 rounded-b-md focus:outline-none focus:ring-[#722e89] focus:border-[#722e89] focus:z-10 sm:text-sm" 
                            placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Ricordami su questo dispositivo
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#722e89] hover:bg-[#5e2272]  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Accedi
                    </button>
                </div>
            </form>
        </div>

    </body>
</html>