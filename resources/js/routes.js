
import Pages from './components/Pages.vue';
import Topics from './components/Topics.vue';
import Templates from './components/Templates.vue';
import Login from './components/Login.vue';
import SocialLogin from './components/SocialLogin.vue';
import TopicEditor from './components/TopicEditor.vue';

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
        {
            path: '/app/pages',
            component: Pages,
            name: 'pages.index',
            meta: { requiresAuth: true }
        },

        {
            path: '/app/pages/create',
            component: PageEditor,
            name: 'pages.create',
            meta: { requiresAuth: true }
        },
        {
            path: '/app/pages/:id',
            component: PageEditor,
            name: 'pages.edit',
            meta: { requiresAuth: true }
        },


        /*
         * Category related routes
         */
        {
            path: '/app/topics',
            component: Topics,
            name: 'topics.index',
            meta: { requiresAuth: true }
        },

        {
            path: '/app/topics/create',
            component: TopicEditor,
            name: 'topics.create',
            meta: { requiresAuth: true }
        },

        {
            path: '/app/topics/:id',
            component: TopicEditor ,
            name: 'topics.edit',
            meta: { requiresAuth: true }
        },


        /*
         * Templates related routes
         */
        { path: '/app/templates', component: Templates, meta: { requiresAuth: true } },

        { path: '/app/templates/create', component: TemplateEditor, meta: { requiresAuth: true } },

        { path: '/app/templates/:id', component: TemplateEditor, meta: { requiresAuth: true } },


        /*
         * Login routes
         */
        { path: '/app/login', component: Login },

        { path: "/app/social/login/:provider/callback", component: SocialLogin },

    ]

}