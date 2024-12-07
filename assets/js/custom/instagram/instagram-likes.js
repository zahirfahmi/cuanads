jQuery(function () {
  var $cekID = getCookie('i_order_id_l'),
    $cekLink = getCookie('i_link_likes'),
    $tableStatus = jQuery('.status_progress'),
    $tableLink = jQuery('#link_status_table'),
    $tableStatusFollow = jQuery('#status_progress_like'),
    $dataValidasi = getCookie('i_validate_l'),
    $readySubmit = jQuery('#ready_submit'),
    $beforeSubmit = jQuery('#before_submit');

  if ($dataValidasi) {
    $readySubmit.removeClass('d-none');
    $beforeSubmit.hide();
    jQuery('.alert').removeClass('d-none');

    if ($cekID != '') {
      $tableStatus.show();
      jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 'cek_status_tiktok',
          order_id: $cekID,
        },
        success: function (data) {
          var status_result = JSON.parse(data);
          $tableLink.html($cekLink);
          $tableStatusFollow.html(status_result.status);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {},
      });
    } else {
      $tableStatus.hide();
    }
  } else {
    // alert("kosong");
  }
});

jQuery('#ig_likes_form').on('submit', function (e) {
  e.preventDefault();
  addBtnLoading();
  var $urlLikes = jQuery('#ig_likes_input').val(),
    cekIP = getCookie('ip_user'),
    $dataValidasi = getCookie('i_validate_l');

  if ($dataValidasi) {
    if (cekIP) {
      jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 's_tracking_ig_likes',
          title: cekIP,
        },
        success: function (data) {
          let result = data.replace(/^\s+|\s+$/gm, '');
          if (result == 'next') {
            //start here
            jQuery.ajax({
              type: 'POST',
              url: ajaxurl,
              data: {
                action: 'ig_likes',
                link: $urlLikes,
              },
              success: function (data) {
                var resultLikes = JSON.parse(data);
                const order_id = resultLikes.status;
                var orderTrim = order_id.split(':').pop();
                orderTrim = orderTrim.replace('}', '');

                setCookie('i_link_likes', resultLikes.link, duration_i_likes);
                setCookie('i_order_id_l', orderTrim, duration_i_likes);

                if (orderTrim != '') {
                  // alertSuccess();
                } else {
                  Swal.fire('Ups!', 'Sepertinya ada gangguan, hubungi admin untuk info lebih lanjut.', 'danger').then(function () {
                    location.reload();
                  });
                }

                jQuery.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  data: {
                    action: 'tracking_ig_likes',
                    ipuser: cekIP,
                  },
                  success: function (data) {
                    removeBtnLoading();
                    alertSuccess();
                  },
                  error: function (XMLHttpRequest, textStatus, errorThrown) {
                    removeBtnLoading();
                    // alert("Fd");
                  },
                });
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                removeBtnLoading();
                // alert("Fd");
              },
            });
          } else {
            Swal.fire('Ups!', 'Kamu belum bisa submit, tunggu ' + duration_i_likes / 60 + ' menit setelah kamu submit..', 'info');
            removeBtnLoading();
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          removeBtnLoading();
          // alert("Fd");
        },
      });
    } else {
      jQuery.getJSON('https://api.ipify.org?format=jsonp&callback=?', function (json) {
        setCookie('ip_user', json.ip);
        Swal.fire('Ups!', 'Coba submit lagi', 'info');
        removeBtnLoading();
      });
    }
  } else {
    Swal.fire('Ups!', 'Kamu harus melewati validasi terlebih dahulu, sebelum menggunakan tools ini.', 'info').then(function (x) {
      location.reload();
    });
  }
});

function alertSuccess() {
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
      text: 'Kamu dapat Likes Instagram gratis! Untuk Beli Followers, Views, dan Likes Instagram berkualitas terbaik dan terpercaya cukup klik tombol di bawah ini',
      confirmButtonText: 'Beli sekarang',
      reverseButtons: true,
      showCloseButton: true,
    })
    .then(function (result) {
      if (result.isConfirmed) {
        window.location.href = '/harga';
      }
      if (result.isDismissed) {
        location.reload();
      }
    });
}

function clearAll(text) {
  document.getElementById('ig_likes_form').reset();
  removeBtnLoading();
  Swal.fire('Ups!', text, 'info');
}

function removeBtnLoading() {
  jQuery('#ig_likes_submit').removeAttr('disabled');
  jQuery('#ig_likes_submit').html('Submit');
}

function addBtnLoading() {
  jQuery('#ig_likes_submit').attr('disabled', 'disabled');
  jQuery('#ig_likes_submit').html("<span class='spinner-border spinner-border-sm' aria-hidden='true'></span><span style='margin-left:8px;' role='status'>Loading...</span>");
}
