import {createI18n} from 'vue-i18n'


/**
 */
function loadMessages() {
    const context = require.context("../../lang", false, /\.json$/);
    const messages = {};
    context.keys().forEach((key) => {
        const locale = key.match(/([a-z0-9_]+)\.json$/i)[1];
        messages[locale] = context(key);
    });
    return messages

}
const i18n = createI18n({
    legacy: false,
    globalInjection: true,
    runtimeOnly: false,
    locale: app_lang,
    fallbackLocale: 'sa',
    messages: loadMessages() // set locale messages
})
export default i18n;
