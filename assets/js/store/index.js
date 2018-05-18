import Vue from 'vue';
import Vuex from 'vuex';
import merge from 'lodash/merge';

import {getField} from 'vuex-map-fields';
import * as types from './mutation-types';

import locale from './modules/locale';
import article from './modules/article';
import menu from './modules/menu';

Vue.use(Vuex);

const getters = {
    getField,
};

const mutations = {
    [types.APP_INIT](state, payload) {
        state.init = payload;
    },
    [types.SET_COMPONENT](state, payload) {
        state.component = payload;
    },
};

const actions = {
    async [types.APP_INIT]({state, commit}, payload) {
        await commit('locale/' + types.SET_LOCALE, payload['locale']);
        delete payload['locale'];
        await commit('locale/' + types.SET_LOCALES, payload['locales']);
        delete payload['locales'];
        await commit('locale/' + types.SET_TRANSLATIONS,
            payload['translations']);
        delete payload['translations'];

        await commit(types.APP_INIT, payload);
    },
    async [types.SET_COMPONENT]({state, commit}, payload) {
        await commit(types.SET_COMPONENT, payload);
    },
};

const state = {
    init: {},
    component: 'IndexPage',
    state_1: 'state_1',
    state_2: null,
};

const modules = {
    locale,
    article,
    menu,
};

export function createStore() {
    return new Vuex.Store({
        state,
        actions,
        mutations,
        getters,
        modules,
    });
}

const store = createStore();
export default store;

export function updateState(store, state) {
    store._withCommit(function() {
        store._vm._data.$$state = merge(store._vm._data.$$state, state);
    });
}