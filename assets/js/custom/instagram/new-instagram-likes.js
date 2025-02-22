let checkButtonLikes = $('#ig_post_check');
let checkInputLikes = $('#instagram-url');
let submitBtnLikes = $('#ig_likes_submit');
let submitInputLikes = $('#total-likes');

let logoutBtn = jQuery('#logout'),
  poinFollowers = jQuery('#poin_likes'),
  usernameBar = jQuery('#user_name'),
  poinLikes = jQuery('#poin_likes');

(function ($) {
  function initLikeFeature() {
    let loginToken = getCookie('new_i_login_token');
    if (loginToken) {
      afterLoginLikes();
      logoutBtn.show();
      getProfileLike(loginToken);
    }

    $('#url-form').on('submit', function (e) {
      e.preventDefault();
      let targetURL = $('#instagram-url').val().trim();
      if (!targetURL) {
        let text = 'Masukkan URL Instagram terlebih dahulu!';
        clearAll(text);
        return;
      }

      if (!loginToken) {
        let text = 'Silakan login ulang.';
        clearAll(text);
        return;
      }

      let requestData = {
        action: 'fetch_instagram_media',
        token: loginToken,
        url: targetURL,
      };

      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: requestData,
        timeout: 60000,
        beforeSend: function () {
          addCheckBtnLoading();
          addDisableCheckInput();
        },
        success: function (response) {
          if (response.success) {
            sessionStorage.setItem('media_id', response.data.media_id);
            afterInputLinkLikes();
            $('#media-preview').html(`<img src="${response.data.media_url}" alt="Media Preview" style="max-width:100%;" width="200" height="200" class="img-fluid">`);
          } else {
            removeDisableCheckInput();
            removeCkeckBtnLoading();
            let text = 'Gagal Terjadi kesalahan';
            clearAll(text);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          removeDisableCheckInput();
          removeCkeckBtnLoading();
          let text = 'Terjadi Error Silahkan Hubungi admin - 025';
          clearAll(text);
        },
      });
    });

    $('#like-form').on('submit', function (e) {
      e.preventDefault();
      let mediaId = sessionStorage.getItem('media_id');
      let totalLikes = $('#total-likes').val();
      let maxPoint = parseInt(poinLikes.html());
      let subLike = parseInt(totalLikes);

      if (totalLikes < 1) {
        let text = 'Nilai tidak boleh kurang dari 1';
        clearAll(text);
        return;
      }

      if (subLike > maxPoint) {
        let text = 'Poin Anda tidak cukup';
        clearAll(text);
        return;
      }

      if (!mediaId || !totalLikes) {
        let text = 'MasukKan Jumlah Like yang anda inginkan.';
        clearAll(text);
        return;
      }

      let requestData = {
        action: 'like_instagram_media',
        token: loginToken,
        media_id: mediaId,
        total: totalLikes,
        nonce: new_login.nonce,
      };

      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: requestData,
        timeout: 60000,
        dataType: 'json',
        beforeSend: function () {
          addSubmitBtnLoading();
          addDisableSubmitInput();
        },
        success: function (response) {
          removeSubmitBtnLoading();
          removeDisableSubmitInput();
          if (response.success) {
            alertSuccess(response.data.success);
          } else {
            let text = 'Gagal Mengirim Like';
            clearAll(text);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          let text = 'Terjadi Error Silahkan Hubungi admin - 024';
          clearAll(text);
          removeSubmitBtnLoading();
          removeDisableSubmitInput();
        },
      });
    });
  }

  function getProfileLike(token) {
    $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: {
        action: 'ig_get_profile',
        token: token,
      },
      dataType: 'json',
      success: function (data) {
        usernameBar.html(data.username);
        poinLikes.html(data.like_credit);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        let text = 'Terjadi Error Silahkan Hubungi admin - 023';
        clearAll(text);
      },
    });
  }

  window.afterLoginLikes = function () {
    $('#url-form').show();
    $('#before_submit').hide();
    $('#like-form').hide();
  };

  function afterInputLinkLikes() {
    $('#url-form').hide();
    $('#like-form').show();
  }

  $(document).ready(function () {
    initLikeFeature();
  });
})(jQuery);

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
        document.cookie = 'new_i_login_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        location.reload();
      }
    });
});

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
      text: 'Kamu dapat ' + x + ' Likes Instagram gratis! Untuk Beli Followers, Views, dan Likes Instagram berkualitas terbaik dan terpercaya cukup klik tombol di bawah ini',
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

function addCheckBtnLoading() {
  checkButtonLikes.attr('disabled', 'disabled');
  checkButtonLikes.html("<span class='spinner-border spinner-border-sm' aria-hidden='true'></span><span style='margin-left:8px;' role='status'>Loading...</span>");
}

function addSubmitBtnLoading() {
  submitBtnLikes.attr('disabled', 'disabled');
  submitBtnLikes.html("<span class='spinner-border spinner-border-sm' aria-hidden='true'></span><span style='margin-left:8px;' role='status'>Loading...</span>");
}

function removeSubmitBtnLoading() {
  submitBtnLikes.removeAttr('disabled');
  submitBtnLikes.html('Submit');
}

function removeCkeckBtnLoading() {
  checkButtonLikes.removeAttr('disabled');
  checkButtonLikes.html('Submit');
}

function addDisableSubmitInput() {
  submitInputLikes.attr('disabled', 'disabled');
}

function addDisableCheckInput() {
  checkInputLikes.attr('disabled', 'disabled');
}

function removeDisableCheckInput() {
  checkInputLikes.removeAttr('disabled', 'disabled');
}

function removeDisableSubmitInput() {
  submitInputLikes.removeAttr('disabled', 'disabled');
}
