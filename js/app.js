const API = 'https://api.calape.ph/swdis/';
const LNA = 'N/A';
const LREQUIRED = 'Update required';

function get_age(d) {
    return Math.floor((new Date() - new Date(d).getTime()) / 3.15576e+10);
}

function get_param(k) {
    return new URLSearchParams(window.location.search).get(k);
}