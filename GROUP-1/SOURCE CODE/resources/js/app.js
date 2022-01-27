require("./bootstrap");

// Import modules...
import { createApp, h } from "vue";
import {
    App as InertiaApp,
    plugin as InertiaPlugin,
} from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import VueEasyLightbox from "vue-easy-lightbox";
import VueSnip from "vue-snip";

const el = document.getElementById("app");

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(VueEasyLightbox)
    .use(VueSnip)
    .mount(el);

InertiaProgress.init({ color: "#4B5563" });
