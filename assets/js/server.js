import {createApp} from './app';
import {createStore} from './store';

import util from 'util';

const store = createStore();
store.replaceState(PHP);

const app = createApp({store: store});

renderVueComponentToString(app, (err, res) => {
    // print(err);
    print(res);
    const state = util.inspect(
        app.$store.state,
        {showHidden: false, depth: null},
    );
    print(`<script type="text/javascript">
window.__INITIAL_STATE__ = ${state};
</script>   
`);
});
