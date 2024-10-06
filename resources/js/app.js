import "./bootstrap";
import { createApp } from "vue";
import app from "./src/App.vue";
import helper from "./src/mixins/helper.js";
import router from './src/router';
import VuePlyr from 'vue-plyr'
import { createPinia } from 'pinia'
const pinia = createPinia()

createApp(app).mixin(helper).use(router).use(pinia).use(VuePlyr, {
    plyr: {}
}).mount("#app");