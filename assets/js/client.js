import {createApp} from './app';
import store from './store';

if (typeof window !== 'undefined'
    && window.hasOwnProperty('__INITIAL_STATE__')) {
    store.replaceState(window.__INITIAL_STATE__);
}

const app = createApp({store: store});
app.$mount('#app');