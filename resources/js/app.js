

 window.Vue = require('vue').default;

 window.axios = require('axios');
 window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


 Vue.component('example-component', require('./components/ExampleComponent.vue').default);
 Vue.component('quiz', require('./components/quiz_main.vue').default);
//  Vue.component('question', require('./components/question.vue').default);


 const app = new Vue({
     el: '#app',
 });
