export interface Block {
    id: number
    type: 'title' | 'text' | 'image' | 'button' | 'divider' | 'container' | 'grid'
    //Oggetto che contiene informazioni specifiche per ogni tipo di blocco (es. testo, immagine, ecc.)
    props?:{
        text?: string
        src?: string
        alt?: string
        href?: string
        cols?: number
        rows?: number
    }
    style?:{
        padding?: { top?: number
                    right?: number 
                    bottom?: number
                    left?: number 
        }
        margin?: {  top?: number
                    right?: number 
                    bottom?: number
                    left?: number 
        }
        width?: number
        height?: number
        maxWidth?: number
        minHeight?: number
        textAlign?: 'left' | 'center' | 'right' | 'justify'
        backgroundColor?: string
        backgroundImage?: string
        fontFamily?: string
        fontStyle?: 'normal' | 'italic'
        fontSize?: number
        textDecoration?: 'none' | 'underline' | 'line-through'
        letterSpacing?: number
        wordSpacing?: number
        color?: string
        fontWeight?: number | string
        lineHeight?: number,
        wordBreak?: 'normal' | 'break-all'
        border?: {
            width?: number
            color?: string
            style?: 'solid' | 'dashed' | 'none' | 'double' | 'dotted' | 'groove'
            radius?: number
        }
        borderTopColor?: string 
        borderTopStyle?: 'solid' | 'dashed' | 'dotted' | 'double' | 'groove' | 'ridge' | 'inset' | 'outset'
        borderTopWidth?: number
        //px
        boxShadow?: {
            offsetX?: number,
            offsetY?: number,
            blurRadius?: number,
            spreadRadius?: number,
            color?: string
        }
        objectFit?: 'fill' | 'cover' | 'contain' | 'scale-down' | 'none'
        objectPosition?: 'left top' | 'center top' | 'right top' | 'left center' | 'center center' | 'tight center' | 'left bottom' | 'center bottom' | 'right bottom'
        opacity?: number
        overflow?: 'hidden' | 'auto' | 'visible'

    } 
    layout?: {
        display?: 'flex' | 'grid' | 'block' | 'none'
        flexDirection?: 'row' | 'column'
        justifyContent?: 'flex-start'  | 'center'  | 'flex-end'  | 'space-between'  | 'space-around'  | 'space-evenly'
        alignItems?: 'flex-start' | 'center' | 'flex-end' | 'stretch'
        alignContent?:'flex-start' | 'center' | 'flex-end' | 'space-between' | 'space-around' | 'stretch'
        gap?: number
        flexWrap?: 'nowrap' | 'wrap'
    }
    children?: Block[] //per blocchi di tipo container
    grid?: (Block | null)[][]   // per blocchi di tipo grid: matrice righe × colonne
}