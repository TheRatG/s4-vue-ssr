<template>
    <div>
        <h4>{{$t('messages.widget_menu')}}</h4>
        <table class="table">
            <thead>
            <tr>
                <th>{{$t('menu.manual')}}</th>
                <th>{{$t('menu.knp')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <ul>
                        <li><a :href="$fosGenerate('app.home')">{{$t('menu.link_home')}}</a></li>
                        <li><a :href="$fosGenerate('app.about')">{{$t('menu.link_about')}}</a></li>
                    </ul>
                </td>
                <td>
                    <ul class="nav">
                        <li v-for="(row, index) in rows" class="link_name" >
                            <a
                                    :href="row.uri"
                                    :class="row.class.join(' ')"
                            ><span v-html="'---'.repeat(row.depth)+'&nbsp;'+row.name"></span></a>
                        </li>
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {createNamespacedHelpers} from 'vuex';

    const {
        mapState: mapMenuState,
    } = createNamespacedHelpers('menu');

    export default {
        name: 'Menu',
        computed: {
            ...mapMenuState(['rows']),
        },
    };
</script>

<style scoped>
    .table {
        width: 100%;
    }
    .nav {
        list-style-type: none
    }
    .current {
        font-weight: bold;
        color: olivedrab;
    }
    .link_name {
        width: 300px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
</style>