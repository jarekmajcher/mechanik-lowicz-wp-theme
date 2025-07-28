const setCookie = (name, value, days) => {
    var d = new Date;
    d.setTime(d.getTime() + 24*60*60*1000*days);
    document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
};

const isElementInViewport = (el) => {
    var rect = el.getBoundingClientRect();

    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
};

const onVisibilityChange = (el, callback) => {
    var oldVisible;
    return function () {
        var visible = isElementInViewport(el);
        if(visible !== oldVisible) {
            oldVisible = visible;
            if (typeof callback == 'function') {
                callback();
            }
        }
    }
};

module.exports = {
    setCookie: setCookie,
    isElementInViewport: isElementInViewport,
    onVisibilityChange: onVisibilityChange
};