const API = 'https://api.calape.ph/swdis/';

function get_param(k) {
    return new URLSearchParams(window.location.search).get(k);
}