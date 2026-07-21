@extends('app')

@section('content')
    <div id="app" class="h-[calc(100vh-4rem)] -m-6 md:-m-8 overflow-hidden">
        <editor-template></editor-template>
    </div>
@endsection

@vite('resources/js/app.ts')
