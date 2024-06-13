import Vue from 'vue';
import Router from 'vue-router';
import BookList from '@/components/BookList.vue';
import AddBook from '@/components/AddBook.vue';
import BookDetail from '@/components/BookDetail.vue';

Vue.use(Router);

export default new Router({
  mode: 'history', // This mode removes the hash (#) from the URL
  routes: [
    {
        path: '/',
        name: 'BookList',
        component: BookList
    },
    {
        path: '/add',
        name: 'AddBook',
        component: AddBook
    },
    {
        path: '/book_detail/:id',
        name: 'BookDetail',
        component: BookDetail,
        props: true, // Enables passing route params as props to the component
      }
  ]
});
