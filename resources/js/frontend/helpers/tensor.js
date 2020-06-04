export function xget(url, handler, error) {

    return xhttp (url, {}, handler, error, 'GET')
}


export function xpost(url, data, handler, error) {

    return xhttp (url, data, handler, error, 'POST')
}

export function xput(url, data, handler, error) {

    return xhttp (url, data, handler, error, 'PUT')
}

export function xpatch(url, data, handler, error) {

    return xhttp (url, data, handler, error, 'PATCH')
}

export function xhttp(url, data, handler, error, method) {

    let xhr = new XMLHttpRequest()

    xhr.onload = function () {
        if (xhr.status < 200 || xhr.status >= 300) {
            (!!error) && error(xhr.response, xhr.status)
        } else {
            (!!handler) && handler(xhr.response, xhr.status)
        }
    }

    xhr.onerror = function () {
        console.log('Network Error')
    }

    xhr.open(method, url, true)
    xhr.responseType = 'json';
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.setRequestHeader('Accept', 'application/json');
    data["_token"] = window.csrf_token;

    xhr.send(JSON.stringify(data))
}
