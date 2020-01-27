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

    // add 1 hour(s) with the last login time
    let freshPeriod = 1;
    let loginValidTill = new Date(lastLoginAt + freshPeriod * 60 * 60 * 1000);

    // console.log('Login valid till: ' + loginValidTill);
    // console.log('Current: ' + new Date());

    return (new Date()) < loginValidTill

}
