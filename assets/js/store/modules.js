import upperFirst from 'lodash/upperFirst';
import camelCase from 'lodash/camelCase';

export function registerModules(store) {
    const requireComponent = require.context(
        // Look for files in the current directory
        './modules',
        // Do not look in subdirectories
        false,
        // Only include "_base-" prefixed .vue files
        /[\w-]+\.js/,
    );

    // For each matching file name...
    requireComponent.keys().forEach(fileName => {
        // Get the component config
        const moduleConfig = requireComponent(fileName);
        // Get the PascalCase version of the component name
        const moduleName = upperFirst(
            camelCase(
                fileName
                // Remove the "./_" from the beginning
                    .replace(/^\.\/_/, '')
                    // Remove the file extension from the end
                    .replace(/\.\w+$/, ''),
            ),
        );
        // Globally register the component
        store.registerModule(moduleName, moduleConfig.default || moduleConfig);
    });
}