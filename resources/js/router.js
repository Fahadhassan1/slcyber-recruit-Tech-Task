import Vue from 'vue';
import VueRouter from 'vue-router';

// Import your components
import BookListing from './components/BookListing.vue';
import EditBook from './components/EditBook.vue';

// Tell Vue to use VueRouter
Vue.use(VueRouter);

// Define routes
const routes = [
    {
        path: '/',
        name: 'BookListing',
        component: BookListing
    },
    {
        path: '/edit/:id',
        name: 'EditBook',
        component: EditBook,
        props: true
    }
];

// Create a new instance of VueRouter and export it
const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
