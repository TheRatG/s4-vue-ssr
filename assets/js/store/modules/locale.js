import {getField} from 'vuex-map-fields';
import * as types from '../mutation-types';

const getters = {
    getField,
};

const mutations = {
    [types.SET_LOCALE](state, payload) {
        state.locale = payload;
    },
    [types.SET_LOCALES](state, payload) {
        state.locales = payload;
    },
    [types.SET_TRANSLATIONS](state, payload) {
        state.translations = payload;
    }
};

const actions = {};

const state = () => ({
    locale: 'en',
    locales: [],
    translations: {}
});

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};