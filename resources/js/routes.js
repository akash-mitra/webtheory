import Dashboard from './components/Dashboard.vue'
import Pages from './components/Pages.vue'
import Categories from './components/Categories.vue'
import Design from './components/Design.vue'
import CategoryEditor from './components/CategoryEditor.vue'
import TemplateEditor from './components/TemplateEditor.vue'
import Users from './components/Users.vue'
import UserForm from './components/UserForm.vue'
import Settings from './components/Settings.vue'
import Library from './components/Library.vue'
import Forms from './components/Forms.vue'
import FormEditor from './components/FormEditor.vue'

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
            meta: {
                title: 'Dashboard',
            },
        },

        /*
         * Page related routes
         */
        {
            path: '/app/pages',
            component: Pages,
            name: 'pages.index',
            meta: {
                title: 'Pages',
            },
        },

        {
            path: '/app/pages/create',
            component: PageEditor,
            name: 'pages.create',
            meta: {
                title: 'New Page',
            },
        },
        {
            path: '/app/pages/:id',
            component: PageEditor,
            name: 'pages.edit',
            meta: {
                title: 'Edit Page',
            },
        },

        /*
         * Category related routes
         */
        {
            path: '/app/categories',
            component: Categories,
            name: 'categories.index',
            meta: {
                title: 'Categories',
            },
        },

        {
            path: '/app/categories/create',
            component: CategoryEditor,
            name: 'categories.create',
            meta: {
                title: 'New Categories',
            },
        },

        {
            path: '/app/categories/:id',
            component: CategoryEditor,
            name: 'categories.edit',
            meta: {
                title: 'Edit Categories',
            },
        },

        /*
         * Design related routes
         */
        {
            path: '/app/design',
            component: Design,
            name: 'design',
            meta: {
                title: 'Design',
            },
        },

        /*
         * Templates related routes
         */

        {
            path: '/app/templates/create',
            component: TemplateEditor,
            name: 'templates.create',
            meta: {
                title: 'Templates',
            },
        },

        {
            path: '/app/templates/:id/get/:fileIdentity',
            component: TemplateFileEditor,
            name: 'templates.file',
            meta: {
                title: 'Templates',
            },
        },

        {
            path: '/app/templates/:id/create',
            component: TemplateFileEditor,
            name: 'templates.file.create',
            meta: {
                title: 'Templates',
            },
        },

        {
            path: '/app/templates/:id',
            component: TemplateEditor,
            name: 'templates.edit',
            meta: {
                title: 'Templates',
            },
        },

        /*
         * User related routes
         */
        {
            path: '/app/users',
            component: Users,
            name: 'users.index',
            meta: {
                title: 'Users',
            },
        },

        {
            path: '/app/users/create',
            component: UserForm,
            name: 'users.create',
            meta: {
                title: 'Users',
            },
        },

        {
            path: '/app/users/:id',
            component: UserForm,
            name: 'users.edit',
            meta: {
                title: 'Users',
            },
        },

        {
            path: '/app/settings',
            component: Settings,
            name: 'settings.index',
            meta: {
                title: 'Settings',
            },
        },

        {
            path: '/app/library',
            component: Library,
            name: 'gallery.index',
            meta: {
                title: 'Library',
            },
        },

        {
            path: '/app/forms',
            component: Forms,
            name: 'forms.index',
            meta: {
                title: 'Forms',
            },
        },

        {
            path: '/app/forms/:id',
            component: FormEditor,
            name: 'forms.edit',
            meta: {
                title: 'Forms',
            },
        },
    ],
}
