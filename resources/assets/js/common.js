import toastr from "toastr";
/**
 * Toaster config.
 */
toastr.options  = {
    "closeButton": true,
    "preventDuplicates": true,
    "extendedTimeOut": 0,
    "tapToDismiss": true,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut",
    "newestOnTop": true,
    "positionClass": "toast-top-right",
    "timeOut": "10000"
};

/**
 * Set Cookie
 *
 * @param cname
 * @param cvalue
 * @param exdays
 *
 * @return void
 */
function setCookie(cname, cvalue, exdays = 30) {
    let d = new Date();

    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires=" + d.toGMTString();

    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get a specific cookie
 *
 * @param cname
 * @returns {*}
 */
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');

    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }

    return null;
}

/**
 * Get JSON header for API Call.
 *
 *
 * @return {{Content-Type: string, Accept: string, Cookie-Id: *}}
 */
function jsonHeader() {
    return {
        "Content-Type":"application/json",
        "Accept":"application/json",
        "Cookie-Id": getCookieId()
    };
}

/**
 * Get cookie Id.
 *
 * @return {*}
 */
function getCookieId() {
    let cookieId    = getCookie('cookie_id');

    if (! cookieId) {
        cookieId    = uuid.v4();

        setCookie('cookie_id', cookieId);
    }

    return cookieId;
}

/**
 * Show Loader
 */
function showLoader(text = 'Please Wait . . .') {
    $('body').loadingModal({
        text: text,
        animation: 'fadingCircle'
    });
}

/**
 * Hide Loader
 */
function hideLoader() {
    $('body').loadingModal('hide');
    $('body').loadingModal('destroy');
}

/**
 * Verify for emptiness.
 *
 * @param item
 * @returns {boolean}
 */
function empty(item) {
    return item == null || item == undefined || item.length == 0
}

/**
 * sort list by date.
 *
 * @param a
 * @param b
 * @return {number}
 */
function sortByCreatedAt(a, b){
    return new Date(b.created_at) - new Date(a.created_at);
}

/**
 * Remove object by attr.
 *
 * @param arr
 * @param attr
 * @param value
 * @return {*}
 */
function removeByAttr(arr, attr, value){
    var i = arr.length;
    while(i--){
        if( arr[i]
            && arr[i].hasOwnProperty(attr)
            && (arguments.length > 2 && arr[i][attr] === value ) ){

            arr.splice(i,1);

        }
    }
    return arr;
}

/**
 * Show validation errors.
 *
 * @param error
 */
function validationError(error) {
    if (error.status == 400) {
        $.each(error.responseJSON.data.validation, function (key, value) {
            toastr.error(value, error.responseJSON.message);
        });
    }
}