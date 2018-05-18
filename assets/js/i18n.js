import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);

export function createI18n() {
    return new VueI18n({
        locale: 'en', // set locale
        fallbackLocale: 'en',
    });
}