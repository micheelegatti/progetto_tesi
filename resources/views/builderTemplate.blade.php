@extends('app')

@section('content')
    <div id="app" class="h-[calc(100vh-4rem)] -m-6 md:-m-8 overflow-hidden">
        <editor-template 
            :template-id="{{ isset($template) ? $template->id : 'null' }}"
            initial-template-name="{{ $template->name ?? 'Nuovo Template Email' }}"
            :initial-blocks="{{ isset($template) && $template->content ? json_encode($template->content) : 'null' }}"
        ></editor-template>
    </div>
@endsection

@vite('resources/js/app.ts')