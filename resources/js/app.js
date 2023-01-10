require('./bootstrap');
require('./elementar.css');

// Import modules...
import Vue from 'vue';
import {
    App as InertiaApp,
    plugin as InertiaPlugin
} from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import vMask from 'v-mask';
import {
    slider,
    slideritem,
    vueConciseSlider
} from 'vue-concise-slider';
import {
    VueFlowy
} from 'vue-flowy';
import BusinessHours from 'vue-business-hours';
import ToggleButton from 'vue-js-toggle-button'
import VueYouTubeEmbed from 'vue-youtube-embed'




// Fontawesome
import {
    library
} from '@fortawesome/fontawesome-svg-core'
import {
    FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'
import {
    faCss3,
    faJs,
    faVuejs
} from "@fortawesome/free-brands-svg-icons";
import {
    faRocket,
    faDotCircle,
    faWindowRestore,
    faEdit,
    faCalendarAlt,
    faEnvelope,
    faTasks,
    faWindowMaximize,
    faChartBar,
    faChevronDown,
    faCode,
    faAngleDown,
    faAngleUp,
    faLayerGroup,
    faGripHorizontal,
    faAngleLeft,
    faClock,
    faRetweet,
    faTags,
    faTv,
    faPlug,
    faTable,
    faShoppingBag,
    faLiraSign,
    faCheckCircle,
    faTrash,
    faBan,
    faKey,
    faUserEdit,
    faPlusCircle,
    faAngleDoubleRight,
    faPaperPlane,
    faBell,
    faIdCard,
    faFolder,
    faListUl,
    faDownload,
    faCheck,
    faMinusCircle,
    faInfo,
    faSave,
    faCog,
    faIdBadge,
    faEye,
    faPen,
    faClipboardCheck,
    faClipboardList,
    faUser,
    faUsers,
    faBinoculars,
    faSearch,
    faSortAmountDown,
    faSun,
    faMoon,
    faUserAstronaut
} from '@fortawesome/free-solid-svg-icons'

library.add(faPen, faBinoculars, faSun, faSearch, faMoon, faUserAstronaut, faSortAmountDown, faBell, faEye, faKey, faListUl, faDownload, faUserEdit, faIdCard, faFolder, faPaperPlane, faRocket, faDotCircle, faCheckCircle, faBan, faWindowRestore, faSave, faEdit, faJs, faCss3, faInfo, faCalendarAlt, faVuejs, faEnvelope, faTasks, faWindowMaximize, faChartBar, faChevronDown, faCode, faAngleDown, faAngleUp, faChartBar, faLayerGroup, faGripHorizontal, faAngleLeft, faClock, faRetweet, faTags, faTv, faPlug, faTable, faShoppingBag, faLiraSign, faTrash, faPlusCircle, faAngleDoubleRight, faCheck, faMinusCircle, faCog, faIdBadge, faClipboardCheck, faClipboardList, faUser, faUsers)
Vue.component('font-awesome-icon', FontAwesomeIcon)


Vue.mixin({
    methods: {
        route,
        colorToggle: function(theme){
            switch(theme){
                case 'solid-light':
                    return '#00a6ff';
                case 'solid-dark':
                    return '#3366ff';
                case 'solid-cosmic':
                    return '#a16eff';
                default:
                    return '#10b981';
            }
        }
    }
});
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(vMask);
Vue.use(slider);
Vue.use(slideritem);
Vue.component(VueFlowy);
Vue.use(BusinessHours);
Vue.use(VueYouTubeEmbed)

Vue.use(ToggleButton)

Vue.config.productionTip = false


const app = document.getElementById('app');

Vue.prototype.$styleTheme = {
    default: {
        topMenu: {
            boxShadow: 'rgb(1 1 1) 8px 0px 9px -7px inset, 0px -3px 10px #111'
        },
        boxShadowLeftMenu: {
            boxShadow: '1px 0px 10px #111'
        },
        boxShadowTopLeftMenu: {
            boxShadow: '-5px 3px 10px #111'
        },
        boxShadowBottomLeftMenu: {
            boxShadow: '-5px -3px 10px #111'
        }
    },
    light: {
        colorToggle:'#00a6ff',
        bgButtonHamburguer:{
            backgroundImage: 'linear-gradient(to right, #2563eb,#2563eb)'
        },
        paletaLight1:{
            backgroundColor: '#183666'
        },
        boxShadowColapse:{
            boxShadow: '0px 0px 10px #aaa'
        },
        borderBottomColaps:{
            borderBottom: '1px solid #81b9ff'
        },
        bgContentColapsInside:{backgroundColor: '#FFF !important'},
        bgContentColapsOutside:{backgroundColor: 'rgb(96 165 250 / 18%) !important'},
    },
    dark: {
        backgroundTooltip:{
            backgroundColor:'#e0e7ff !important'
        },
        colorToggle:'#a16eff',
        pagination:{
            backgroundColor: '#252547cc'
        },
        buttonBack:{
            backgroundColor: '#a16eff',
            borderColor: '#2c1079'
        },
        buttonBackHover:{
            backgroundColor: '#a17fff',
            borderColor: '#2c1079',
            color: '#312e81'
        },
        bgButtonHamburguer:{
            backgroundImage: 'linear-gradient(to right, #a16eff,#a16eff)'
        },
        borderColaps:{
            borderColor: '#4b4e69 !important'
        },
        borderBottomColaps:{
            borderBottom: '1px solid #4b4e69'
        },
        bgTitleColaps:{
            backgroundColor: '#30324e !important'
        },
        boxShadowColapse:{
            boxShadow: '0px 0px 10px #111'
        },
        bgContentColapsInside:{backgroundColor: '#474a74 !important', color:'#fff'},
        bgContentColapsOutside:{backgroundColor: '#1c1f3b !important', color:'#fff'},
        colorBgColapse:{
            backgroundColor: '#133774 !important'
        },
        paletaDark1: {
            backgroundColor: '#323259'
        },
        paletaDark2: {
            backgroundColor: '#1b1b37'
        },
        paletaDark3: {
            backgroundColor: '#30324e'
        },
        paletaDark4: {
            backgroundColor: '#698ac1'
        },
        paletaDark5: {
            backgroundColor: '#8ab6ff'
        },
        colorWhite: {
            color: "#FFF"
        },
        colorWhiteOff: {
            color: "#DDD"
        },
        boxShadowContentContainer: {
            boxShadow: 'rgb(1 1 1) 8px 8px 9px -7px inset'
        },
        colorInput: {
            backgroundColor: '#474a74',
            color:'#FFF',
            borderColor: '#5d6276'
        },
        colorTeste: {
            backgroundColor: '#f0f',
            color:'#f85'
        }
    }
};

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        })
}).$mount(app);
