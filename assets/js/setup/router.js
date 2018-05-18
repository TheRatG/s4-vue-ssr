import Vue from 'vue';
import Routing
    from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

const routes = require('../../../public/js/fos_js_routes.json');
Routing.setRoutingData(routes);

const RoutingPlugin = {
    install(Vue, options) {
        Vue.prototype.$fosGenerate = function(name, opt_params, absolute, locale) {
            locale = locale || this.$store.state.locale.locale;
            Routing.setPrefix(locale + '__RG__');
            return Routing.generate(name, opt_params, absolute);
        };
        Vue.prototype.$fosGetRoutes = function(name, opt_params, absolute) {
            return Routing.getRoutes();
        };
    },
};
Vue.use(RoutingPlugin);
