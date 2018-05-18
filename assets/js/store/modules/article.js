import {getField} from 'vuex-map-fields';
import * as types from '../mutation-types';

const getters = {
    getField,
};

const mutations = {
};

const actions = {
};

const state = () => ({
    title: '',
    body: '',
});

export default {
    namespaced: true,
    getters,
    state,
    actions,
    mutations,
};