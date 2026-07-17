@extends('default')

@section('content')
<div class="space-y-6">
    
    <div>
        <h1 class="text-2xl font-bold text-white">Modifica Template</h1>
    </div>

    <form action="#" method="POST" class="space-y-4 bg-slate-900/50 p-6 rounded-xl border border-slate-800">
        @csrf {{-- Questo serve solo a Laravel per non farti dare errore 419 quando salvi --}}

        <div>
            <label class="block text-sm font-medium text-slate-400 mb-2">Nome</label>
            <input type="text" name="name" class="w-full rounded-lg border border-slate-800 bg-slate-950 px-4 py-2 text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-400 mb-2">Contenuto</label>
            <textarea name="content" rows="10" class="w-full rounded-lg border border-slate-800 bg-slate-950 px-4 py-2 text-white"></textarea>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 px-4 py-2 rounded-lg text-white font-semibold">Salva</button>
        </div>
    </form>

</div>
@endsection