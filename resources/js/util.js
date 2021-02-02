;(function (util, undefined) {
    //Private Property
    var isHot = true
    var timer = null

    // Public properties

    //Public Methods

    /**
     * ---------------------------------------------------------------
     * Handy utility functions
     * ---------------------------------------------------------------
     */
    util.getMonthName = function (yyyymm) {
        let month_name = 'Unknown'
        try {
            let year_part = parseInt(yyyymm.slice(0, 4))
            let month_part = parseInt(yyyymm.slice(4, 6))
            let d = new Date(year_part, month_part - 1)
            month_name = d.toLocaleString('default', { month: 'long' })
        } catch (e) {
            console.log(e)
        }
        return month_name
    }

    util.formatDate = function (date_val, format) {
        /*
         * Supported Formats are:
         * d - 2 digit date
         * m - 2 digit month number
         * M - Full Month name
         * MMM - 3 char short Month name
         * Y - 4 digit year
         */
        let d = date_val.getDate()
        d = (d > 9 ? '' : '0') + d

        let m = date_val.getMonth()
        let M = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ][m]
        m = (m + 1 > 9 ? '' : '0') + (m + 1)

        let Y = date_val.getFullYear()

        return format
            .replace('Y', Y)
            .replace('m', m)
            .replace('MMM', M.substr(0, 3))
            .replace('M', M)
            .replace('d', d)
    }

    // Generic DOM Selector
    util.get = function (selector) {
        return document.querySelector(selector)
    }

    util.click = function (selector, callback) {
        let els = document.querySelectorAll(selector)
        let l = els.length
        for (let i = 0; i < l; i++) {
            let el = els[i]
            el.addEventListener('click', callback)
        }
    }

    //  Creates a form with the given data and submits the form to the
    //  provided URL. If no data is provided, empty form is submitted.
    util.submit = function (url, data, method) {
        if (typeof url === 'undefined') {
            return
        }
        if (typeof data === 'undefined') {
            data = {}
        }
        if (typeof method === 'undefined') {
            method = 'post'
        }
        const form = document.createElement('form')
        form.method = method.toLowerCase() === 'get' ? 'GET' : 'POST'
        form.action = url
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                const hiddenField = document.createElement('input')
                hiddenField.type = 'hidden'
                hiddenField.name = key
                hiddenField.value = data[key]
                form.appendChild(hiddenField)
            }
        }
        const csrfField = document.createElement('input')
        csrfField.type = 'hidden'
        csrfField.name = '_token'
        csrfField.value = window.token
        form.appendChild(csrfField)

        if (
            method.toLowerCase() === 'delete' ||
            method.toLowerCase() === 'patch' ||
            method.toLowerCase() === 'put'
        ) {
            const methodField = document.createElement('input')
            methodField.type = 'hidden'
            methodField.name = '_method'
            methodField.value = method.toUpperCase()
            form.appendChild(methodField)
        }

        document.body.appendChild(form)
        form.submit()
    }

    /**
     * ---------------------------------------------------------------
     * Various Sweetalert based notification functions
     * ---------------------------------------------------------------*/

    // Creates an alert as a toast notification
    // Example use: util.toast({icon: 'error', title: "Try again."})
    util.toast = function (param) {
        let toastConfig = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
        })

        toastConfig.fire(param)
    }

    util.confirm = function (title, text = null, fnConfirm = null, fnCancelled = null) {
        let swalWithTailWindButtons = Swal.mixin({
            customClass: {
                confirmButton: 'mx-3 py-1 px-3 bg-green-500 text-white rounded hover:bg-green-700',
                cancelButton: 'mx-3 py-1 px-3 bg-red-500 text-white rounded hover:bg-red-700',
            },
            buttonsStyling: false,
        })

        swalWithTailWindButtons
            .fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            })
            .then((result) => {
                if (result.value) {
                    if (fnConfirm) fnConfirm()
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    if (fnCancelled) fnCancelled()
                }
            })
    }

    util.prompt = async function (text, placeholder, callback) {
        const { value: answer } = await Swal.fire({
            title: text,
            input: 'text',
            inputPlaceholder: placeholder,
        })

        callback(answer)
    }

    util.notify = function (params, callback) {
        return Swal.fire(params).then((result) => {
            if (callback) callback(result)
        })
    }

    util.notifySuccess = function (title, text, callback) {
        return this.notify(
            {
                icon: 'success',
                title: title,
                text: text,
            },
            callback
        )
    }

    util.notifyError = function (title, text, callback) {
        return this.notify(
            {
                icon: 'error',
                title: title,
                text: text,
            },
            callback
        )
    }

    util.notifyInfo = function (title, text, callback) {
        return this.notify(
            {
                icon: 'info',
                title: title,
                text: text,
            },
            callback
        )
    }

    util.debounce = function (milliseconds, fn) {
        if (util.timer) clearTimeout(util.timer)

        util.timer = setTimeout(() => {
            fn()
        }, milliseconds)
    }

    /**
     * AJAX Related Utility functions
     * ---------------------------------------------------------------
     * Makes ajax request to the URL with or without the given data
     * ---------------------------------------------------------------*/
    util.ajax = function (
        type,
        url,
        data,
        success_handler,
        client_error_handler,
        server_error_handler,
        other_error_handler
    ) {
        if (typeof type === 'undefined') type = 'post'
        if (typeof url === 'undefined') return
        if (typeof data === 'undefined') data = {}
        if (typeof success_handler === 'undefined')
            success_handler = function (response_data) {
                alert('Operation completed successfully')
                console.log(response_data)
            }
        const general_error_handler = function (statusCode, data) {
            let message = data.hasOwnProperty('message')
                ? data.message
                : 'There is an error while trying to reach server.'
            alert(statusCode + ': ' + message)
            console.log(data)
        }
        if (typeof client_error_handler === 'undefined')
            client_error_handler = general_error_handler
        if (typeof server_error_handler === 'undefined')
            server_error_handler = general_error_handler
        if (typeof other_error_handler === 'undefined') other_error_handler = general_error_handler

        let handler

        switch (type.toLowerCase()) {
            case 'get':
                handler = axios.get(url)
                break
            case 'post':
                handler = axios.post(url, data)
                break
            case 'patch':
                handler = axios.patch(url, data)
                break
            case 'put':
                handler = axios.put(url, data)
                break
            case 'delete':
                handler = axios.delete(url, { data: data })
        }

        handler.then((response) => {
            success_handler(response.data)
        })

        handler.catch((error) => {
            // Error
            if (error.response) {
                // 4xx errors
                if (error.response.status >= 400 && error.response.status < 500) {
                    switch (error.response.status) {
                        // unauthenticated
                        case 401:
                            util.notifyInfo('You are not logged in.', 'Please login again').then(
                                function () {
                                    location.href = '/'
                                }
                            )
                            break

                        // unauthorised
                        case 403:
                            util.notifyInfo(
                                'You do not have access to this resource.',
                                'Contact site admin.'
                            ).then(
                                function () {
                                    location.href = '/'
                                }
                            )
                            break

                        // login expired
                        case 419:
                            util.notifyInfo(
                                'Do I know you?',
                                'Looks like you are logged out. Please login again'
                            ).then(function () {
                                location.href = '/'
                            })
                            break

                        // validation error
                        case 422:
                            let e = error.response.data.errors
                            let k = Object.keys(e)
                            util.notifyError(error.response.data.message, e[k[0]][0])
                            break

                        default:
                            client_error_handler(error.response.status, error.response.data)
                    } // end of switch
                }

                //5xx errors
                if (error.response.status >= 500) {
                    server_error_handler(error.response.status, error.response.data)
                }
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser
                other_error_handler(
                    '204',
                    'The request was made but no response was received. Please try again later.'
                )
                console.log(error.request)
            } else {
                // Something happened in setting up the request that triggered an Error
                other_error_handler('000', 'Something wrong happened in setting up the request.')
                console.log('Error', error.message)
            }
            // console.log(error.config);
        })
    }

    //Private Method
})((window.util = window.util || {}))
