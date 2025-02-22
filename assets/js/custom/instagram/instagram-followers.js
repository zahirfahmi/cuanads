// Cek variabel yang diperlukan
var token_ig = getCookie('new_i_login_token'),
  beforeSubmit = jQuery('#before_submit'),
  checkUsernameCard = jQuery('#check_username_body'),
  checkUsernameForm = jQuery('#check_username_form'),
  btnCheckFolls = jQuery('#ig_followers_check'),
  inputUsername = jQuery('#input_check_username');

// Hasil check username
var result_username = jQuery('#username'),
  result_post = jQuery('#post'),
  result_following = jQuery('#following'),
  result_followers = jQuery('#followers'),
  result_avatar = jQuery('#avatar'),
  body_submit = jQuery('#ig_followers_body');

// Submit followers
var submitFollowersForm = jQuery('#ig_followers_form'),
  quantityFollowers = jQuery('#quantity_followers'),
  usernameFollowers = jQuery('#username_followers'),
  btnSubmit = jQuery('#ig_followers_submit');

// General buttons
var logoutBtn = jQuery('#logout'),
  poinFollowers = jQuery('#poin_followers'),
  usernameBar = jQuery('#user_name');

// Fungsi utama
jQuery(function ($) {
  if (token_ig) {
    hideLogin();
    logoutBtn.show();
    getProfile(token_ig); // Mendapatkan data profil
  }
});

// Event handler untuk check username
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
      error: function () {
        removeBtnCheck();
        removeDisableCheck();
      },
    });
  }
});

// Event handler untuk submit followers
submitFollowersForm.on('submit', function (e) {
  e.preventDefault();
  addBtnSubmit();
  AddDisableSubmit();

  // Validasi input
  if (quantityFollowers.val() !== '') {
    if (quantityFollowers.val() == '0') {
      // Pastikan menggunakan == atau ===
      clearAllz('Sorry, nilai input tidak boleh diisi 0');
      removeBtnSubmit();
      removeDisableSubmit();
      return false;
    } else {
      jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json', // Pastikan response JSON
        data: {
          action: 'ig_submit_followers',
          username: usernameFollowers.val(),
          total: quantityFollowers.val(),
          token: token_ig,
        },
        success: function (data_success) {
          if (data_success.message && data_success.message === 'no credit follow') {
            // Gunakan === untuk perbandingan
            clearAllz('Sorry, poin kamu sudah habis. Tunggu 1 jam kedepan nanti poin akan kembali terisi.');
          }
          if (data_success.data.success_total > 0) {
            alertSuccess(data_success.data.success_total);
          }
          removeBtnSubmit();
          removeDisableSubmit();
        },
        error: function () {
          removeBtnSubmit();
          removeDisableSubmit();
        },
      });
    }
  }
});

// Event handler untuk logout
logoutBtn.on('click', function () {
  Swal.fire({
    title: 'Apakah kamu yakin untuk logout?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Logout sekarang',
    cancelButtonText: 'Tutup',
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      document.cookie = 'new_i_login_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
      location.reload();
    }
  });
});

// Fungsi mendapatkan profil
function getProfile(x) {
  jQuery.ajax({
    type: 'POST',
    url: ajaxurl,
    dataType: 'json', // Pastikan response dalam bentuk JSON
    data: {
      action: 'ig_get_profile',
      token: x,
    },
    success: function (data) {
      poinFollowers.html(data.follow_credit);
      usernameBar.html('@' + data.username);
      jQuery('#user_name_vr').show();
    },
    error: function (XMLHttpRequest, textStatus) {
      clearAllz(textStatus);
    },
  });
}

// Fungsi-fungsi lainnya
function clearAllz(text) {
  jQuery('#ig_followers_form')[0].reset();
  removeBtnSubmit();
  removeDisableSubmit();
  Swal.fire('Ups!', text, 'info');
}

function alertSuccess(x) {
  Swal.fire({
    icon: 'success',
    title: 'Selamat!',
    text: `Kamu dapat ${x} Followers Instagram gratis! Untuk Beli Followers, Views, dan Likes Instagram berkualitas terbaik dan terpercaya cukup klik tombol di bawah ini.`,
    confirmButtonText: 'Beli sekarang',
    showCloseButton: true,
    allowOutsideClick: false,
    allowEscapeKey: false,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url_harga;
    } else {
      location.reload();
    }
  });
}

function hideLogin() {
  beforeSubmit.hide();
  checkUsernameCard.show();
}

// Fungsi untuk menambah dan menghapus status loading
function addBtnCheck() {
  btnCheckFolls.attr('disabled', 'disabled').html("<span class='spinner-border spinner-border-sm'></span><span style='margin-left:8px;'>Checking...</span>");
}

function removeBtnCheck() {
  btnCheckFolls.removeAttr('disabled').html('Check');
}

function addBtnSubmit() {
  btnSubmit.attr('disabled', 'disabled').html("<span class='spinner-border spinner-border-sm'></span><span style='margin-left:8px;'>Processing...</span>");
}

function removeBtnSubmit() {
  btnSubmit.removeAttr('disabled').html('Submit');
}

function AddDisableCheck() {
  inputUsername.attr('disabled', 'disabled');
}

function AddDisableSubmit() {
  btnSubmit.attr('disabled', 'disabled');
}

function removeDisableCheck() {
  inputUsername.removeAttr('disabled');
}

function removeDisableSubmit() {
  btnSubmit.removeAttr('disabled');
}
