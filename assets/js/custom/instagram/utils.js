jQuery(document).ready(function ($) {
  window.Utils = {
    isValidURL: function (string) {
      var pattern = new RegExp('^(https?:\\/\\/)?' + "((([a-zA-Z0-9$_.+!*'(),;-]+\\.)+[a-zA-Z]{2,})|" + '((\\d{1,3}\\.){3}\\d{1,3}))' + '(\\:\\d+)?(\\/[-a-zA-Z0-9%_.~+]*)*' + '(\\?[;&a-zA-Z0-9%_.~+=-]*)?' + '(\\#[-a-zA-Z0-9_]*)?$', 'i');
      return pattern.test(string);
    },
  };
});

var loginBtn = jQuery('#ig_login_btn');

function addBtnLoading() {
  loginBtn.attr('disabled', 'disabled');
  loginBtn.html("<span class='spinner-border spinner-border-sm' aria-hidden='true'></span><span style='margin-left:8px;' role='status'>Loading...</span>");
}
