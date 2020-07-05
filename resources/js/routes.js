import Dashboard from './components/Dashboard.vue'
import Pages from './components/Pages.vue'
import Categories from './components/Categories.vue'
import Templates from './components/Templates.vue'
import CategoryEditor from './components/CategoryEditor.vue'
import TemplateEditor from './components/TemplateEditor.vue'
import Users from './components/Users.vue'
import UserForm from './components/UserForm.vue'
import Settings from './components/Settings.vue'
import Gallery from './components/Gallery.vue'

/* dynamic components */
const PageEditor = () =>
    import(
        /* webpackChunkName: "PageEditor" */
        './components/PageEditor.vue'
    )

const TemplateFileEditor = () =>
    import(
        /* webpackChunkName: "TemplateFileEditor" */
        './components/TemplateFileEditor.vue'
    )

export default {
    mode: 'history',

    routes: [
        {
            path: '/app',
            component: Dashboard,
            name: 'dashboard',
        },

        /*
         * Page related routes
         */
        {
            path: '/app/pages',
            component: Pages,
            name: 'pages.index',
        },

        {
            path: '/app/pages/create',
            component: PageEditor,
            name: 'pages.create',
        },
        {
            path: '/app/pages/:id',
            component: PageEditor,
            name: 'pages.edit',
        },

        /*
         * Category related routes
         */
        {
            path: '/app/categories',
            component: Categories,
            name: 'categories.index',
        },

        {
            path: '/app/categories/create',
            component: CategoryEditor,
            name: 'categories.create',
        },

        {
            path: '/app/categories/:id',
            component: CategoryEditor,
            name: 'categories.edit',
        },

        /*
         * Templates related routes
         */
        { path: '/app/templates', component: Templates },

        { path: '/app/templates/create', component: TemplateEditor },

        { path: '/app/templates/:id/get/:fileIdentity', component: TemplateFileEditor },

        { path: '/app/templates/:id/create', component: TemplateFileEditor },

        { path: '/app/templates/:id', component: TemplateEditor },

        /*
         * User related routes
         */
        {
            path: '/app/users',
            component: Users,
            name: 'users.index',
        },

        {
            path: '/app/users/create',
            component: UserForm,
            name: 'users.create',
        },

        {
            path: '/app/users/:id',
            component: UserForm,
            name: 'users.edit',
        },

        /*
         * Setting related routes
         */
        {
            path: '/app/settings',
            component: Settings,
            name: 'settings.index',
        },

        /*
         * Setting related routes
         */
        {
            path: '/app/gallery',
            component: Gallery,
            name: 'gallery.index',
        },
    ],
}
