import 'babel-polyfill';
import Vue from 'vue';

import {createStore} from './store';
import {createI18n} from './i18n';

import './setup/validator';
import './setup/router';

import App from './components/App.vue';
import './components/_globals';

import util from 'util';

export function createApp({store, i18n = null} = {}) {
    i18n = store || createI18n();

    return new Vue({
        store,
        i18n,
        render: h => h(App),
        created() {
            //print(util.inspect(store.state, {showHidden: false, depth: null}));
            this.$i18n.locale = store.state.locale['locale'];
            this.$i18n.setLocaleMessage(
                store.state.locale['locale'],
                store.state.locale['translations'],
            );
        },
    });
}
