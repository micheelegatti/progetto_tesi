@php
    $style = $block['style'] ?? [];
    $layout = $block['layout'] ?? [];
    $type = $block['type'] ?? 'container';
    
    // Tag semantico dinamico
    $htmlTag = match($type) {
        'header' => 'header',
        'footer' => 'footer',
        'section' => 'section',
        default => 'div'
    };

    // Stili del contenitore principale
    $cssStyles = [];
    if (!empty($style['backgroundColor'])) $cssStyles[] = "background-color: {$style['backgroundColor']}";
    if (isset($style['width'])) $cssStyles[] = "width: {$style['width']}%";
    
    if (isset($style['margin']['top'])) $cssStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $cssStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $cssStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $cssStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    if (isset($style['padding']['top'])) $cssStyles[] = "padding-top: " . ($style['padding']['top'] * 16) . "px";
    if (isset($style['padding']['bottom'])) $cssStyles[] = "padding-bottom: " . ($style['padding']['bottom'] * 16) . "px";
    if (isset($style['padding']['right'])) $cssStyles[] = "padding-right: " . ($style['padding']['right'] * 16) . "px";
    if (isset($style['padding']['left'])) $cssStyles[] = "padding-left: " . ($style['padding']['left'] * 16) . "px";

    if (isset($style['border']['width']) && $style['border']['width'] > 0) {
        $cssStyles[] = "border-width: {$style['border']['width']}px";
        $cssStyles[] = "border-style: " . ($style['border']['style'] ?? 'solid');
        $cssStyles[] = "border-color: " . ($style['border']['color'] ?? '#d1d5db');
        if (isset($style['border']['radius'])) $cssStyles[] = "border-radius: {$style['border']['radius']}px";
    }

    $inlineStyle = implode('; ', $cssStyles);
    
    // Direzione del layout (row o column)
    $flexDir = $layout['flexDirection'] ?? 'row';
@endphp

<{!! $htmlTag !!} style="{{ $inlineStyle }}; box-sizing: border-box;">
    @if(!empty($block['children']))
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
            
            @if($flexDir === 'column')
                {{-- SEZIONE A COLONNA (Elementi uno sotto l'altro) --}}
                @foreach($block['children'] as $child)
                    @php
                        $childViewName = in_array($child['type'] ?? '', ['container', 'header', 'footer', 'section']) 
                                         ? 'contenitori' 
                                         : ($child['type'] ?? '');
                    @endphp
                    <tr>
                        <td style="width: 100%; vertical-align: top; box-sizing: border-box; padding-bottom: {{ ($layout['gap'] ?? 10) / 2 }}px;">
                            @include('email.blocks.' . $childViewName, ['block' => $child])
                        </td>
                    </tr>
                @endforeach
            
            @else
                {{-- SEZIONE A RIGA (Elementi affiancati in orizzontale) --}}
                <tr>
                    @foreach($block['children'] as $child)
                        @php
                            $childWidth = $child['style']['width'] ?? 100;
                            $gap = $layout['gap'] ?? 10;
                            $childViewName = in_array($child['type'] ?? '', ['container', 'header', 'footer', 'section']) 
                                             ? 'contenitori' 
                                             : ($child['type'] ?? '');
                        @endphp
                        <td style="vertical-align: top; width: {{ $childWidth }}%; padding: {{ $gap / 2 }}px; box-sizing: border-box;">
                            @include('email.blocks.' . $childViewName, ['block' => $child])
                        </td>
                    @endforeach
                </tr>
            @endif

        </table>
    @endif
</{!! $htmlTag !!}>