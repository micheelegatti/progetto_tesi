@php
    $style = $block['style'] ?? [];
    $props = $block['props'] ?? [];

    $cssStyles = [];
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
        $cssStyles[] = "border-color: " . ($style['border']['color'] ?? '#000');
        if (isset($style['border']['radius'])) $cssStyles[] = "border-radius: {$style['border']['radius']}px";
    }

    $inlineStyle = implode('; ', $cssStyles);
@endphp
<div style="{{ $inlineStyle }}; text-align: {{ $style['textAlign'] ?? 'center' }};">
    @if(!empty($props['src']))
        <img src="{{ $props['src'] }}" alt="{{ $props['alt'] ?? 'Immagine' }}" style="max-width: 100%; height: {{ isset($style['height']) ? $style['height'].'px' : 'auto' }}; object-fit: {{ $style['objectFit'] ?? 'fill' }}; display: inline-block;">
    @else
        <div style="background-color: #f3f4f6; border-radius: 8px; height: 160px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 14px;">
            Nessuna immagine
        </div>
    @endif
</div>