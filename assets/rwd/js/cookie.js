import Helper from './_helper';

/**
 * Cookie
 */
document.addEventListener('DOMContentLoaded', function() {
    const cookieAcceptButton = document.querySelector('.cookie__button--accept');

    if(cookieAcceptButton !== null) {
        cookieAcceptButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const cookie = document.querySelector('.cookie');
            const body = document.getElementsByTagName('body')[0];

            cookie.classList.add('cookie--hidden');
            body.classList.remove('body--cookieInfo');
            Helper.setCookie('cookie_accept', 1, 365);
        });
    }
});
