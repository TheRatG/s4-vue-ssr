<template>
    <div>
        <h4>{{$t('messages.widget_locale')}}</h4>
        <ul>
            <li>{{$t('messages.widget_current_locale')}}: {{locale}}</li>
            <li>{{$t('messages.widget_locales')}}:
                <span v-for="locale in locales">&nbsp;<a
                        :href="$fosGenerate('app.home', {}, false, locale)">{{locale}}</a> </span>
            </li>
        </ul>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: 'Locale',
        computed: {
            ...mapState('locale', ['locale', 'locales']),
        },
    };
</script>

<style scoped>

</style>