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
<div style="{{ $inlineStyle }}">
    {!! $props['text'] ?? '' !!}
</div>