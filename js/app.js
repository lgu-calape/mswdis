const API = 'https://api.calape.ph/swdis/';
const LNA = 'N/A';
const LREQUIRED = 'Update required';

const BRGY = async () => {
    const r = await fetch(API + 'index.php?tbl=brgys',{credentials:'include'})
    return await r.json()
}

function get_age(d) {
    return Math.floor((new Date() - new Date(d).getTime()) / 3.15576e+10).toString();
}

function get_param(k) {
    return new URLSearchParams(window.location.search).get(k);
}

function is_valid_date(d) {
    return new Date(d).toString() != 'Invalid Date' ? true : false;
}