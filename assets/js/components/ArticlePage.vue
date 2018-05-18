<template>
    <div>
        <h4>{{title}}</h4>
        <p v-html="body"></p>
    </div>
</template>

<script>
    import {createNamespacedHelpers} from 'vuex';

    const {
        mapState: mapArticleState,
    } = createNamespacedHelpers('article');

    export default {
        name: 'Article',
        computed: {
            ...mapArticleState(['title', 'body']),
        },
        methods: {},
        mounted() {
        },
    };
</script>

<style scoped>

</style>