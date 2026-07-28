<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campagna->name ?? 'Campagna' }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: Arial, sans-serif;">
    <center style="width: 100%; background-color: #f4f4f5; table-layout: fixed;">
        <div style="max-width: 600px; background-color: #ffffff; margin: 0 auto; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
            
            @if(is_array($campagna->content))
                @foreach($campagna->content as $rootBlock)
                    @php
                        $blockType = $rootBlock['type'] ?? '';
                        // Se il blocco è un contenitore o una sua variante, usa il file 'contenitori', altrimenti il nome del blocco
                        $viewName = in_array($blockType, ['container', 'header', 'footer', 'section']) 
                                    ? 'contenitori' 
                                    : $blockType;
                    @endphp
                    @include('email.blocks.' . $viewName, ['block' => $rootBlock])
                @endforeach
            @else
                {!! $campagna->content !!}
            @endif

        </div>
    </center>
</body>
</html>