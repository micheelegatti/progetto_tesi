@php
    $style = $block['style'] ?? [];
    $props = $block['props'] ?? [];

    $cssStyles = [];
    
    // Gestione larghezza e altezza del blocco
    $cssStyles[] = "width: " . ($style['width'] ?? 100) . "%";
    $cssStyles[] = "max-width: 100%";
    if (isset($style['height'])) $cssStyles[] = "height: {$style['height']}px";
    if (!empty($style['backgroundColor'])) $cssStyles[] = "background-color: {$style['backgroundColor']}";

    // Spaziature (Margini convertiti in pixel sicuri)
    if (isset($style['margin']['top'])) $cssStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $cssStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $cssStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $cssStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    // Spaziature (Padding)
    if (isset($style['padding']['top'])) $cssStyles[] = "padding-top: " . ($style['padding']['top'] * 16) . "px";
    if (isset($style['padding']['bottom'])) $cssStyles[] = "padding-bottom: " . ($style['padding']['bottom'] * 16) . "px";
    if (isset($style['padding']['right'])) $cssStyles[] = "padding-right: " . ($style['padding']['right'] * 16) . "px";
    if (isset($style['padding']['left'])) $cssStyles[] = "padding-left: " . ($style['padding']['left'] * 16) . "px";

    // Proprietà del bordo superiore (la linea vera e propria)
    if (isset($style['borderTopWidth'])) $cssStyles[] = "border-top-width: {$style['borderTopWidth']}px";
    if (!empty($style['borderTopStyle'])) $cssStyles[] = "border-top-style: {$style['borderTopStyle']}";
    if (!empty($style['borderTopColor'])) $cssStyles[] = "border-top-color: {$style['borderTopColor']}";

    $inlineStyle = implode('; ', $cssStyles);
    $divText = $props['text'] ?? '';
    $align = $style['textAlign'] ?? 'center';
@endphp

<div style="width: 100%; box-sizing: border-box; @if(!empty($style['margin']['top'])) margin-top: {{ $style['margin']['top'] * 16 }}px; @endif @if(!empty($style['margin']['bottom'])) margin-bottom: {{ $style['margin']['bottom'] * 16 }}px; @endif">
    <div @if(!empty($inlineStyle) || !empty($align)) style="{{ $inlineStyle }}; text-align: {{ $align }}; box-sizing: border-box;" @endif>
        @if(!empty($divText))
            <span style="position: relative; top: -10px; background-color: #ffffff; padding: 0 10px; @if(isset($style['fontSize'])) font-size: {{ $style['fontSize'] }}px; @endif @if(!empty($style['fontFamily'])) font-family: {{ $style['fontFamily'] }}, sans-serif; @endif @if(!empty($style['color'])) color: {{ $style['color'] }}; @endif">
                {{ $divText }}
            </span>
        @endif
    </div>
</div>