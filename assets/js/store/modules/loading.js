import {getField} from 'vuex-map-fields';
import {LOADING_DIALOG_HIDE, LOADING_DIALOG_SHOW} from '../mutation-types';

const mutations = {
    [LOADING_DIALOG_SHOW](state, payload) {
        state.show = true;
    },
    [LOADING_DIALOG_HIDE](state) {
        state.show = false;
    },
};
const getters = {
    getField,
};
const actions = {};
const state = () => ({
    show: false,
});

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};