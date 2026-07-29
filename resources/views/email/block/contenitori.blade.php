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
    if (isset($style['minHeight'])) $cssStyles[] = "min-height: {$style['minHeight']}px";
    
    // Margini
    if (isset($style['margin']['top'])) $cssStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $cssStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $cssStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $cssStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    // Padding
    if (isset($style['padding']['top'])) $cssStyles[] = "padding-top: " . ($style['padding']['top'] * 16) . "px";
    if (isset($style['padding']['bottom'])) $cssStyles[] = "padding-bottom: " . ($style['padding']['bottom'] * 16) . "px";
    if (isset($style['padding']['right'])) $cssStyles[] = "padding-right: " . ($style['padding']['right'] * 16) . "px";
    if (isset($style['padding']['left'])) $cssStyles[] = "padding-left: " . ($style['padding']['left'] * 16) . "px";

    // Bordi
    if (isset($style['border']['width']) && $style['border']['width'] > 0) {
        $cssStyles[] = "border-width: {$style['border']['width']}px";
        if (!empty($style['border']['style'])) $cssStyles[] = "border-style: {$style['border']['style']}";
        if (!empty($style['border']['color'])) $cssStyles[] = "border-color: {$style['border']['color']}";
        if (isset($style['border']['radius'])) $cssStyles[] = "border-radius: {$style['border']['radius']}px";
    }

    $inlineStyle = implode('; ', $cssStyles);
    
    $flexDir = $layout['flexDirection'] ?? 'column';
    $gap = $layout['gap'] ?? 0;

    $rawAlignItems = $layout['alignItems'] ?? 'flex-start';
    $rawJustify = $layout['justifyContent'] ?? 'flex-start';

    // Mappatura pulita per le tabelle HTML (align = orizzontale, valign = verticale)
    if ($flexDir === 'column') {
        // IN COLONNA: Justify muove sull'asse verticale (top/middle/bottom), Align muove sull'asse orizzontale (left/center/right)
        $tdValign = match($rawJustify) {
            'center' => 'middle',
            'flex-end' => 'bottom',
            default => 'top',
        };
        $tdAlign = match($rawAlignItems) {
            'center' => 'center',
            'flex-end' => 'right',
            default => 'left',
        };
        $rowAlign = 'left';
    } else {
        // IN RIGA: Align muove sull'asse verticale (top/middle/bottom), Justify muove sull'asse orizzontale (left/center/right)
        $tdValign = match($rawAlignItems) {
            'center' => 'middle',
            'flex-end' => 'bottom',
            default => 'top',
        };
        $tdAlign = match($rawJustify) {
            'center' => 'center',
            'flex-end' => 'right',
            default => 'left',
        };
        $rowAlign = $tdAlign;
    }
@endphp

<{!! $htmlTag !!} @if(!empty($inlineStyle)) style="{{ $inlineStyle }}; box-sizing: border-box;" @else style="box-sizing: border-box;" @endif>
    @if(!empty($block['children']))
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100%; border-collapse: collapse;">
            @if($flexDir === 'column')
                {{-- MODALITÀ COLONNA --}}
                @foreach($block['children'] as $child)
                    @php
                        $childViewName = in_array($child['type'] ?? '', ['container', 'header', 'footer', 'section']) ? 'contenitori' : ($child['type'] ?? '');
                        $childGap = $gap > 0 ? $gap / 2 : 0;
                    @endphp
                    <tr>
                        <td align="{{ $tdAlign }}" valign="{{ $tdValign }}" style="width: 100%; box-sizing: border-box; @if($childGap > 0) padding-bottom: {{ $childGap }}px; padding-top: {{ $childGap }}px; @endif">
                            @include('email.block.' . $childViewName, ['block' => $child])
                        </td>
                    </tr>
                @endforeach
            @else
                {{-- MODALITÀ RIGA --}}
                <tr align="{{ $rowAlign }}">
                    @foreach($block['children'] as $child)
                        @php
                            $totalChildren = count($block['children']);
                            $defaultWidth = round(100 / max($totalChildren, 1));
                            $childWidth = $child['style']['width'] ?? $defaultWidth;
                            
                            if ($totalChildren > 1 && $childWidth == 100) {
                                $childWidth = $defaultWidth;
                            }
                            
                            $childGap = $gap > 0 ? $gap / 2 : 0;
                            $childViewName = in_array($child['type'] ?? '', ['container', 'header', 'footer', 'section']) ? 'contenitori' : ($child['type'] ?? '');
                            
                            // --- LA SOLUZIONE ---
                            // Creiamo una copia temporanea del blocco per l'email e forziamo la sua larghezza interna al 100%.
                            // In questo modo la cella (<td>) gestisce lo spazio della colonna (es. 40%),
                            // mentre il contenuto dentro si espande comodamente al 100% di quello spazio senza schiacciarsi.
                            $renderBlock = $child;
                            $renderBlock['style']['width'] = 100;
                        @endphp
                        <td width="{{ $childWidth }}%" valign="{{ $tdValign }}" class="email-column" style="width: {{ $childWidth }}%; max-width: {{ $childWidth }}%; @if($childGap > 0) padding-left: {{ $childGap }}px; padding-right: {{ $childGap }}px; @endif box-sizing: border-box;">
                            @include('email.block.' . $childViewName, ['block' => $renderBlock])
                        </td>
                    @endforeach
                </tr>
            @endif
        </table>
    @endif
</{!! $htmlTag !!}>