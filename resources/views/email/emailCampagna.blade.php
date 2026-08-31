<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campagna->name ?? 'Campagna' }}</title>
    <style>
        /* --- RESET CSS PER EMAIL --- */
        body { 
            margin: 0; 
            padding: 0; 
            -webkit-text-size-adjust: 100%; 
            -ms-text-size-adjust: 100%; 
            background-color: #f4f4f5; 
            font-family: Arial, sans-serif;
            overflow-wrap: break-word;
            word-wrap: break-word; 
            width: 100% !important;
            overflow-x: hidden;
        }
        table { 
            border-collapse: collapse; 
            mso-table-lspace: 0pt; 
            mso-table-rspace: 0pt; 
        }
        img { 
            border: 0; 
            height: auto; 
            line-height: 100%; 
            outline: none; 
            text-decoration: none; 
            max-width: 100% !important; 
        }

        div, p, h1, h2, h3, h4, h5, h6, span {
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: none;
        }

        /* --- MEDIA QUERY RESPONSIVE PER SMARTPHONE (< 600px) --- */
        @media screen and (max-width: 600px) {
            body {
                width: 100% !important;
                min-width: 100% !important;
            }
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
            }
            /* Forza le colonne affiancate ad andare una sotto l'altra su mobile senza sforare */
            .email-column {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            /* Impedisce alle tabelle interne di creare overflow */
            table {
                width: 100% !important;
                max-width: 100% !important;
            }
            /* Ridimensiona i titoli grandi sugli schermi piccoli */
            .email-title h1 {
                font-size: 24px !important;
                line-height: 28px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: Arial, sans-serif; width: 100% !important;">
    
    <!-- PREHEADER NASCOSTO (Anteprima dell'email nella inbox) -->
    @if(!empty($invioCampagna->sommario))
        <div style="display: none; font-size: 1px; color: #f4f4f5; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; mso-line-height-rule: exactly;">
            {{ $invioCampagna->sommario }}
            <!-- Questa sequenza riempie lo spazio vuoto impedendo a Gmail/Outlook di leggere il resto dell'email -->
            &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
        </div>
    @endif

    <!-- CENTRATURA PER EMAIL (Rimosso table-layout: fixed) -->
    <center style="width: 100%; background-color: #f4f4f5; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">
        <!-- AGGIUNTO box-sizing inline esplicito per sicurezza su Outlook/client mobile -->
        <div class="email-container" style="max-width: 600px; width: 100%; background-color: #ffffff; margin: 0 auto; box-shadow: 0 0 10px rgba(0,0,0,0.05); text-align: left; box-sizing: border-box;">
            
            @if(is_array($campagna->content))
                @foreach($campagna->content as $rootBlock)
                    @php
                        $blockType = $rootBlock['type'] ?? '';
                        // Se il blocco è un contenitore o una sua variante, usa il file 'contenitori', altrimenti il nome del blocco
                        $viewName = in_array($blockType, ['container', 'header', 'footer', 'section']) 
                                    ? 'contenitori' 
                                    : $blockType;
                    @endphp
                    @include('email.block.' . $viewName, ['block' => $rootBlock])
                @endforeach
            @else
                {!! $campagna->content !!}
            @endif

        </div>
    </center>
</body>
</html>