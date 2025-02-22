jQuery(function () {
  jQuery.getJSON('https://api.ipify.org?format=jsonp&callback=?', function (json) {
    setCookie('ip_user', json.ip, 30);
  });
});

function setCookie(cname, cvalue, exdays) {
  var now = new Date();
  now.setTime(now.getTime() + exdays * 1000);
  document.cookie = cname + '=' + cvalue + '; expires=' + now.toUTCString() + ';path=/';
}

function getCookie(cname) {
  let name = cname + '=';
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i].trim();
    if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
  }
  return '';
}
