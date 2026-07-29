//import { Columns, ScissorsLineDashed } from 'lucide-vue-next';
import type { Block } from './block'
//import { AlertDialogAction } from 'reka-ui';


export const blockDefaults: Record<Block['type'], Block> = {
    //sistemato
    title: {
        id: 0,
        type: 'title',
        props: {
            text: 'Il tuo titolo',
        },
        style: {
            fontSize: 22,
            color: '#000000',
            fontWeight: 600,        
            lineHeight: 1.25,       //no unità di misura
            wordBreak: 'break-all',
            
            textAlign: 'center',
            fontFamily: 'Arial',
            margin: {top: 0, right: 0, bottom: 0, left:0},
            padding:  {top: 1, bottom: 1, right: 1, left:1},
        },
        layout: {
            alignItems: 'flex-start',
        }
    },
    //sistemato
    text: {
        id: 0,
        type: 'text',
        props: {
            text: 'Scrivi qui il testo...',
        },
        style: {
            fontSize: 14,
            color: '#444444',
            lineHeight: 1.5,
            wordBreak: 'break-all',
            textAlign: 'left',
            fontFamily: 'Arial',
            margin: {top: 0, bottom: 0, right: 0, left:0},
            padding: {top: 1, bottom: 1, right: 1, left:1},
        },
    },

    //sistemato
    image: {
        id: 0,
        type: 'image',
        props: {
            src: '',
            alt: 'Immagine',
        },
        style: {
            width: 100,
            maxWidth: 100,
            margin: {top: 0, bottom: 0, right: 0, left:0},
            padding: { top: 0, bottom: 0, right: 0, left: 0},
            objectFit: 'fill',
            opacity: 1,
            border: {
                width: 0,
                color: '#000',
                style: 'solid',
                radius: 8,
            },
            boxShadow: {
                offsetX: 0,
                offsetY: 0,
                blurRadius: 0,
                spreadRadius: 0,
                color: 'rgba(0, 0, 0)',
            },
        },
        layout: {display: 'block'}
    },
    //sistemato
    button: {
        id: 0,
        type: 'button',
        props: {
            text: 'Clicca qui',
            href: '#',
        },
        style: {
            padding: {
                top: 0.5,
                bottom: 0.5,
                right: 1.25,
                left: 1.25,
            },
            margin: {top: 0, right: 0, bottom: 0, left:0},
            //px
            border: {
                width: 1,
                color: '#000',
                style: 'solid',
                radius: 8,
            },
            boxShadow: {
                offsetX: 0,
                offsetY: 0,
                blurRadius: 0,
                spreadRadius: 0,
                color: 'rgba(0, 0, 0)',
            },
            /* rem */
            fontSize: 18, 
            fontWeight: 500,
            fontFamily: 'Arial',
            backgroundColor: '#378ADD',
            color: '#ffffff',
        },
    },

    divider: {
        id: 0,
        type: 'divider',
        props: {
            text: '',
        },
        style: {
            height: 1,  //px
            width: 100, //%
            backgroundColor: '#e0e0e0',
            borderTopStyle: 'solid', 
            borderTopWidth: 1,
            borderTopColor: '#808080',
            padding: {
                top: 0,
                bottom: 0,
                right: 0,
                left: 0,
            },
            margin: {
                top: 0.25,
                bottom: 0.25,
                right: 0,
                left: 0
            },
        },
    },

    html: {
        id:0,
        type: 'html',
        props:{
            text: '<p> Metti qua il tuo codice html </p>'
        },
        style: {
            padding: { top: 1, bottom: 1, right: 1, left: 1 },
            margin: { top: 0, bottom: 0, right: 0, left: 0 },
        }
    },

    //Blocchi contenitori
    container: {
        id: 0,
        type: 'container',
        style: {
            backgroundColor: '#FFFF',
            border: {
                width: 0,     // px
                style: 'dashed',
                color: '#d1d5db', 
                radius: 8,    // px
            },
            padding: {top: 0, bottom: 0, right: 0, left:0},     // rem
            margin: { top: 0, bottom: 0, right: 0, left: 0},  //rem
            minHeight: 10,   // %
            width: 100,
        },
        layout: {
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',     
            justifyContent: 'center',
            gap: 10,    //px
            flexWrap: 'nowrap'
        },
        children: [],
    },

    header: {
        id: 0,
        type: 'header',
        style: {
            backgroundColor: '#FFFF',
            border: {
                width: 0,     // px
                style: 'dashed',
                color: '#d1d5db', 
                radius: 8,    // px
            },
            padding: {top: 0, bottom: 0, right: 0, left:0},     // rem
            margin: { top: 0, bottom: 0, right: 0, left: 0},  //rem
            minHeight: 10,   // %
            width: 100,
        },
        layout: {
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',     
            justifyContent: 'center',
            gap: 10,    //px
            flexWrap: 'nowrap'
        },
        children: [],
    },

    footer: {
        id: 0,
        type: 'footer',
        style: {
            backgroundColor: '#FFFF',
            border: {
                width: 0,     // px
                style: 'dashed',
                color: '#d1d5db', 
                radius: 8,    // px
            },
            padding: {top: 0, bottom: 0, right: 0, left:0},     // rem
            margin: { top: 0, bottom: 0, right: 0, left: 0},  //rem
            minHeight: 10,   // %
            width: 100,
        },
        layout: {
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',     
            justifyContent: 'center',
            gap: 10,    //px
            flexWrap: 'nowrap'
        },
        children: [],
    },

    section: {
        id: 0,
        type: 'section',
        style: {
            backgroundColor: '#FFFF',
            border: {
                width: 0,     // px
                style: 'dashed',
                color: '#d1d5db', 
                radius: 8,    // px
            },
            padding: {top: 0, bottom: 0, right: 0, left:0},     // rem
            margin: { top: 0, bottom: 0, right: 0, left: 0},  //rem
            minHeight: 10,   // %
            width: 100,
        },
        layout: {
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',     
            justifyContent: 'center',
            gap: 10,    //px
            flexWrap: 'nowrap'
        },
        children: [],
    },
}