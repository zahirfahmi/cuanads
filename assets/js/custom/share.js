function copyToClipboard(element) {
  var $temp = $('<input>');
  $('body').append($temp);

  $temp.val($(element).text()).select();
  document.execCommand('copy');
  $temp.remove();

  var $toast = $('#copyToast');
  $toast.addClass('show');

  setTimeout(function () {
    $toast.removeClass('show');
  }, 2500);
}

$(document).ready(function () {
  $('.copy-link').on('click', function () {
    copyToClipboard('#link');
  });
});
