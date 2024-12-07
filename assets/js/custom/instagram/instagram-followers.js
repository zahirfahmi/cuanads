//check
var token_ig = getCookie('i_login_token'),
  beforeSubmit = jQuery('#before_submit'),
  checkUsernameCard = jQuery('#check_username_body'),
  checkUsernameForm = jQuery('#check_username_form'),
  btnCheckFolls = jQuery('#ig_followers_check'),
  inputUsername = jQuery('#input_check_username');

//result check
var result_username = jQuery('#username'),
  result_post = jQuery('#post'),
  result_following = jQuery('#following'),
  result_followers = jQuery('#followers'),
  result_avatar = jQuery('#avatar'),
  body_submit = jQuery('#ig_followers_body');

//submit
var submitFollowersForm = jQuery('#ig_followers_form'),
  quantityFollowers = jQuery('#quantity_followers'),
  usernameFollowers = jQuery('#username_followers'),
  btnSubmit = jQuery('#ig_followers_submit');

//general
var logoutBtn = jQuery('#logout'),
  poinFollowers = jQuery('#poin_followers'),
  usernameBar = jQuery('#user_name');

jQuery(function ($) {
  if (token_ig) {
    hideLogin();
    logoutBtn.show();
    getProfile(token_ig); //get data profile
  }
});

checkUsernameForm.on('submit', function (e) {
  e.preventDefault();
  addBtnCheck();
  AddDisableCheck();

  if (inputUsername.val()) {
    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      data: {
        action: 'ig_check_username',
        username: inputUsername.val(),
        token: token_ig,
      },
      success: function (data) {
        body_submit.show();
        checkUsernameCard.hide();

        var dataParse = JSON.parse(data);
        var datainsideParse = JSON.parse(dataParse.data);

        result_avatar.attr('src', dataParse.avatar_ig);
        result_username.html('@' + datainsideParse.username);
        result_post.html(datainsideParse.media_count + ' Posts');
        result_following.html(datainsideParse.following_count + ' Following');
        result_followers.html(datainsideParse.follower_count + ' Followers');
        usernameFollowers.val(datainsideParse.username);
        removeBtnCheck();
        removeDisableCheck();
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        removeBtnCheck();
        removeDisableCheck();
      },
    });
  }
});

submitFollowersForm.on('submit', function (e) {
  e.preventDefault();
  addBtnSubmit();
  AddDisableSubmit();

  if (quantityFollowers.val() != '') {
    if (quantityFollowers.val() == '0') {
      var text = 'Sorry, nilai input tidak boleh diisi 0';
      clearAllz(text);

      removeBtnSubmit();
      removeDisableSubmit();
      return false;
    } else {
      jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 'ig_submit_followers',
          username: usernameFollowers.val(),
          total: quantityFollowers.val(),
          token: token_ig,
        },
        success: function (data) {
          var data_success = JSON.parse(data);

          if (data_success.message) {
            if (data_success.message == 'no credit follow') {
              var text = 'Sorry, poin kamu sudah habis. Tunggu 1 jam kedepan nanti poin akan kembali terisi.';
              clearAllz(text);
            }
          }

          if (data_success.data.success_total > 0) {
            alertSuccess(data_success.data.success_total);
          }

          removeBtnSubmit();
          removeDisableSubmit();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          removeBtnSubmit();
          removeDisableSubmit();
        },
      });
    }
  }
});

logoutBtn.on('click', function () {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-secondary ms-3',
      cancelButton: 'btn btn-light',
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: 'Apakah kamu yakin untuk logout?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Logout sekarang',
      cancelButtonText: 'Tutup',
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        document.cookie = 'i_login_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        location.reload();
      }
    });
});

function getProfile(x) {
  jQuery.ajax({
    type: 'POST',
    url: ajaxurl,
    data: {
      action: 'ig_get_profile',
      token: x,
    },
    success: function (data) {
      var dataParse = JSON.parse(data);
      poinFollowers.html(dataParse.follow_credit);
      usernameBar.html('@' + dataParse.username);
      jQuery('#user_name_vr').show();
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(textStatus);
    },
  });
}

function clearAllz(text) {
  document.getElementById('ig_followers_form').reset();
  removeBtnSubmit();
  removeDisableSubmit();
  Swal.fire('Ups!', text, 'info');
}

function alertSuccess(x) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success text-decoration-none',
    },
    buttonsStyling: true,
  });

  swal
    .fire({
      icon: 'success',
      title: 'Selamat!',
      text: 'Kamu dapat ' + x + ' Followers Instagram gratis! Untuk Beli Followers, Views, dan Likes Instagram berkualitas terbaik dan terpercaya cukup klik tombol di bawah ini',
      confirmButtonText: 'Beli sekarang',
      reverseButtons: true,
      showCloseButton: true,
      allowOutsideClick: false,
      allowEscapeKey: false,
    })
    .then(function (result) {
      if (result.isConfirmed) {
        window.location.href = url_harga;
      }
      if (result.isDismissed) {
        location.reload();
      }
    });
}

function hideLogin() {
  beforeSubmit.hide();
  checkUsernameCard.show();
}

function removeBtnCheck() {
  btnCheckFolls.removeAttr('disabled');
  btnCheckFolls.html('Check');
}

function removeBtnSubmit() {
  btnSubmit.removeAttr('disabled');
  btnSubmit.html('Submit');
}

function addBtnCheck() {
  btnCheckFolls.attr('disabled', 'disabled');
  btnCheckFolls.html("<span class='spinner-border spinner-border-sm' aria-hidden='true'></span><span style='margin-left:8px;' role='status'>Checking...</span>");
}

function addBtnSubmit() {
  btnSubmit.attr('disabled', 'disabled');
  btnSubmit.html("<span class='spinner-border spinner-border-sm' aria-hidden='true'></span><span style='margin-left:8px;' role='status'>Processing...</span>");
}

function AddDisableCheck() {
  inputUsername.attr('disabled', 'disabled');
}

function AddDisableSubmit() {
  btnSubmit.attr('disabled', 'disabled');
}

function removeDisableCheck() {
  inputUsername.removeAttr('disabled', 'disabled');
}

function removeDisableSubmit() {
  btnSubmit.removeAttr('disabled', 'disabled');
}
