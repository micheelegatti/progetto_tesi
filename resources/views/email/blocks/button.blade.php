@php
    $style = $block['style'] ?? [];
    $props = $block['props'] ?? [];

    // Stili per il DIV CONTENITORE (gestisce margin, larghezza e allineamento)
    $wrapperStyles = [];
    $wrapperStyles[] = "width: " . ($style['width'] ?? 100) . "%";
    $wrapperStyles[] = "max-width: 100%";
    $wrapperStyles[] = "box-sizing: border-box";

    if (isset($style['margin']['top'])) $wrapperStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $wrapperStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $wrapperStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $wrapperStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    $wrapperStyle = implode('; ', $wrapperStyles);
    $align = $style['textAlign'] ?? 'center'; // I bottoni solitamente sono centrati di default

    // Stili per il TAG <a> (il bottone vero e proprio)
    $aStyles = [];
    $aStyles[] = "display: inline-block";
    $aStyles[] = "text-decoration: " . (!empty($style['textDecoration']) ? $style['textDecoration'] : 'none');
    
    if (!empty($style['backgroundColor'])) $aStyles[] = "background-color: {$style['backgroundColor']}";
    if (!empty($style['color'])) $aStyles[] = "color: {$style['color']}";
    if (isset($style['fontSize'])) $aStyles[] = "font-size: {$style['fontSize']}px";
    if (!empty($style['fontWeight'])) $aStyles[] = "font-weight: {$style['fontWeight']}";
    if (!empty($style['fontFamily'])) $aStyles[] = "font-family: {$style['fontFamily']}, sans-serif";
    if (isset($style['height'])) $aStyles[] = "height: {$style['height']}px";

    // Padding interni del bottone
    if (isset($style['padding']['top'])) $aStyles[] = "padding-top: " . ($style['padding']['top'] * 16) . "px";
    if (isset($style['padding']['bottom'])) $aStyles[] = "padding-bottom: " . ($style['padding']['bottom'] * 16) . "px";
    if (isset($style['padding']['right'])) $aStyles[] = "padding-right: " . ($style['padding']['right'] * 16) . "px";
    if (isset($style['padding']['left'])) $aStyles[] = "padding-left: " . ($style['padding']['left'] * 16) . "px";

    // Bordi del bottone
    if (isset($style['border']['radius'])) $aStyles[] = "border-radius: {$style['border']['radius']}px";
    if (isset($style['border']['width']) && $style['border']['width'] > 0) {
        $aStyles[] = "border-width: {$style['border']['width']}px";
        if (!empty($style['border']['style'])) $aStyles[] = "border-style: {$style['border']['style']}";
        if (!empty($style['border']['color'])) $aStyles[] = "border-color: {$style['border']['color']}";
    }

    // Box Shadow (supportata dai client moderni, ignorata in sicurezza da Outlook)
    if (!empty($style['boxShadow'])) {
        $offsetX = $style['boxShadow']['offsetX'] ?? 0;
        $offsetY = $style['boxShadow']['offsetY'] ?? 0;
        $blur = $style['boxShadow']['blurRadius'] ?? 0;
        $spread = $style['boxShadow']['spreadRadius'] ?? 0;
        $shadowColor = $style['boxShadow']['color'] ?? 'rgba(0,0,0,0)';
        $aStyles[] = "box-shadow: {$offsetX}px {$offsetY}px {$blur}px {$spread}px {$shadowColor}";
    }

    $linkStyle = implode('; ', $aStyles);
@endphp

<div style="{{ $wrapperStyle }}; text-align: {{ $align }};">
    <a href="{{ $props['href'] ?? '#' }}" target="_blank" rel="noopener noreferrer" style="{{ $linkStyle }}">
        {{ $props['text'] ?? 'Clicca qui' }}
    </a>
</div>