@php
    $style = $block['style'] ?? [];
    $props = $block['props'] ?? [];

    $cssStyles = [];
    if (isset($style['margin']['top'])) $cssStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $cssStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $cssStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $cssStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    $inlineStyle = implode('; ', $cssStyles);
@endphp
<div style="{{ $inlineStyle }}; text-align: {{ $style['textAlign'] ?? 'center' }};">
    <a href="{{ $props['href'] ?? '#' }}" target="_blank" style="background-color: {{ $style['backgroundColor'] ?? '#378ADD' }}; color: {{ $style['color'] ?? '#ffffff' }}; font-size: {{ $style['fontSize'] ?? 18 }}px; font-weight: {{ $style['fontWeight'] ?? 500 }}; font-family: {{ $style['fontFamily'] ?? 'Arial' }}; padding-top: {{ ($style['padding']['top'] ?? 0.5) * 16 }}px; padding-bottom: {{ ($style['padding']['bottom'] ?? 0.5) * 16 }}px; padding-right: {{ ($style['padding']['right'] ?? 1.25) * 16 }}px; padding-left: {{ ($style['padding']['left'] ?? 1.25) * 16 }}px; text-decoration: {{ $style['textDecoration'] ?? 'none' }}; border-radius: {{ $style['border']['radius'] ?? 8 }}px; border: {{ $style['border']['width'] ?? 1 }}px {{ $style['border']['style'] ?? 'solid' }} {{ $style['border']['color'] ?? '#000' }}; display: inline-block;">
        {{ $props['text'] ?? 'Clicca qui' }}
    </a>
</div>