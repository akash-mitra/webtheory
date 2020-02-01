export function isProtected (route) {
    return route.matched.some(record => record.meta.requiresAuth)
}

export function loginValid () {

    return isAuthenticated() && isFresh()
}


export function isAuthenticated () {
    return window.localStorage.getItem('userIsAuthenticated')
}


export function isFresh () {

    // retrieve the last logged in time
    let lastLoginAt = parseInt(window.localStorage.getItem('lastLoginAt'));

    if (isNaN(lastLoginAt)) return false;

    // add 120 minutes with the last login time
    let freshPeriod = 120;
    let loginValidTill = new Date(lastLoginAt + freshPeriod * 60 * 1000);

    // console.log('Login valid till: ' + loginValidTill);
    // console.log('Current: ' + new Date());

    return (new Date()) < loginValidTill

}


export function storeLocalCredential (user)
{
    window.localStorage.setItem('userIsAuthenticated', true)
    window.localStorage.setItem('lastLoginAt', (new Date()).getTime())
    window.localStorage.setItem('authUser', JSON.stringify(user))
}


export function removeLocalCredential ()
{
    window.localStorage.removeItem('userIsAuthenticated')
    window.localStorage.removeItem('lastLoginAt')
    window.localStorage.removeItem('authUser')
}


export function getLocalUser ()
{
    return JSON.parse(window.localStorage.getItem('authUser'))
}


export function getDefaultRedirectRoute()
{
    return 'pages.index'
}