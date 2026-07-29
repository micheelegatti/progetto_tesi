@php
    $style = $block['style'] ?? [];
    $props = $block['props'] ?? [];

    $cssStyles = [];
    
    // Gestione larghezza e box model di sicurezza
    $cssStyles[] = "width: " . ($style['width'] ?? 100) . "%";
    $cssStyles[] = "max-width: 100%";
    $cssStyles[] = "box-sizing: border-box";

    // Proprietà Tipografiche
    if (!empty($style['fontFamily'])) $cssStyles[] = "font-family: {$style['fontFamily']}, sans-serif";
    if (isset($style['fontSize'])) $cssStyles[] = "font-size: {$style['fontSize']}px";
    if (!empty($style['fontWeight'])) $cssStyles[] = "font-weight: {$style['fontWeight']}";
    if (!empty($style['fontStyle'])) $cssStyles[] = "font-style: {$style['fontStyle']}";
    if (!empty($style['textDecoration'])) $cssStyles[] = "text-decoration: {$style['textDecoration']}";
    if (!empty($style['color'])) $cssStyles[] = "color: {$style['color']}";
    if (isset($style['lineHeight'])) $cssStyles[] = "line-height: {$style['lineHeight']}";
    if (isset($style['letterSpacing'])) $cssStyles[] = "letter-spacing: {$style['letterSpacing']}px";
    if (!empty($style['textAlign'])) $cssStyles[] = "text-align: {$style['textAlign']}";
    if (!empty($style['wordBreak'])) $cssStyles[] = "word-break: {$style['wordBreak']}";

    // Spaziature (Margini convertiti in pixel sicuri)
    if (isset($style['margin']['top'])) $cssStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $cssStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $cssStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $cssStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    // Spaziature (Padding convertiti in pixel sicuri)
    if (isset($style['padding']['top'])) $cssStyles[] = "padding-top: " . ($style['padding']['top'] * 16) . "px";
    if (isset($style['padding']['bottom'])) $cssStyles[] = "padding-bottom: " . ($style['padding']['bottom'] * 16) . "px";
    if (isset($style['padding']['right'])) $cssStyles[] = "padding-right: " . ($style['padding']['right'] * 16) . "px";
    if (isset($style['padding']['left'])) $cssStyles[] = "padding-left: " . ($style['padding']['left'] * 16) . "px";

    $inlineStyle = implode('; ', $cssStyles);
@endphp

{{-- Aggiunta la classe email-title per la gestione responsive mobile --}}
<div class="email-title" @if(!empty($inlineStyle)) style="{{ $inlineStyle }}" @endif>
    <h1 style="margin: 0; padding: 0; font-family: inherit; font-size: inherit; font-weight: inherit; color: inherit; line-height: inherit;">
        {!! $props['text'] ?? '' !!}
    </h1>
</div>