import Dashboard from './components/Dashboard.vue';
import Pages from './components/Pages.vue';
import Topics from './components/Topics.vue';
import Templates from './components/Templates.vue';
import Login from './components/Login.vue';
import SocialLogin from './components/SocialLogin.vue';
import TopicEditor from './components/TopicEditor.vue';
import TemplateEditor from './components/TemplateEditor.vue';
import Users from './components/Users.vue';
import UserForm from './components/UserForm.vue';
import Settings from './components/Settings.vue';

/* dynamic components */
const PageEditor = () => import (
    /* webpackChunkName: "PageEditor" */
    './components/PageEditor.vue'
);

const TemplateFileEditor = () => import (
    /* webpackChunkName: "TemplateFileEditor" */
    './components/TemplateFileEditor.vue'
);

export default {

    mode: 'history',

    routes: [

        {
            path: '/app',
            component: Dashboard,
            name: 'dashboard',
            meta: { requiresAuth: true }
        },

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

        { path: '/app/templates/:id/get/:file', component: TemplateFileEditor, meta: { requiresAuth: true } },

        { path: '/app/templates/:id/create', component: TemplateFileEditor, meta: { requiresAuth: true } },

        { path: '/app/templates/:id', component: TemplateEditor, meta: { requiresAuth: true } },


        /*
         * User related routes
         */
        {
            path: '/app/users',
            component: Users,
            name: 'users.index',
            meta: { requiresAuth: true }
        },

        {
            path: '/app/users/create',
            component: UserForm,
            name: 'users.create',
            meta: { requiresAuth: true }
        },

        {
            path: '/app/users/:id',
            component: UserForm ,
            name: 'users.edit',
            meta: { requiresAuth: true }
        },


        /*
         * Setting related routes
         */
        {
            path: '/app/settings',
            component: Settings,
            name: 'settings.index',
            meta: { requiresAuth: true }
        },


        /*
         * Login routes
         */
        { path: '/app/login', component: Login },

        { path: "/app/social/login/:provider/callback", component: SocialLogin },

    ]

}