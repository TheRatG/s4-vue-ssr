<template>
    <div id="app">
        <h1>{{$t('messages.welcome')}}</h1>
        <locale></locale>
        <app-menu></app-menu>
        <hr>
        <component :is="component"></component>
        <hr>
        <button @click="show_state = !show_state">{{$t('messages.show_state')}}</button>
        <section v-if="show_state">
            <pre>{{$store.state}}</pre>
        </section>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    import Locale from './Widget/Locale';
    import AppMenu from './Widget/Menu';

    export default {
        name: 'App',
        components: {
            Locale,
            AppMenu,
        },
        data() {
            return {
                show_state: null,
            };
        },
        computed: {
            ...mapState(['component']),
        },
        methods: {
            revealClientState() {
                this.client_state = this.$store.state;
            },
        },
    };
</script>

<style scoped>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3350;
        margin-top: 60px;
        padding-left: 10%;
        padding-right: 10%;
    }
</style>