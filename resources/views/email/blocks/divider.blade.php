@php
    $style = $block['style'] ?? [];
    $props = $block['props'] ?? [];

    $btWidth = $style['borderTopWidth'] ?? 1;
    $btStyle = $style['borderTopStyle'] ?? 'solid';
    $btColor = $style['borderTopColor'] ?? '#808080';
    $divText = $props['text'] ?? '';

    $cssStyles = [];
    if (isset($style['margin']['top'])) $cssStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $cssStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $cssStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $cssStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    $inlineStyle = implode('; ', $cssStyles);
@endphp
<div style="{{ $inlineStyle }}; border-top: {{ $btWidth }}px {{ $btStyle }} {{ $btColor }}; text-align: {{ $style['textAlign'] ?? 'center' }};">
    @if(!empty($divText))
        <span style="background: #ffffff; padding: 0 10px; position: relative; top: -10px; font-size: 14px; color: #555;">
            {{ $divText }}
        </span>
    @endif
</div>