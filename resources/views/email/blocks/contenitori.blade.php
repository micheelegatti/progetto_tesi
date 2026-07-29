@php
    $style = $block['style'] ?? [];
    $layout = $block['layout'] ?? [];
    $type = $block['type'] ?? 'container';
    
    $htmlTag = match($type) {
        'header' => 'header',
        'footer' => 'footer',
        'section' => 'section',
        default => 'div'
    };

    $cssStyles = [];
    if (!empty($style['backgroundColor'])) $cssStyles[] = "background-color: {$style['backgroundColor']}";
    if (isset($style['width'])) $cssStyles[] = "width: {$style['width']}%";
    
    // Gestione altezza minima (nel settings usi i valori percentuali/vh)
    if (isset($style['minHeight'])) $cssStyles[] = "min-height: {$style['minHeight']}%";
    
    // Spaziature (Margini) - supportano sia interi che decimali se inseriti da Vue
    if (isset($style['margin']['top'])) $cssStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $cssStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $cssStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $cssStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    // Spaziature (Padding)
    if (isset($style['padding']['top'])) $cssStyles[] = "padding-top: " . ($style['padding']['top'] * 16) . "px";
    if (isset($style['padding']['bottom'])) $cssStyles[] = "padding-bottom: " . ($style['padding']['bottom'] * 16) . "px";
    if (isset($style['padding']['right'])) $cssStyles[] = "padding-right: " . ($style['padding']['right'] * 16) . "px";
    if (isset($style['padding']['left'])) $cssStyles[] = "padding-left: " . ($style['padding']['left'] * 16) . "px";

    // Bordi (spessore, stile, colore, radius)
    if (isset($style['border']['width']) && $style['border']['width'] > 0) {
        $cssStyles[] = "border-width: {$style['border']['width']}px";
        if (!empty($style['border']['style'])) $cssStyles[] = "border-style: {$style['border']['style']}";
        if (!empty($style['border']['color'])) $cssStyles[] = "border-color: {$style['border']['color']}";
        if (isset($style['border']['radius'])) $cssStyles[] = "border-radius: {$style['border']['radius']}px";
    }

    $inlineStyle = implode('; ', $cssStyles);
    
    // Legge la direzione dal layout del tuo builder (con fallback sicuro a column)
    $flexDir = $layout['flexDirection'] ?? 'column';
    
    // Gap configurato nel layout
    $gap = $layout['gap'] ?? 0;
@endphp

<{!! $htmlTag !!} @if(!empty($inlineStyle)) style="{{ $inlineStyle }}; box-sizing: border-box;" @else style="box-sizing: border-box;" @endif>
    @if(!empty($block['children']))
        {{-- Aggiunta la classe email-row per consentire il responsive sulle tabelle orizzontali --}}
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100%; border-collapse: collapse;" class="email-row">
            @if($flexDir === 'column')
                {{-- MODALITÀ COLONNA: Elementi in verticale (<tr> separati) --}}
                @foreach($block['children'] as $child)
                    @php
                        $childViewName = in_array($child['type'] ?? '', ['container', 'header', 'footer', 'section']) ? 'contenitori' : ($child['type'] ?? '');
                        $childGap = $gap > 0 ? $gap / 2 : 0;
                    @endphp
                    <tr>
                        <td style="width: 100%; vertical-align: top; box-sizing: border-box; @if($childGap > 0) padding-bottom: {{ $childGap }}px; padding-top: {{ $childGap }}px; @endif">
                            @include('email.blocks.' . $childViewName, ['block' => $child])
                        </td>
                    </tr>
                @endforeach
            @else
                {{-- MODALITÀ RIGA: Elementi affiancati nello stesso <tr> --}}
                <tr>
                    @foreach($block['children'] as $child)
                        @php
                            $totalChildren = count($block['children']);
                            $defaultWidth = round(100 / max($totalChildren, 1));
                            $childWidth = $child['style']['width'] ?? $defaultWidth;
                            
                            // Se ci sono più figli e la larghezza è rimasta di default a 100, dividi equamente
                            if ($totalChildren > 1 && $childWidth == 100) {
                                $childWidth = $defaultWidth;
                            }
                            
                            $childGap = $gap > 0 ? $gap / 2 : 0;
                            $childViewName = in_array($child['type'] ?? '', ['container', 'header', 'footer', 'section']) ? 'contenitori' : ($child['type'] ?? '');
                        @endphp
                        {{-- Aggiunta la classe email-col per trasformarsi in blocco unico su mobile --}}
                        <td class="email-col" style="vertical-align: top; width: {{ $childWidth }}%; max-width: {{ $childWidth }}%; @if($childGap > 0) padding-left: {{ $childGap }}px; padding-right: {{ $childGap }}px; @endif box-sizing: border-box;">
                            @include('email.blocks.' . $childViewName, ['block' => $child])
                        </td>
                    @endforeach
                </tr>
            @endif
        </table>
    @endif
</{!! $htmlTag !!}>