import Vue from 'vue';
import Generator from '../../vue/backend/Generator.vue';

document.addEventListener("DOMContentLoaded", () => {
    new Vue({
        el: '#coupon-generator-app',
        render: h => h(Generator)
    });
});
