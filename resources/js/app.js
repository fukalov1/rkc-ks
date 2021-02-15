/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import axios from 'axios';


import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel';

let owl_carousel = require('owl.carousel');
window.fn = owl_carousel;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('client-component', require('./components/ClientComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    created() {
        let csrfToken = document.head.querySelector('meta[name="csrf-token"]');

        if (csrfToken) {
            console.log('123');
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
        } else {
            console.log('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
    }
});


$(document).ready(function () {
    $('.owl-one').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        responsiveClass: true,
        autoplay: false,
        autoplayTimeout: 5000,
        autoplaySpeed: 1000,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            480: {
                items: 1,
                nav: false
            },
            667: {
                items: 1,
                nav: true
            },
            1000: {
                items: 1,
                nav: true
            }
        }
    })
});
