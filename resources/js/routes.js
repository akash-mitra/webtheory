
import Pages from './components/Pages.vue';
import Topics from './components/Topics.vue';
import Templates from './components/Templates.vue';

/* dynamic components */
const PageEditor = () => import (
    /* webpackChunkName: "PageEditor" */
    './components/PageEditor.vue'
);

const TemplateEditor = () => import (
    /* webpackChunkName: "TemplateEditor" */
    './components/TemplateEditor.vue'
);

export default {

    mode: 'history',


    routes: [

        /*
         * Page related routes
         */
        { path: '/app/pages', component: Pages },

        { path: '/app/pages/create', component: PageEditor },

        { path: '/app/pages/:id', component: PageEditor },


        /*
         * Category related routes
         */
        { path: '/app/topics', component: Topics },

        // { path: '/app/topics/create', component: TopicEditor },

        // { path: '/app/topics/:id', component: TopicEditor },


        /*
         * Templates related routes
         */
        { path: '/app/templates', component: Templates },

        { path: '/app/templates/create', component: TemplateEditor },

        { path: '/app/templates/:id', component: TemplateEditor },

    ]

}