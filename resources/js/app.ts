// resources/js/app.ts
import { createApp } from 'vue';
import { initializeTheme } from '@/composables/useAppearance';
import { initializeFlashToast } from '@/lib/flashToast';

//Configurazioni PrimeVue
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import ToastService from 'primevue/toastservice';

// Import componenti Vue
import EditorTemplate from './components/editor/EditorTemplate.vue';
import CanvasEditorTemplate from './components/editor/CanvasEditorTemplate.vue';
import EditorCampagna from './components/editor/EditorCampagna.vue';
import CanvasEditorCampagna from './components/editor/CanvasEditorCampagna.vue';
import SettingsPanelEditor from './components/editor/SettingsPanelEditor.vue';
import SidebarEditor from './components/editor/SidebarEditor.vue';

import ButtonBlock from './components/editor/blocks/ButtonBlock.vue';
import ButtonBlockSettings from './components/editor/blocks/ButtonBlockSettings.vue';
import ContainerBlock from './components/editor/blocks/ContainerBlock.vue';
import ContainerBlockSettings from './components/editor/blocks/ContainerBlockSettings.vue';
import DividerBlock from './components/editor/blocks/DividerBlock.vue';
import DividerBlockSettings from './components/editor/blocks/DividerBlockSettings.vue';
import ImageBlock from './components/editor/blocks/ImageBlock.vue';
import ImageBlockSettings from './components/editor/blocks/ImageBlockSettings.vue';
import TextBlock from './components/editor/blocks/TextBlock.vue';
import TextBlockSettings from './components/editor/blocks/TextBlockSettings.vue';
import TitleBlock from './components/editor/blocks/TitleBlock.vue';
import TitleBlockSettings from './components/editor/blocks/TitleBlockSettings.vue';
import HeaderBlock from './components/editor/blocks/HeaderBlock.vue';
import HeaderBlockSettings from './components/editor/blocks/HeaderBlockSettings.vue';
import FooterBlock from './components/editor/blocks/FooterBlock.vue';
import FooterBlockSettings from './components/editor/blocks/FooterBlockSettings.vue';
import SectionBlock from './components/editor/blocks/SectionBlock.vue';
import SectionBlockSettings from './components/editor/blocks/SectionBlockSettings.vue';
import HTMLBlock from './components/editor/blocks/HTMLBlock.vue';
import HTMLBlockSettings from './components/editor/blocks/HTMLBlockSettings.vue';
import SelezioneContatti from './components/other/SelezioneContatti.vue';



/* Se vuoi usare i componenti PrimeVue direttamente dentro i file Blade:
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
*/

// Inizializzazioni grafiche globali dello Starter Kit (Dark Mode)
if (typeof window !== 'undefined') {
    initializeTheme();
    initializeFlashToast();
}

//Creazione, dichiarazione e mount componenti
if (typeof document !== 'undefined') {
    const rootEl = document.querySelector('#app-root');

    if (rootEl) {
        // Creiamo l'istanza vuota (il guscio globale per Blade)
        const app = createApp({});

        // Attiviamo PrimeVue e i suoi servizi
        app.use(PrimeVue, {
            theme: {
                preset: Aura,
                options: {
                    darkModeSelector: '.dark', // Sincronizzato con la classe dark del tuo Blade
                }
            }
        });
        app.use(ToastService);

        // dichiarazionee delle componenti
        app.component('editor-template', EditorTemplate);
        app.component('canvasEditor', CanvasEditorTemplate);
        app.component('editor-campagna', EditorCampagna);
        app.component('canvasEditor', CanvasEditorCampagna);
        app.component('settingsPanelEditor', SettingsPanelEditor);
        app.component('sidebarEditor', SidebarEditor);

        app.component('buttonBlock', ButtonBlock);
        app.component('buttonBlockSettings', ButtonBlockSettings);
        app.component('containerBlock', ContainerBlock);
        app.component('containerBlockSettings', ContainerBlockSettings);
        app.component('dividerBlock', DividerBlock);
        app.component('dividerBlockSettings', DividerBlockSettings);
        app.component('imageBlock', ImageBlock);
        app.component('imageBlockSettings', ImageBlockSettings);
        app.component('textBlock', TextBlock);
        app.component('textBlockSettings', TextBlockSettings);
        app.component('titleBlock', TitleBlock);
        app.component('titleBlockSettings', TitleBlockSettings);
        app.component('headerBlock', HeaderBlock);
        app.component('headerBlockSettings', HeaderBlockSettings);
        app.component('footerBlock', FooterBlock);
        app.component('footerBlockSettings', FooterBlockSettings);
        app.component('sectionBlock', SectionBlock);
        app.component('sectionBlockSettings', SectionBlockSettings);
        app.component('htmlBlock', HTMLBlock);
        app.component('htmlBlockSettings', HTMLBlockSettings);
        
        app.component('selezione-contatti', SelezioneContatti);


        /* Registrazione dei componenti PrimeVue da usare nel Blade
        app.component('p-button', Button);
        app.component('p-datatable', DataTable);
        app.component('p-column', Column);
        */

        app.mount(rootEl);
    }
}