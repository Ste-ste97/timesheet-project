require('./bootstrap');

import { createApp, h, reactive } from 'vue';
import {  App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import "primevue/resources/themes/lara-light-indigo/theme.css";

import "primeflex/primeflex.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";

import PrimeVue from 'primevue/config';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Avatar from 'primevue/avatar';
import AvatarGroup from 'primevue/avatargroup';
import BadgeDirective from 'primevue/badgedirective';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Carousel from 'primevue/carousel';
import Checkbox from 'primevue/checkbox';
import Chip from 'primevue/chip';
import ConfirmDialog from 'primevue/confirmdialog';
import Dialog from 'primevue/dialog';
import Divider from 'primevue/divider';
import Dropdown from 'primevue/dropdown';
import FileUpload from 'primevue/fileupload';
import InputNumber from 'primevue/inputnumber';
import InputSwitch from 'primevue/inputswitch';
import InputText from 'primevue/inputtext';
import Knob from 'primevue/knob';
import Menu from 'primevue/menu';
import Message from 'primevue/message';
import MultiSelect from 'primevue/multiselect';
import ProgressBar from 'primevue/progressbar';
import RadioButton from 'primevue/radiobutton';
import Rating from 'primevue/rating';
import Ripple from 'primevue/ripple';
import Password from 'primevue/password';
import Sidebar from 'primevue/sidebar';
import StyleClass from 'primevue/styleclass';
import TabMenu from 'primevue/tabmenu';
import TabPanel from 'primevue/tabpanel';
import TabView from 'primevue/tabview';
import Tag from 'primevue/tag';
import Textarea from 'primevue/textarea';
import Tooltip from 'primevue/tooltip';
import Toast from 'primevue/toast';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';

const el = document.getElementById('app');

const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
});

app.mixin({ methods: { route } });
app.use(PrimeVue, { ripple: true })
app.use(InertiaPlugin);
app.use(ConfirmationService);
app.use(ToastService);

app.component('router-link', {}) // to hide warning from primevue
app.component('Accordion', Accordion);
app.component('AccordionTab', AccordionTab);
app.component('Avatar', Avatar);
app.component('AvatarGroup', AvatarGroup);
app.component('Button', Button);
app.component('Calendar', Calendar);
app.component('Carousel', Carousel);
app.component('Checkbox', Checkbox);
app.component('Chip', Chip);
app.component('ConfirmDialog', ConfirmDialog);
app.component('Dialog', Dialog);
app.component('Divider', Divider);
app.component('Dropdown', Dropdown);
app.component('FileUpload', FileUpload);
app.component('InputNumber', InputNumber);
app.component('InputSwitch', InputSwitch);
app.component('InputText', InputText);
app.component('Knob', Knob);
app.component('Menu', Menu);
app.component('MultiSelect', MultiSelect);
app.component('Message', Message);
app.component('ProgressBar', ProgressBar);
app.component('RadioButton', RadioButton);
app.component('Password', Password)
app.component('Rating', Rating);
app.component('Sidebar', Sidebar);
app.component('TabMenu', TabMenu);
app.component('TabPanel', TabPanel);
app.component('TabView', TabView);
app.component('Tag', Tag);
app.component('Textarea', Textarea);
app.component('Toast', Toast);

app.directive('badge', BadgeDirective);
app.directive('tooltip', Tooltip);
app.directive('ripple', Ripple);
app.directive('styleclass', StyleClass);


app.mount(el);

InertiaProgress.init({ color: '#4B5563' });
