var data_json,
  $validate_f = jQuery('#tiktok_validate_f_btn'),
  $validate_l_ig = jQuery('#ig_validate_l_btn'),
  $tiktok_validate_l_btn = jQuery('#tiktok_validate_l_btn'),
  $tiktok_validate_v_btn = jQuery('#tiktok_validate_v_btn');

var onloadCallback = function (response) {
  grecaptcha.render('google_captcha', {
    sitekey: site_key_captcha,
    callback: verifyCallback,
  });
};

var verifyCallback = function (response) {
  document.getElementById('token').value = response;

  $validate_f.removeAttr('disabled').removeClass('disabled');
  $validate_f.on('click', function () {
    jQuery(this).addClass('disabled');
    setCookie('t_validate_f', token, durasi_validasi_f);

    if (getCookie('t_validate_f')) {
      location.href = url_t_followers;
    }
  });

  //tiktok likes validate
  $tiktok_validate_l_btn.removeAttr('disabled').removeClass('disabled');
  $tiktok_validate_l_btn.on('click', function () {
    jQuery(this).addClass('disabled');
    jQuery(this).attr('disabled', 'disabled');
    jQuery(this).html('Loading..');
    setCookie('t_validate_l', response, duration_t_likes);

    if (getCookie('t_validate_l')) {
      jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 'validate_token',
          token: response,
        },
        success: function (data) {
          $tiktok_validate_l_btn.removeAttr('disabled').removeClass('disabled');
          $tiktok_validate_l_btn.html('validate');
          var dataParse = JSON.parse(data);

          if (dataParse.success === true) {
            location.href = url_t_likes;
          } else {
            alert(dataParse.message);
            location.reload();
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert('Maaf terjadi kendala, refresh dan lakukan ulang');
          location.reload();
        },
      });
    }
  });

  //tiktok views validate
  $tiktok_validate_v_btn.removeAttr('disabled').removeClass('disabled');
  $tiktok_validate_v_btn.on('click', function () {
    jQuery(this).addClass('disabled');
    jQuery(this).attr('disabled', 'disabled');
    jQuery(this).html('Loading..');
    setCookie('t_validate_v', response, duration_t_views);

    if (getCookie('t_validate_v')) {
      jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 'validate_token',
          token: response,
        },
        success: function (data) {
          $tiktok_validate_v_btn.removeAttr('disabled').removeClass('disabled');
          $tiktok_validate_v_btn.html('validate');
          var dataParse = JSON.parse(data);

          if (dataParse.success === true) {
            location.href = url_t_views;
          } else {
            alert(dataParse.message);
            location.reload();
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert('Maaf terjadi kendala, refresh dan lakukan ulang');
          location.reload();
        },
      });
    }
  });
};
