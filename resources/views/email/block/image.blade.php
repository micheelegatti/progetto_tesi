@php
    $style = $block['style'] ?? [];
    $props = $block['props'] ?? [];

    // 1. Stili per il DIV ESTERNO (Wrapper, margini, padding, bordi, ombra e display)
    $wrapperStyles = [];
    $wrapperStyles[] = "width: 100%"; // Il wrapper occupa tutta la colonna
    $wrapperStyles[] = "box-sizing: border-box";

    if (isset($style['opacity'])) $wrapperStyles[] = "opacity: {$style['opacity']}";
    if (!empty($style['layout']['display'])) $wrapperStyles[] = "display: {$style['layout']['display']}";

    // Spaziature (Margini convertiti in pixel sicuri)
    if (isset($style['margin']['top'])) $wrapperStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $wrapperStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $wrapperStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $wrapperStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    // Spaziature (Padding)
    if (isset($style['padding']['top'])) $wrapperStyles[] = "padding-top: " . ($style['padding']['top'] * 16) . "px";
    if (isset($style['padding']['bottom'])) $wrapperStyles[] = "padding-bottom: " . ($style['padding']['bottom'] * 16) . "px";
    if (isset($style['padding']['right'])) $wrapperStyles[] = "padding-right: " . ($style['padding']['right'] * 16) . "px";
    if (isset($style['padding']['left'])) $wrapperStyles[] = "padding-left: " . ($style['padding']['left'] * 16) . "px";

    // Bordi del wrapper
    if (isset($style['border']['width']) && $style['border']['width'] > 0) {
        $wrapperStyles[] = "border-width: {$style['border']['width']}px";
        if (!empty($style['border']['style'])) $wrapperStyles[] = "border-style: {$style['border']['style']}";
        if (!empty($style['border']['color'])) $wrapperStyles[] = "border-color: {$style['border']['color']}";
        if (isset($style['border']['radius'])) $wrapperStyles[] = "border-radius: {$style['border']['radius']}px";
    }

    // Box Shadow sul wrapper
    if (!empty($style['boxShadow'])) {
        $offsetX = $style['boxShadow']['offsetX'] ?? 0;
        $offsetY = $style['boxShadow']['offsetY'] ?? 0;
        $blur = $style['boxShadow']['blurRadius'] ?? 0;
        $spread = $style['boxShadow']['spreadRadius'] ?? 0;
        $shadowColor = $style['boxShadow']['color'] ?? 'rgba(0,0,0,0)';
        $wrapperStyles[] = "box-shadow: {$offsetX}px {$offsetY}px {$blur}px {$spread}px {$shadowColor}";
    }

    $inlineWrapperStyle = implode('; ', $wrapperStyles);
    $align = $style['textAlign'] ?? 'center';

    // Risoluzione dell'URL dell'immagine
    $rawSrc = $props['src'] ?? '';
    $imageSrc = '';
    if (!empty($rawSrc)) {
        $imageSrc = filter_var($rawSrc, FILTER_VALIDATE_URL) ? $rawSrc : asset(ltrim($rawSrc, '/'));
    }

    // 2. Stili specifici per il TAG <IMG> interno (Larghezza, Altezza, Max-Height, Object-fit e Position)
    $imgStyles = [];
    $imgStyles[] = "display: inline-block";
    $imgStyles[] = "max-width: 100%"; // Sicurezza mobile per evitare sbordamenti

    // Gestione larghezza
    if (isset($style['width'])) {
        $imgStyles[] = "width: {$style['width']}%";
    } else {
        $imgStyles[] = "width: 100%";
    }

    // Gestione altezza
    if (isset($style['height']) && $style['height'] > 0) {
        $imgStyles[] = "height: {$style['height']}%";
    } else {
        $imgStyles[] = "height: auto";
    }

    // --- AGGIUNTA MAX-HEIGHT ---
    if (isset($style['maxHeight']) && $style['maxHeight'] > 0) {
        $imgStyles[] = "max-height: {$style['maxHeight']}px";
    }

    if (!empty($style['objectFit'])) {
        $imgStyles[] = "object-fit: {$style['objectFit']}";
    }

    if (!empty($style['objectPosition'])) {
        $imgStyles[] = "object-position: {$style['objectPosition']}";
    }

    $inlineImgStyle = implode('; ', $imgStyles);
@endphp

<div style="{{ $inlineWrapperStyle }}; text-align: {{ $align }}; box-sizing: border-box;">
    @if(!empty($imageSrc))
        <img src="{{ $imageSrc }}" alt="{{ $props['alt'] ?? 'Immagine' }}" style="{{ $inlineImgStyle }}">
    @else
        <div style="background-color: #f3f4f6; border-radius: 8px; height: 160px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 14px;">
            Nessuna immagine
        </div>
    @endif
</div>