import Pages from './components/Pages.vue';


const PageEditor = () => import ( 
    /* webpackChunkName: "PageEditor" */ 
    './components/PageEditor.vue'
); 


export default {

    mode: 'history',


    routes: [

        {
            path: '/app/pages',
            component: Pages
        },

        {
            path: '/app/pages/create',
            component: PageEditor
        },
    ]

}